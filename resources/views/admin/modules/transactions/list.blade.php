@extends('admin.layouts.app')

@section('content')
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                {{ $module }} - <span class="fw-normal">{{ $title }}</span>
            </h4>
        </div>

        <div class="d-lg-block my-lg-auto ms-lg-auto">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                <x-buttons.create :url="route('admin.transactions.create')" />
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">{{ __('Transactions List') }}</h5>
            <div class="ms-auto">
                <form method="GET" class="d-flex">
                    <div class="input-group">
                        <select name="status" class="form-select">
                            <option value="">{{ __('All Statuses') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                        </select>
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="ph-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Order') }}</th>
                        <th>{{ __('Gateway') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ $item->transaction_id }}</span>
                            @if($item->gateway_transaction_id)
                                <div class="text-muted small">{{ $item->gateway_transaction_id }}</div>
                            @endif
                        </td>
                        <td>
                            @if($item->user)
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $item->user->name }}</div>
                                        <div class="text-muted small">{{ $item->user->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">{{ __('No User') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($item->order)
                                <a href="{{ route('admin.orders.show', $item->order->id) }}" class="text-decoration-none">
                                    <span class="fw-semibold">#{{ $item->order->order_number }}</span>
                                </a>
                            @else
                                <span class="text-muted">{{ __('No Order') }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($item->payment_gateway) }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->currency }} {{ number_format($item->amount, 2) }}</div>
                        </td>
                        <td>{!! $item->type_badge !!}</td>
                        <td>{!! $item->status_badge !!}</td>
                        <td>
                            <span class="text-muted">{{ $item->created_at->format('d.m.Y H:i') }}</span>
                            @if($item->processed_at)
                                <div class="text-success small">
                                    {{ __('Processed') }}: {{ $item->processed_at->format('d.m.Y H:i') }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <x-buttons.show :id="$item->id" />
                                <x-buttons.edit :url="route('admin.transactions.edit', $item->id)" />
                                <x-buttons.delete :id="$item->id" />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">{{ __('No transactions found') }}</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
        <div class="card-footer">
            {{ $items->links() }}
        </div>
        @endif
    </div>

    <!-- Transaction Statistics -->
    <div class="row mt-3">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="d-flex align-items-center">
                    <i class="ph-currency-dollar-simple ph-2x text-success me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0">{{ $items->where('status', 'completed')->count() }}</h4>
                        <span class="text-muted">{{ __('Completed') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="d-flex align-items-center">
                    <i class="ph-clock ph-2x text-warning me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0">{{ $items->where('status', 'pending')->count() }}</h4>
                        <span class="text-muted">{{ __('Pending') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="d-flex align-items-center">
                    <i class="ph-x-circle ph-2x text-danger me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0">{{ $items->where('status', 'failed')->count() }}</h4>
                        <span class="text-muted">{{ __('Failed') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="d-flex align-items-center">
                    <i class="ph-arrow-counter-clockwise ph-2x text-info me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0">{{ $items->where('status', 'refunded')->count() }}</h4>
                        <span class="text-muted">{{ __('Refunded') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
