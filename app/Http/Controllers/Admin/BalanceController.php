<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BalanceAdjustmentRequest;
use App\Http\Requests\Admin\DepositMethodRequest;
use App\Http\Requests\Admin\TransferSettingRequest;
use App\Models\Balance;
use App\Models\BalanceTransaction;
use App\Models\DepositMethod;
use App\Models\TransferSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    /**
     * Display a listing of the user balances.
     */
    public function index()
    {
        $balances = Balance::with('user')->latest()->paginate(15);
        return view('admin.modules.balances.index', compact('balances'));
    }
    
    /**
     * Display a listing of the balance transactions.
     */
    public function transactions(Request $request)
    {
        $query = BalanceTransaction::with(['user', 'sender']);
        
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $transactions = $query->latest()->paginate(15);
        return view('admin.modules.balances.transactions', compact('transactions'));
    }
    
    /**
     * Show the form for adjusting a user's balance.
     */
    public function showAdjustmentForm($userId)
    {
        $user = User::findOrFail($userId);
        $balances = $user->balances;
        
        return view('admin.modules.balances.adjust', compact('user', 'balances'));
    }
    
    /**
     * Adjust a user's balance.
     */
    public function adjustBalance(BalanceAdjustmentRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        DB::transaction(function () use ($user, $request) {
            $balance = $user->getOrCreateBalance($request->currency);
            
            if ($request->adjustment_type === 'increase') {
                $balance->increase($request->amount);
                $type = 'admin_adjustment';
                $description = "Admin tərəfindən balans artırma: {$request->amount} {$request->currency}";
            } else {
                if (!$balance->hasEnough($request->amount)) {
                    throw new \Exception('İstifadəçinin kifayət qədər balansı yoxdur.');
                }
                
                $balance->decrease($request->amount);
                $type = 'admin_adjustment';
                $description = "Admin tərəfindən balans azaltma: {$request->amount} {$request->currency}";
            }
            
            // Create transaction record
            BalanceTransaction::create([
                'user_id' => $user->id,
                'transaction_id' => BalanceTransaction::generateTransactionId(),
                'type' => $type,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'status' => 'completed',
                'description' => $description,
                'notes' => $request->notes,
                'completed_at' => now()
            ]);
        });
        
        return redirect()->route('admin.balances.index')
            ->with('success', 'İstifadəçi balansı uğurla yeniləndi.');
    }
    
    /**
     * Display a listing of the pending deposit transactions.
     */
    public function pendingDeposits()
    {
        $deposits = BalanceTransaction::with('user')
            ->where('type', 'deposit')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
            
        return view('admin.modules.balances.pending-deposits', compact('deposits'));
    }
    
    /**
     * Approve a pending deposit.
     */
    public function approveDeposit($id)
    {
        $deposit = BalanceTransaction::where('type', 'deposit')
            ->where('status', 'pending')
            ->findOrFail($id);
            
        DB::transaction(function () use ($deposit) {
            // Get user balance
            $user = User::findOrFail($deposit->user_id);
            $balance = $user->getOrCreateBalance($deposit->currency);
            
            // Calculate net amount (after fees)
            $netAmount = $deposit->amount;
            if (isset($deposit->metadata['fee'])) {
                $netAmount -= $deposit->metadata['fee'];
            }
            
            // Increase user balance
            $balance->increase($netAmount);
            
            // Mark transaction as completed
            $deposit->markAsCompleted();
        });
        
        return back()->with('success', 'Depozit uğurla təsdiqləndi.');
    }
    
    /**
     * Reject a pending deposit.
     */
    public function rejectDeposit(Request $request, $id)
    {
        $deposit = BalanceTransaction::where('type', 'deposit')
            ->where('status', 'pending')
            ->findOrFail($id);
            
        $deposit->markAsCancelled($request->notes);
        
        return back()->with('success', 'Depozit rədd edildi.');
    }
    
    /**
     * Display a listing of deposit methods.
     */
    public function depositMethods()
    {
        $depositMethods = DepositMethod::latest()->paginate(15);
        return view('admin.modules.balances.deposit-methods', compact('depositMethods'));
    }
    
    /**
     * Show the form for creating a new deposit method.
     */
    public function createDepositMethod()
    {
        return view('admin.modules.balances.deposit-method-form');
    }
    
    /**
     * Store a newly created deposit method.
     */
    public function storeDepositMethod(DepositMethodRequest $request)
    {
        $data = $request->validated();
        
        // Handle file upload for QR code if provided
        if ($request->hasFile('qr_code')) {
            $path = $request->file('qr_code')->store('deposit_methods', 'public');
            $data['qr_code'] = $path;
        }
        
        DepositMethod::create($data);
        
        return redirect()->route('admin.balances.deposit-methods')
            ->with('success', 'Ödəniş üsulu uğurla yaradıldı.');
    }
    
    /**
     * Show the form for editing a deposit method.
     */
    public function editDepositMethod($id)
    {
        $depositMethod = DepositMethod::findOrFail($id);
        return view('admin.modules.balances.deposit-method-form', compact('depositMethod'));
    }
    
    /**
     * Update the specified deposit method.
     */
    public function updateDepositMethod(DepositMethodRequest $request, $id)
    {
        $depositMethod = DepositMethod::findOrFail($id);
        $data = $request->validated();
        
        // Handle file upload for QR code if provided
        if ($request->hasFile('qr_code')) {
            $path = $request->file('qr_code')->store('deposit_methods', 'public');
            $data['qr_code'] = $path;
        }
        
        $depositMethod->update($data);
        
        return redirect()->route('admin.balances.deposit-methods')
            ->with('success', 'Ödəniş üsulu uğurla yeniləndi.');
    }
    
    /**
     * Display a listing of transfer settings.
     */
    public function transferSettings()
    {
        $transferSettings = TransferSetting::latest()->paginate(15);
        return view('admin.modules.balances.transfer-settings', compact('transferSettings'));
    }
    
    /**
     * Show the form for creating a new transfer setting.
     */
    public function createTransferSetting()
    {
        return view('admin.modules.balances.transfer-setting-form');
    }
    
    /**
     * Store a newly created transfer setting.
     */
    public function storeTransferSetting(TransferSettingRequest $request)
    {
        TransferSetting::create($request->validated());
        
        return redirect()->route('admin.balances.transfer-settings')
            ->with('success', 'Köçürmə parametrləri uğurla yaradıldı.');
    }
    
    /**
     * Show the form for editing a transfer setting.
     */
    public function editTransferSetting($id)
    {
        $transferSetting = TransferSetting::findOrFail($id);
        return view('admin.modules.balances.transfer-setting-form', compact('transferSetting'));
    }
    
    /**
     * Update the specified transfer setting.
     */
    public function updateTransferSetting(TransferSettingRequest $request, $id)
    {
        $transferSetting = TransferSetting::findOrFail($id);
        $transferSetting->update($request->validated());
        
        return redirect()->route('admin.balances.transfer-settings')
            ->with('success', 'Köçürmə parametrləri uğurla yeniləndi.');
    }
}
