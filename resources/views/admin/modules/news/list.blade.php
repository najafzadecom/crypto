@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.news.create') }}" permission="news-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="{{ __('News title') }}"
                                       value="{{ request('title') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Featured') }}</label>
                                <select name="is_featured" class="form-select">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="1"{{ request('is_featured') == '1' ? ' selected' : '' }}>{{ __('Featured') }}</option>
                                    <option value="0"{{ request('is_featured') == '0' ? ' selected' : '' }}>{{ __('Not Featured') }}</option>
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
                                <label class="form-label">{{ __('Published Date') }}</label>
                                <input type="text" name="published_at" class="form-control daterange-picker"
                                       placeholder="{{ __('Select date range') }}"
                                       value="{{ request('published_at') }}">
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
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-light">
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
                        {!! sortableTableHeader('id', 'ID', 'news') !!}
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Featured') }}</th>
                        <th>{{ __('Published') }}</th>
                        {!! sortableTableHeader('status', 'Status', 'news') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'news') !!}
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
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $title }}" 
                                         class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="ph-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ Str::limit($title, 50) }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
                                </div>
                            </td>
                            <td>
                                @if($item->is_featured)
                                    <span class="badge bg-warning">{{ __('Featured') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->published_at)
                                    {{ $item->published_at->format('d.m.Y H:i') }}
                                @else
                                    <span class="text-muted">{{ __('Not published') }}</span>
                                @endif
                            </td>
                            <td>{!! $item->status_html !!}</td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                @canany(['news-show', 'news-edit', 'news-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('news-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.news.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show news') }}
                                        </a>
                                        @endcan
                                        @can('news-edit')
                                        <a href="{{ route('admin.news.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit news') }}
                                        </a>
                                        @endcan
                                        @can('news-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.news.destroy', $item->id) }}"
                                           data-item-name="{{ $title }}">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete news') }}
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
                                    <i class="ph-newspaper display-6 d-block mb-2"></i>
                                    {{ __('No news found') }}
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
