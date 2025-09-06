@extends('layouts.app')

@section('title', 'Balans artırma təsdiqi')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('profile.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Balans artırma təsdiqi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5>Sorğunuz qəbul edildi!</h5>
                        <p>Balans artırma sorğunuz sistemə qeyd edildi. Sorğunuz təsdiq edildikdən sonra balansınız avtomatik artırılacaq.</p>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Əməliyyat detalları</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Əməliyyat ID</th>
                                        <td>{{ $transaction->transaction_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tarix</th>
                                        <td>{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Məbləğ</th>
                                        <td>{{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{!! $transaction->status_badge !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Ödəniş üsulu</th>
                                        <td>{{ $depositMethod->name ?? 'Bilinməyən' }}</td>
                                    </tr>
                                    @if($transaction->crypto_address)
                                        <tr>
                                            <th>Kripto ünvanı</th>
                                            <td>{{ $transaction->crypto_address }}</td>
                                        </tr>
                                    @endif
                                    @if($transaction->crypto_transaction_id)
                                        <tr>
                                            <th>Kripto əməliyyat ID</th>
                                            <td>{{ $transaction->crypto_transaction_id }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($depositMethod && $depositMethod->type === 'crypto')
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Ödəniş məlumatları</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($depositMethod->qr_code)
                                        <div class="col-md-6 text-center mb-3">
                                            <h6>QR kod</h6>
                                            <img src="{{ asset('storage/' . $depositMethod->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                        </div>
                                    @endif
                                    
                                    <div class="col-md-{{ $depositMethod->qr_code ? '6' : '12' }}">
                                        @if($depositMethod->deposit_address)
                                            <div class="mb-3">
                                                <h6>Depozit ünvanı</h6>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="{{ $depositMethod->deposit_address }}" id="deposit_address" readonly>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('deposit_address')">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </div>
                                                <div class="form-text">Köçürməni bu ünvana edin</div>
                                            </div>
                                        @endif
                                        
                                        @if($depositMethod->instructions)
                                            <div class="mt-3">
                                                <h6>Təlimatlar</h6>
                                                <div class="alert alert-light">
                                                    {!! nl2br(e($depositMethod->instructions)) !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('balance.index') }}" class="btn btn-primary">Balans səhifəsinə qayıt</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');
        
        // Show tooltip or notification
        alert('Mətn kopyalandı!');
    }
</script>
@endpush
@endsection
