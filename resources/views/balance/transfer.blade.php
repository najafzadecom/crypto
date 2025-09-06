@extends('layouts.app')

@section('title', 'Daxili köçürmə')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('profile.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daxili köçürmə</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5>Daxili köçürmə haqqında</h5>
                        <p>Bu funksiya vasitəsilə balansınızı digər istifadəçilərə köçürə bilərsiniz. Köçürmə dərhal və təsdiqsiz həyata keçirilir.</p>
                        <ul>
                            <p class="mb-1"><strong>Köçürmə parametrləri:</strong></p>
                            <li>Minimum məbləğ: {{ number_format($transferSettings->min_amount, 2) }} {{ $transferSettings->currency }}</li>
                            <li>Maksimum məbləğ: {{ number_format($transferSettings->max_amount, 2) }} {{ $transferSettings->currency }}</li>
                            @if($transferSettings->fee_percentage > 0 || $transferSettings->fee_fixed > 0)
                                <li>
                                    Komissiya: 
                                    @if($transferSettings->fee_percentage > 0)
                                        {{ $transferSettings->fee_percentage }}%
                                    @endif
                                    @if($transferSettings->fee_fixed > 0)
                                        @if($transferSettings->fee_percentage > 0) + @endif
                                        {{ number_format($transferSettings->fee_fixed, 2) }} {{ $transferSettings->currency }}
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Mövcud balans</h6>
                        </div>
                        <div class="card-body">
                            <h3 class="text-primary">{{ number_format($balance->amount, 2) }} {{ $balance->currency }}</h3>
                        </div>
                    </div>
                    
                    <form action="{{ route('balance.transfer.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="recipient" class="form-label">Alıcı (istifadəçi adı, email və ya ID)</label>
                            <input type="text" 
                                   class="form-control @error('recipient') is-invalid @enderror" 
                                   id="recipient" 
                                   name="recipient" 
                                   value="{{ old('recipient') }}" 
                                   required>
                            <div class="form-text">Alıcının istifadəçi adı, email ünvanı və ya ID-sini daxil edin</div>
                            @error('recipient')
                                <div class="invalid-feedback">{{ $message }}</div>
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
                                       min="{{ $transferSettings->min_amount }}" 
                                       max="{{ min($transferSettings->max_amount, $balance->amount) }}" 
                                       value="{{ old('amount') }}" 
                                       required>
                                <span class="input-group-text">{{ $balance->currency }}</span>
                            </div>
                            <div class="form-text">
                                Minimum: {{ number_format($transferSettings->min_amount, 2) }} {{ $balance->currency }}, 
                                Maksimum: {{ number_format(min($transferSettings->max_amount, $balance->amount), 2) }} {{ $balance->currency }}
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Təsvir (ixtiyari)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" id="transfer-btn">Köçürməni təsdiqlə</button>
                            <a href="{{ route('balance.index') }}" class="btn btn-outline-secondary ms-2">Geri qayıt</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const transferBtn = document.getElementById('transfer-btn');
        const form = amountInput.closest('form');
        
        form.addEventListener('submit', function(e) {
            const amount = parseFloat(amountInput.value);
            const fee = {{ $transferSettings->fee_percentage / 100 }} * amount + {{ $transferSettings->fee_fixed }};
            const total = amount + fee;
            
            if (!confirm(`Köçürmə məbləği: ${amount.toFixed(2)} {{ $balance->currency }}\nKomissiya: ${fee.toFixed(2)} {{ $balance->currency }}\nCəmi: ${total.toFixed(2)} {{ $balance->currency }}\n\nKöçürməni təsdiqləyirsiniz?`)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection
