@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.menus.create') }}" permission="menus-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="{{ __('Menu name') }}"
                                       value="{{ request('name') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Type') }}</label>
                                <select name="type" class="form-select">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="header"{{ request('type') == 'header' ? ' selected' : '' }}>{{ __('Header') }}</option>
                                    <option value="footer"{{ request('type') == 'footer' ? ' selected' : '' }}>{{ __('Footer') }}</option>
                                    <option value="sidebar"{{ request('type') == 'sidebar' ? ' selected' : '' }}>{{ __('Sidebar') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Status') }}</label>
                                <select name="status" class="form-select">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="1"{{ request('status') == '1' ? ' selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0"{{ request('status') == '0' ? ' selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-magnifying-glass me-2"></i>
                                        {{ __('Search') }}
                                    </button>
                                    <a href="{{ route('admin.menus.index') }}" class="btn btn-light">
                                        <i class="ph-x me-2"></i>
                                        {{ __('Clear') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                    <tr>
                        {!! sortableTableHeader('id', 'ID', 'menus') !!}
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Items') }}</th>
                        {!! sortableTableHeader('status', 'Status', 'menus') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'menus') !!}
                        <th class="text-center" style="width: 20px;">
                            <i class="ph-dots-three"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        @php
                            $defaultTranslation = $item->translations->where('locale', $defaultLocale)->first();
                            $name = $defaultTranslation?->name ?? $item->translations->first()?->name ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $name }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($item->type) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->items_count ?? 0 }} {{ __('items') }}</span>
                            </td>
                            <td>{!! $item->status_html !!}</td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                @canany(['menus-show', 'menus-edit', 'menus-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('menus-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.menus.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show menu') }}
                                        </a>
                                        @endcan
                                        @can('menus-edit')
                                        <a href="{{ route('admin.menus.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit menu') }}
                                        </a>
                                        @endcan
                                        @can('menu-items-index')
                                        <a href="{{ route('admin.menu-items.index', ['menu_id' => $item->id]) }}" class="dropdown-item">
                                            <i class="ph-list-bullets me-2"></i>
                                            {{ __('Manage items') }}
                                        </a>
                                        @endcan
                                        @can('menus-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.menus.destroy', $item->id) }}"
                                           data-item-name="{{ $name }}">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete menu') }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ph-list-bullets display-6 d-block mb-2"></i>
                                    {{ __('No menus found') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="pagination-info">
                        {{ __('Showing') }} {{ $items->firstItem() ?? 0 }} {{ __('to') }} {{ $items->lastItem() ?? 0 }}
                        {{ __('of') }} {{ $items->total() }} {{ __('results') }}
                    </div>
                    <div class="pagination-links">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
