@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.static-blocks.create') }}" permission="static-blocks-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="{{ __('Block title') }}"
                                       value="{{ request('title') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Key') }}</label>
                                <input type="text" name="key" class="form-control"
                                       placeholder="{{ __('Block key') }}"
                                       value="{{ request('key') }}">
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
                                    <a href="{{ route('admin.static-blocks.index') }}" class="btn btn-light">
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
                        {!! sortableTableHeader('id', 'ID', 'static-blocks') !!}
                        <th>{{ __('Key') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Content') }}</th>
                        {!! sortableTableHeader('status', 'Status', 'static-blocks') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'static-blocks') !!}
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
                            $content = $defaultTranslation?->content ?? $item->translations->first()?->content ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->key }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ Str::limit($title, 40) }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">{{ Str::limit(strip_tags($content), 60) }}</div>
                            </td>
                            <td>{!! $item->status_html !!}</td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                @canany(['static-blocks-show', 'static-blocks-edit', 'static-blocks-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('static-blocks-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.static-blocks.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show block') }}
                                        </a>
                                        @endcan
                                        @can('static-blocks-edit')
                                        <a href="{{ route('admin.static-blocks.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit block') }}
                                        </a>
                                        @endcan
                                        @can('static-blocks-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.static-blocks.destroy', $item->id) }}"
                                           data-item-name="{{ $title }}">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete block') }}
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
                                    <i class="ph-squares-four display-6 d-block mb-2"></i>
                                    {{ __('No static blocks found') }}
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
