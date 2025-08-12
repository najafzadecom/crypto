@extends('admin.layouts.app')

@section('content')
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                {{ __('Transactions') }} - <span class="fw-normal">{{ $title }}</span>
            </h4>
        </div>
    </div>
</div>

<div class="content">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method($method)

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Transaction Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('User') }} <span class="text-danger">*</span></label>
                                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">{{ __('Select User') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ old('user_id', $item->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Order') }}</label>
                                    <select name="order_id" class="form-select @error('order_id') is-invalid @enderror">
                                        <option value="">{{ __('Select Order') }}</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}" 
                                                {{ old('order_id', $item->order_id ?? '') == $order->id ? 'selected' : '' }}>
                                                #{{ $order->order_number }} - ${{ number_format($order->total_amount, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Transaction ID') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" 
                                           value="{{ old('transaction_id', $item->transaction_id ?? 'TXN-' . time()) }}" required>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Gateway Transaction ID') }}</label>
                                    <input type="text" name="gateway_transaction_id" class="form-control @error('gateway_transaction_id') is-invalid @enderror" 
                                           value="{{ old('gateway_transaction_id', $item->gateway_transaction_id ?? '') }}" 
                                           placeholder="{{ __('ID from payment gateway') }}">
                                    @error('gateway_transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Payment Gateway') }} <span class="text-danger">*</span></label>
                                    <select name="payment_gateway" class="form-select @error('payment_gateway') is-invalid @enderror" required>
                                        <option value="">{{ __('Select Gateway') }}</option>
                                        <option value="stripe" {{ old('payment_gateway', $item->payment_gateway ?? '') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                        <option value="paypal" {{ old('payment_gateway', $item->payment_gateway ?? '') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="bank_transfer" {{ old('payment_gateway', $item->payment_gateway ?? '') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="crypto" {{ old('payment_gateway', $item->payment_gateway ?? '') == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                                        <option value="manual" {{ old('payment_gateway', $item->payment_gateway ?? '') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    </select>
                                    @error('payment_gateway')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Currency') }}</label>
                                    <select name="currency" class="form-select @error('currency') is-invalid @enderror">
                                        <option value="USD" {{ old('currency', $item->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('currency', $item->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="AZN" {{ old('currency', $item->currency ?? '') == 'AZN' ? 'selected' : '' }}>AZN</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amount" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           value="{{ old('amount', $item->amount ?? '') }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Type') }}</label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                                        <option value="payment" {{ old('type', $item->type ?? 'payment') == 'payment' ? 'selected' : '' }}>
                                            {{ __('Payment') }}
                                        </option>
                                        <option value="refund" {{ old('type', $item->type ?? '') == 'refund' ? 'selected' : '' }}>
                                            {{ __('Refund') }}
                                        </option>
                                        <option value="chargeback" {{ old('type', $item->type ?? '') == 'chargeback' ? 'selected' : '' }}>
                                            {{ __('Chargeback') }}
                                        </option>
                                        <option value="fee" {{ old('type', $item->type ?? '') == 'fee' ? 'selected' : '' }}>
                                            {{ __('Fee') }}
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Failure Reason') }}</label>
                            <textarea name="failure_reason" rows="2" class="form-control @error('failure_reason') is-invalid @enderror" 
                                      placeholder="{{ __('Reason for failure (if applicable)...') }}">{{ old('failure_reason', $item->failure_reason ?? '') }}</textarea>
                            @error('failure_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                      placeholder="{{ __('Additional notes about this transaction...') }}">{{ old('notes', $item->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if(isset($item) && $item->gateway_response)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Gateway Response') }}</h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($item->gateway_response, JSON_PRETTY_PRINT) }}</code></pre>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Status & Settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Transaction Status') }}</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', $item->status ?? 'pending') == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="processing" {{ old('status', $item->status ?? '') == 'processing' ? 'selected' : '' }}>
                                    {{ __('Processing') }}
                                </option>
                                <option value="completed" {{ old('status', $item->status ?? '') == 'completed' ? 'selected' : '' }}>
                                    {{ __('Completed') }}
                                </option>
                                <option value="failed" {{ old('status', $item->status ?? '') == 'failed' ? 'selected' : '' }}>
                                    {{ __('Failed') }}
                                </option>
                                <option value="cancelled" {{ old('status', $item->status ?? '') == 'cancelled' ? 'selected' : '' }}>
                                    {{ __('Cancelled') }}
                                </option>
                                <option value="refunded" {{ old('status', $item->status ?? '') == 'refunded' ? 'selected' : '' }}>
                                    {{ __('Refunded') }}
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(isset($item) && $item->exists)
                        <div class="mb-3">
                            <label class="form-label">{{ __('Processed At') }}</label>
                            <input type="datetime-local" name="processed_at" class="form-control @error('processed_at') is-invalid @enderror" 
                                   value="{{ old('processed_at', $item->processed_at?->format('Y-m-d\TH:i')) }}">
                            @error('processed_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if(isset($item) && $item->exists)
                        <div class="alert alert-light">
                            <h6 class="alert-heading">{{ __('Transaction Details') }}</h6>
                            <p class="mb-1"><strong>{{ __('Created') }}:</strong> {{ $item->created_at->format('d.m.Y H:i:s') }}</p>
                            <p class="mb-0"><strong>{{ __('Updated') }}:</strong> {{ $item->updated_at->format('d.m.Y H:i:s') }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-link">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Transaction') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
