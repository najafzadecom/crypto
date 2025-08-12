@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.categories.create') }}" permission="categories-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="{{ __('Category name') }}"
                                       value="{{ request('name') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
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
                                <label class="form-label">{{ __('Created Date') }}</label>
                                <input type="text" name="created_at" class="form-control daterange-picker"
                                       placeholder="{{ __('Select date range') }}"
                                       value="{{ request('created_at') }}">
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
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
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
                        {!! sortableTableHeader('id', 'ID', 'categories') !!}
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Icon') }}</th>
                        {!! sortableTableHeader('status', 'Status', 'categories') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'categories') !!}
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
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $name }}" 
                                         class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="ph-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $name }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
                                </div>
                            </td>
                            <td>
                                @if($item->icon)
                                    <i class="{{ $item->icon }} text-primary"></i>
                                    <span class="text-muted ms-1">{{ $item->icon }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{!! $item->status_html !!}</td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                @canany(['categories-show', 'categories-edit', 'categories-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('categories-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.categories.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show category') }}
                                        </a>
                                        @endcan
                                        @can('categories-edit')
                                        <a href="{{ route('admin.categories.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit category') }}
                                        </a>
                                        @endcan
                                        @can('categories-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.categories.destroy', $item->id) }}"
                                           data-item-name="{{ $name }}">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete category') }}
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
                                    <i class="ph-folder-open display-6 d-block mb-2"></i>
                                    {{ __('No categories found') }}
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

    <!-- Show Modal -->
    <div id="show_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Category Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-3 fw-semibold text-muted">{{ __('ID') }}:</div>
                        <div class="col-9" id="modal-id">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 fw-semibold text-muted">{{ __('Image') }}:</div>
                        <div class="col-9" id="modal-image">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 fw-semibold text-muted">{{ __('Icon') }}:</div>
                        <div class="col-9" id="modal-icon">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 fw-semibold text-muted">{{ __('Status') }}:</div>
                        <div class="col-9" id="modal-status">-</div>
                    </div>
                    
                    <!-- Translations -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-muted mb-2">{{ __('Translations') }}:</h6>
                            <div id="modal-translations"></div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3 fw-semibold text-muted">{{ __('Created At') }}:</div>
                        <div class="col-9" id="modal-created-at">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 fw-semibold text-muted">{{ __('Updated At') }}:</div>
                        <div class="col-9" id="modal-updated-at">-</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize daterange pickers
        $('.daterange-picker').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: '{{ __("Clear") }}',
                applyLabel: '{{ __("Apply") }}',
                format: 'DD.MM.YYYY'
            }
        });

        $('.daterange-picker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        });

        $('.daterange-picker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Show modal functionality
        $('#show_modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');

            if (url) {
                $.get(url, function(data) {
                    $('#modal-id').text(data.id);
                    
                    // Image
                    if (data.image) {
                        $('#modal-image').html('<img src="/storage/' + data.image + '" alt="Image" class="rounded" style="max-width: 100px; max-height: 100px;">');
                    } else {
                        $('#modal-image').text('-');
                    }
                    
                    // Icon
                    if (data.icon) {
                        $('#modal-icon').html('<i class="' + data.icon + ' me-2"></i>' + data.icon);
                    } else {
                        $('#modal-icon').text('-');
                    }
                    
                    $('#modal-status').html(data.status_html);
                    
                    // Translations
                    var translationsHtml = '';
                    if (data.translations && data.translations.length > 0) {
                        data.translations.forEach(function(translation) {
                            translationsHtml += '<div class="border rounded p-2 mb-2">';
                            translationsHtml += '<div class="d-flex justify-content-between align-items-center mb-1">';
                            translationsHtml += '<span class="badge bg-primary">' + translation.locale.toUpperCase() + '</span>';
                            translationsHtml += '</div>';
                            translationsHtml += '<div><strong>{{ __("Name") }}:</strong> ' + translation.name + '</div>';
                            translationsHtml += '<div><strong>{{ __("Slug") }}:</strong> ' + translation.slug + '</div>';
                            if (translation.description) {
                                translationsHtml += '<div><strong>{{ __("Description") }}:</strong> ' + translation.description + '</div>';
                            }
                            translationsHtml += '</div>';
                        });
                    } else {
                        translationsHtml = '<div class="text-muted">{{ __("No translations found") }}</div>';
                    }
                    $('#modal-translations').html(translationsHtml);
                    
                    $('#modal-created-at').text(data.created_at_formatted);
                    $('#modal-updated-at').text(data.updated_at_formatted);
                }).fail(function() {
                    alert('{{ __("Error loading data") }}');
                });
            }
        });
    </script>
@endpush
