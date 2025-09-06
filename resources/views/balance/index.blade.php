@extends('layouts.app')

@section('title', 'Balans')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('profile.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Balansım</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($balances as $balance)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $balance->currency }} Balansı</h5>
                                        <h3 class="text-primary">{{ number_format($balance->amount, 2) }} {{ $balance->currency }}</h3>
                                        <div class="mt-3">
                                            <a href="{{ route('balance.deposit') }}" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="bi bi-plus-circle"></i> Balans artır
                                            </a>
                                            <a href="{{ route('balance.transfer') }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-arrow-left-right"></i> Köçürmə et
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Hələ balansınız yoxdur. Balans artırmaq üçün aşağıdakı düyməni klikləyin.
                                </div>
                                <a href="{{ route('balance.deposit') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Balans artır
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Son əməliyyatlar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tarix</th>
                                    <th>Əməliyyat</th>
                                    <th>Məbləğ</th>
                                    <th>Status</th>
                                    <th>Təsvir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                                        <td>{!! $transaction->type_badge !!}</td>
                                        <td class="{{ in_array($transaction->type, ['deposit', 'transfer_in']) ? 'text-success' : 'text-danger' }}">
                                            {{ in_array($transaction->type, ['deposit', 'transfer_in']) ? '+' : '-' }}
                                            {{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}
                                        </td>
                                        <td>{!! $transaction->status_badge !!}</td>
                                        <td>{{ $transaction->description }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Hələ heç bir əməliyyat etməmisiniz.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
