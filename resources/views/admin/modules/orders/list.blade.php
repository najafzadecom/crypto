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
                <x-buttons.create :url="route('admin.orders.create')" />
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">{{ __('Orders List') }}</h5>
            <div class="ms-auto">
                <form method="GET" class="d-flex">
                    <div class="input-group">
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
                        <th>{{ __('Order Number') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Package') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Payment Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>
                            <span class="fw-semibold">#{{ $item->order_number }}</span>
                        </td>
                        <td>
                            @if($item->user)
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $item->user->name }}</div>
                                        <div class="text-muted">{{ $item->user->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">{{ __('No User') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($item->package)
                                <span class="fw-semibold">{{ $item->package->translations->where('locale', 'az')->first()?->name ?? 'N/A' }}</span>
                            @else
                                <span class="text-muted">{{ __('No Package') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">${{ number_format($item->total_amount, 2) }}</div>
                            @if($item->discount_amount > 0)
                                <small class="text-muted">
                                    {{ __('Original') }}: ${{ number_format($item->amount, 2) }}
                                </small>
                            @endif
                        </td>
                        <td>{!! $item->status_badge !!}</td>
                        <td>{!! $item->payment_status_badge !!}</td>
                        <td>
                            <span class="text-muted">{{ $item->created_at->format('d.m.Y H:i') }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <x-buttons.show :id="$item->id" />
                                <x-buttons.edit :url="route('admin.orders.edit', $item->id)" />
                                <x-buttons.delete :id="$item->id" />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">{{ __('No orders found') }}</div>
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
</div>
@endsection
