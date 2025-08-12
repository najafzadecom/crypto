@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.menu-items.create') }}" permission="menu-items-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Menu') }}</label>
                                <select name="menu_id" class="form-select">
                                    <option value="">{{ __('All Menus') }}</option>
                                    @foreach($menus ?? [] as $menu)
                                        <option value="{{ $menu->id }}"{{ request('menu_id') == $menu->id ? ' selected' : '' }}>
                                            {{ $menu->translations->first()?->name ?? $menu->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="{{ __('Menu item title') }}"
                                       value="{{ request('title') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Target') }}</label>
                                <select name="target" class="form-select">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="_self"{{ request('target') == '_self' ? ' selected' : '' }}>{{ __('Same Window') }}</option>
                                    <option value="_blank"{{ request('target') == '_blank' ? ' selected' : '' }}>{{ __('New Window') }}</option>
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

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-magnifying-glass me-2"></i>
                                        {{ __('Search') }}
                                    </button>
                                    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-light">
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
                        {!! sortableTableHeader('id', 'ID', 'menu-items') !!}
                        <th>{{ __('Menu') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('URL') }}</th>
                        <th>{{ __('Order') }}</th>
                        <th>{{ __('Target') }}</th>
                        {!! sortableTableHeader('status', 'Status', 'menu-items') !!}
                        <th class="text-center" style="width: 20px;">
                            <i class="ph-dots-three"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        @php
                            $defaultTranslation = $item->translations->where('locale', $defaultLocale)->first();
                            $title = $defaultTranslation?->title ?? $item->translations->first()?->title ?? '-';
                            $menuName = $item->menu?->translations->where('locale', $defaultLocale)->first()?->name ?? 
                                       $item->menu?->translations->first()?->name ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $menuName }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $title }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
                                    @if($item->parent_id)
                                        <span class="badge bg-info ms-1">{{ __('Sub Item') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($item->url)
                                    <a href="{{ $item->url }}" target="_blank" class="text-primary">
                                        {{ Str::limit($item->url, 40) }}
                                        <i class="ph-arrow-square-out ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->order }}</span>
                            </td>
                            <td>
                                @if($item->target)
                                    <span class="badge bg-light text-dark">{{ $item->target }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{!! $item->status_html !!}</td>
                            <td class="text-center">
                                @canany(['menu-items-show', 'menu-items-edit', 'menu-items-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('menu-items-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.menu-items.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show item') }}
                                        </a>
                                        @endcan
                                        @can('menu-items-edit')
                                        <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit item') }}
                                        </a>
                                        @endcan
                                        @can('menu-items-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.menu-items.destroy', $item->id) }}"
                                           data-item-name="{{ $title }}">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete item') }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ph-list-bullets display-6 d-block mb-2"></i>
                                    {{ __('No menu items found') }}
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
