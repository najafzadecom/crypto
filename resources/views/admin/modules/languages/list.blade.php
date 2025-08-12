@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.languages.create') }}" permission="languages-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <!-- Genel Arama və Temel Filtreler -->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="{{ __('Language name') }}"
                                       value="{{ request('name') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Code') }}</label>
                                <input type="text" name="code" class="form-control"
                                       placeholder="{{ __('Language code') }}"
                                       value="{{ request('code') }}">
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
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-magnifying-glass me-2"></i>
                                    {{ __('Search') }}
                                </button>
                                <a href="{{ route('admin.languages.index') }}" class="btn btn-light">
                                    <i class="ph-x me-2"></i>
                                    {{ __('Clear') }}
                                </a>
                                <div class="btn-group ms-2">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-gear me-2"></i>
                                        {{ __('Actions') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('languages-create')
                                        <a href="{{ route('admin.languages.create') }}" class="dropdown-item">
                                            <i class="ph-plus me-2"></i>
                                            {{ __('Create Language') }}
                                        </a>
                                        @endcan
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item" onclick="exportData('excel')">
                                            <i class="ph-file-xls me-2"></i>
                                            {{ __('Export Excel') }}
                                        </a>
                                        <a href="#" class="dropdown-item" onclick="exportData('pdf')">
                                            <i class="ph-file-pdf me-2"></i>
                                            {{ __('Export PDF') }}
                                        </a>
                                    </div>
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
                        {!! sortableTableHeader('id', 'ID', 'languages') !!}
                        {!! sortableTableHeader('code', 'Code', 'languages') !!}
                        {!! sortableTableHeader('name', 'Name', 'languages') !!}
                        {!! sortableTableHeader('status', 'Status', 'languages') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'languages') !!}
                        {!! sortableTableHeader('updated_at', 'Updated At', 'languages') !!}
                        <th class="text-center" style="width: 20px;">
                            <i class="ph-dots-three"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $item->code }}</span>
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{!! $item->status_html !!}</td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $item->updated_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                @canany(['languages-show', 'languages-edit', 'languages-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end"
                                         data-popper-reference-hidden="">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('languages-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.languages.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show language') }}
                                        </a>
                                        @endcan
                                        @can('languages-edit')
                                        <a href="{{ route('admin.languages.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit language') }}
                                        </a>
                                        @endcan
                                        @can('languages-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.languages.destroy', $item->id) }}"
                                           data-item-name="{{ $item->name }} dilini">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete language') }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">{{ __('Data not found') }}</td>
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

    <div id="show_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Show language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('ID') }}:</div>
                        <div class="col-7 text-end" id="id">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('Code') }}:</div>
                        <div class="col-7 text-end" id="code">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('Name') }}:</div>
                        <div class="col-7 text-end" id="name">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('Status') }}:</div>
                        <div class="col-7 text-end" id="status">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('Created At') }}:</div>
                        <div class="col-7 text-end" id="created-at">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('Updated At') }}:</div>
                        <div class="col-7 text-end" id="updated-at">-</div>
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
                    $('#id').text(data.id);
                    $('#code').html('<span class="badge bg-light text-dark">' + data.code + '</span>');
                    $('#name').text(data.name);
                    $('#status').html(data.status_html);
                    $('#created-at').text(data.created_at_formatted);
                    $('#updated-at').text(data.updated_at_formatted);
                }).fail(function() {
                    alert('{{ __("Error loading data") }}');
                });
            }
        });

        // Export functionality
        function exportData(format) {
            var params = $('#searchForm').serialize();
            var url = '{{ route("admin.languages.index") }}?export=' + format + '&' + params;
            window.open(url, '_blank');
        }
    </script>
@endpush
