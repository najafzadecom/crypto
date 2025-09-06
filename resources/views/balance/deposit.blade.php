@extends('layouts.app')

@section('title', 'Balans artırma')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('profile.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Balans artırma</h5>
                </div>
                <div class="card-body">
                    @if(count($depositMethods) > 0)
                        <form action="{{ route('balance.deposit.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label">Ödəniş üsulu seçin</label>
                                <div class="row">
                                    @foreach($depositMethods as $method)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100 payment-method-card">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input payment-method-radio" 
                                                               type="radio" 
                                                               name="deposit_method_id" 
                                                               id="method_{{ $method->id }}" 
                                                               value="{{ $method->id }}"
                                                               data-type="{{ $method->type }}"
                                                               {{ old('deposit_method_id') == $method->id ? 'checked' : '' }}>
                                                        <label class="form-check-label w-100" for="method_{{ $method->id }}">
                                                            <h5>{{ $method->name }}</h5>
                                                            <div class="text-muted small">
                                                                Limit: {{ number_format($method->min_amount, 2) }} - {{ number_format($method->max_amount, 2) }} {{ $method->currency }}
                                                            </div>
                                                            @if($method->fee_percentage > 0 || $method->fee_fixed > 0)
                                                                <div class="text-muted small">
                                                                    Komissiya: 
                                                                    @if($method->fee_percentage > 0)
                                                                        {{ $method->fee_percentage }}%
                                                                    @endif
                                                                    @if($method->fee_fixed > 0)
                                                                        @if($method->fee_percentage > 0) + @endif
                                                                        {{ number_format($method->fee_fixed, 2) }} {{ $method->currency }}
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('deposit_method_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Məbləğ</label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" 
                                           name="amount" 
                                           step="0.01" 
                                           min="1" 
                                           value="{{ old('amount') }}" 
                                           required>
                                    <span class="input-group-text">AZN</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div id="crypto_fields" class="d-none">
                                <div class="mb-3">
                                    <label for="crypto_address" class="form-label">Kripto ünvanı</label>
                                    <input type="text" 
                                           class="form-control @error('crypto_address') is-invalid @enderror" 
                                           id="crypto_address" 
                                           name="crypto_address" 
                                           value="{{ old('crypto_address') }}">
                                    @error('crypto_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="crypto_transaction_id" class="form-label">Əməliyyat ID</label>
                                    <input type="text" 
                                           class="form-control @error('crypto_transaction_id') is-invalid @enderror" 
                                           id="crypto_transaction_id" 
                                           name="crypto_transaction_id" 
                                           value="{{ old('crypto_transaction_id') }}">
                                    @error('crypto_transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="screenshot" class="form-label">Ödəniş təsdiqi (screenshot)</label>
                                    <input type="file" 
                                           class="form-control @error('screenshot') is-invalid @enderror" 
                                           id="screenshot" 
                                           name="screenshot">
                                    @error('screenshot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Balans artır</button>
                                <a href="{{ route('balance.index') }}" class="btn btn-outline-secondary ms-2">Geri qayıt</a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Hazırda aktiv ödəniş üsulu yoxdur. Zəhmət olmasa daha sonra yenidən cəhd edin.
                        </div>
                        <a href="{{ route('balance.index') }}" class="btn btn-outline-secondary">Geri qayıt</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodRadios = document.querySelectorAll('.payment-method-radio');
        const cryptoFields = document.getElementById('crypto_fields');
        
        function toggleCryptoFields() {
            const selectedMethod = document.querySelector('.payment-method-radio:checked');
            if (selectedMethod && selectedMethod.dataset.type === 'crypto') {
                cryptoFields.classList.remove('d-none');
            } else {
                cryptoFields.classList.add('d-none');
            }
        }
        
        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', toggleCryptoFields);
        });
        
        // Initial check
        toggleCryptoFields();
        
        // Style for payment method cards
        const paymentMethodCards = document.querySelectorAll('.payment-method-card');
        paymentMethodCards.forEach(card => {
            const radio = card.querySelector('.payment-method-radio');
            
            card.addEventListener('click', function() {
                radio.checked = true;
                toggleCryptoFields();
            });
            
            radio.addEventListener('change', function() {
                paymentMethodCards.forEach(c => {
                    c.classList.remove('border-primary');
                });
                
                if (this.checked) {
                    card.classList.add('border-primary');
                }
            });
            
            if (radio.checked) {
                card.classList.add('border-primary');
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .payment-method-card {
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .payment-method-card:hover {
        border-color: #0d6efd;
    }
    
    .payment-method-card.border-primary {
        border-width: 2px;
    }
</style>
@endpush
@endsection
