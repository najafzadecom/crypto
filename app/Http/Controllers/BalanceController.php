<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Models\Balance;
use App\Models\BalanceTransaction;
use App\Models\DepositMethod;
use App\Models\TransferSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    /**
     * Display the user's balance page.
     */
    public function index()
    {
        $user = Auth::user();
        $balances = $user->balances;
        $transactions = $user->balanceTransactions()->latest()->paginate(10);
        $depositMethods = DepositMethod::where('active', true)->get();
        
        return view('balance.index', compact('balances', 'transactions', 'depositMethods'));
    }
    
    /**
     * Show the deposit form.
     */
    public function showDepositForm()
    {
        $depositMethods = DepositMethod::where('active', true)->get();
        return view('balance.deposit', compact('depositMethods'));
    }
    
    /**
     * Process a deposit request.
     */
    public function deposit(DepositRequest $request)
    {
        $user = Auth::user();
        $depositMethod = DepositMethod::findOrFail($request->deposit_method_id);
        
        if (!$depositMethod->active) {
            return back()->with('error', 'Bu ödəniş üsulu hazırda aktiv deyil.');
        }
        
        if (!$depositMethod->isAmountValid($request->amount)) {
            return back()->with('error', "Məbləğ {$depositMethod->min_amount} və {$depositMethod->max_amount} arasında olmalıdır.");
        }
        
        $fee = $depositMethod->calculateFee($request->amount);
        $transaction = DB::transaction(function () use ($user, $depositMethod, $request, $fee) {
            // Create transaction record
            $transaction = BalanceTransaction::create([
                'user_id' => $user->id,
                'transaction_id' => BalanceTransaction::generateTransactionId(),
                'type' => 'deposit',
                'amount' => $request->amount,
                'currency' => $depositMethod->currency,
                'payment_method' => $depositMethod->type,
                'crypto_address' => $request->crypto_address,
                'crypto_transaction_id' => $request->crypto_transaction_id,
                'status' => 'pending',
                'description' => "Balans artırma ({$depositMethod->name})",
                'metadata' => [
                    'deposit_method_id' => $depositMethod->id,
                    'fee' => $fee,
                    'net_amount' => $request->amount - $fee
                ]
            ]);
            
            // If it's a card payment, we could process it automatically here
            // For crypto or manual methods, admin needs to approve
            
            return $transaction;
        });
        
        // For card payments, we would process the payment here and update the transaction status
        // For crypto or manual deposits, redirect to a confirmation page
        
        return redirect()->route('balance.deposit.confirm', $transaction->id)
            ->with('success', 'Balans artırma sorğunuz qeydə alındı.');
    }
    
    /**
     * Show deposit confirmation page.
     */
    public function showDepositConfirmation($id)
    {
        $transaction = BalanceTransaction::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('type', 'deposit')
            ->firstOrFail();
            
        $depositMethod = DepositMethod::find($transaction->metadata['deposit_method_id'] ?? null);
        
        return view('balance.deposit-confirm', compact('transaction', 'depositMethod'));
    }
    
    /**
     * Show the transfer form.
     */
    public function showTransferForm()
    {
        $user = Auth::user();
        $balance = $user->getOrCreateBalance('AZN');
        $transferSettings = TransferSetting::where('currency', 'AZN')->where('active', true)->first();
        
        if (!$transferSettings) {
            return back()->with('error', 'Daxili köçürmə funksiyası hazırda aktiv deyil.');
        }
        
        return view('balance.transfer', compact('balance', 'transferSettings'));
    }
    
    /**
     * Process a transfer request.
     */
    public function transfer(TransferRequest $request)
    {
        $sender = Auth::user();
        $transferSettings = TransferSetting::where('currency', 'AZN')->where('active', true)->firstOrFail();
        
        if (!$transferSettings->isAmountValid($request->amount)) {
            return back()->with('error', "Məbləğ {$transferSettings->min_amount} və {$transferSettings->max_amount} arasında olmalıdır.");
        }
        
        // Find recipient by username, email or id
        $recipient = User::where('username', $request->recipient)
            ->orWhere('email', $request->recipient)
            ->first();
            
        if (!$recipient) {
            return back()->with('error', 'İstifadəçi tapılmadı.');
        }
        
        if ($recipient->id === $sender->id) {
            return back()->with('error', 'Özünüzə köçürmə edə bilməzsiniz.');
        }
        
        $senderBalance = $sender->getOrCreateBalance('AZN');
        $recipientBalance = $recipient->getOrCreateBalance('AZN');
        
        $fee = $transferSettings->calculateFee($request->amount);
        $totalAmount = $request->amount + $fee;
        
        if (!$senderBalance->hasEnough($totalAmount)) {
            return back()->with('error', 'Kifayət qədər balansınız yoxdur.');
        }
        
        DB::transaction(function () use ($sender, $recipient, $senderBalance, $recipientBalance, $request, $fee, $transferSettings) {
            // Decrease sender's balance
            $senderBalance->decrease($request->amount + $fee);
            
            // Increase recipient's balance
            $recipientBalance->increase($request->amount);
            
            // Create outgoing transaction for sender
            $outgoingTransaction = BalanceTransaction::create([
                'user_id' => $sender->id,
                'sender_id' => $sender->id,
                'transaction_id' => BalanceTransaction::generateTransactionId(),
                'type' => 'transfer_out',
                'amount' => $request->amount,
                'currency' => 'AZN',
                'status' => 'completed',
                'description' => "Köçürmə: {$recipient->username} ({$recipient->email})",
                'notes' => $request->description,
                'metadata' => [
                    'recipient_id' => $recipient->id,
                    'fee' => $fee
                ],
                'completed_at' => now()
            ]);
            
            // Create incoming transaction for recipient
            $incomingTransaction = BalanceTransaction::create([
                'user_id' => $recipient->id,
                'sender_id' => $sender->id,
                'transaction_id' => BalanceTransaction::generateTransactionId(),
                'type' => 'transfer_in',
                'amount' => $request->amount,
                'currency' => 'AZN',
                'status' => 'completed',
                'description' => "Daxil olan köçürmə: {$sender->username} ({$sender->email})",
                'notes' => $request->description,
                'metadata' => [
                    'sender_id' => $sender->id
                ],
                'completed_at' => now()
            ]);
        });
        
        return redirect()->route('balance.index')->with('success', 'Köçürmə uğurla həyata keçirildi.');
    }
}
