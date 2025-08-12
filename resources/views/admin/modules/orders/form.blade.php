@extends('admin.layouts.app')

@section('content')
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                {{ __('Orders') }} - <span class="fw-normal">{{ $title }}</span>
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
                        <h5 class="mb-0">{{ __('Order Information') }}</h5>
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
                                    <label class="form-label">{{ __('Package') }}</label>
                                    <select name="package_id" class="form-select @error('package_id') is-invalid @enderror">
                                        <option value="">{{ __('Select Package') }}</option>
                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}" 
                                                data-price="{{ $package->price }}"
                                                {{ old('package_id', $item->package_id ?? '') == $package->id ? 'selected' : '' }}>
                                                {{ $package->translations->where('locale', 'az')->first()?->name ?? 'N/A' }} 
                                                (${{ number_format($package->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('package_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Order Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="order_number" class="form-control @error('order_number') is-invalid @enderror" 
                                           value="{{ old('order_number', $item->order_number ?? 'ORD-' . time()) }}" required>
                                    @error('order_number')
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
                            <div class="col-md-4">
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Discount Amount') }}</label>
                                    <input type="number" step="0.01" name="discount_amount" 
                                           class="form-control @error('discount_amount') is-invalid @enderror" 
                                           value="{{ old('discount_amount', $item->discount_amount ?? 0) }}">
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Total Amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_amount" 
                                           class="form-control @error('total_amount') is-invalid @enderror" 
                                           value="{{ old('total_amount', $item->total_amount ?? '') }}" required>
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Method') }}</label>
                            <input type="text" name="payment_method" class="form-control @error('payment_method') is-invalid @enderror" 
                                   value="{{ old('payment_method', $item->payment_method ?? '') }}" 
                                   placeholder="{{ __('e.g., Credit Card, PayPal, Bank Transfer') }}">
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                      placeholder="{{ __('Additional notes about this order...') }}">{{ old('notes', $item->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Status & Settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Order Status') }}</label>
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

                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Status') }}</label>
                            <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                                <option value="unpaid" {{ old('payment_status', $item->payment_status ?? 'unpaid') == 'unpaid' ? 'selected' : '' }}>
                                    {{ __('Unpaid') }}
                                </option>
                                <option value="paid" {{ old('payment_status', $item->payment_status ?? '') == 'paid' ? 'selected' : '' }}>
                                    {{ __('Paid') }}
                                </option>
                                <option value="partially_paid" {{ old('payment_status', $item->payment_status ?? '') == 'partially_paid' ? 'selected' : '' }}>
                                    {{ __('Partially Paid') }}
                                </option>
                                <option value="refunded" {{ old('payment_status', $item->payment_status ?? '') == 'refunded' ? 'selected' : '' }}>
                                    {{ __('Refunded') }}
                                </option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(isset($item) && $item->exists)
                        <div class="mb-3">
                            <label class="form-label">{{ __('Completed At') }}</label>
                            <input type="datetime-local" name="completed_at" class="form-control @error('completed_at') is-invalid @enderror" 
                                   value="{{ old('completed_at', $item->completed_at?->format('Y-m-d\TH:i')) }}">
                            @error('completed_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-link">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Order') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.querySelector('select[name="package_id"]');
    const amountInput = document.querySelector('input[name="amount"]');
    const discountInput = document.querySelector('input[name="discount_amount"]');
    const totalInput = document.querySelector('input[name="total_amount"]');

    // Auto-fill amount when package is selected
    packageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const price = parseFloat(selectedOption.dataset.price) || 0;
            amountInput.value = price.toFixed(2);
            calculateTotal();
        }
    });

    // Calculate total when amount or discount changes
    function calculateTotal() {
        const amount = parseFloat(amountInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;
        const total = Math.max(0, amount - discount);
        totalInput.value = total.toFixed(2);
    }

    amountInput.addEventListener('input', calculateTotal);
    discountInput.addEventListener('input', calculateTotal);
});
</script>
@endsection
