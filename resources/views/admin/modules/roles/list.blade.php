@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.roles.create') }}" permission="roles-create"/>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <!-- Genel Arama ve Temel Filtreler -->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="{{ __('Role name') }}"
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
                                <label class="form-label">{{ __('Creation Date Range') }}</label>
                                <input type="text" id="creation_date_range" name="creation_date_range" 
                                       class="form-control daterange-picker" 
                                       placeholder="{{ __('Select date range') }}"
                                       value="{{ request('created_from') && request('created_to') ? request('created_from') . ' - ' . request('created_to') : '' }}">
                                <input type="hidden" name="created_from" value="{{ request('created_from') }}">
                                <input type="hidden" name="created_to" value="{{ request('created_to') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Update Date Range') }}</label>
                                <input type="text" id="update_date_range" name="update_date_range" 
                                       class="form-control daterange-picker" 
                                       placeholder="{{ __('Select date range') }}"
                                       value="{{ request('updated_from') && request('updated_to') ? request('updated_from') . ' - ' . request('updated_to') : '' }}">
                                <input type="hidden" name="updated_from" value="{{ request('updated_from') }}">
                                <input type="hidden" name="updated_to" value="{{ request('updated_to') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-labeled btn-labeled-start me-2">
                                    <span class="btn-labeled-icon bg-black bg-opacity-20">
                                        <i class="ph-magnifying-glass"></i>
                                    </span>
                                    {{ __('Search') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                    <i class="ph-x"></i>
                                    {{ __('Clear Filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                    <tr>
                        {!! sortableTableHeader('id', 'ID', 'roles') !!}
                        {!! sortableTableHeader('name', 'Name', 'roles') !!}
                        {!! sortableTableHeader('status', 'Status', 'roles') !!}
                        {!! sortableTableHeader('created_at', 'Created At', 'roles') !!}
                        {!! sortableTableHeader('updated_at', 'Updated At', 'roles') !!}
                        <th class="text-center" style="width: 20px;">
                            <i class="ph-dots-three"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{!! $item->coloredName  !!}</td>
                            <td>
                                {!! $item->status_html !!}
                            </td>
                            <td>{{ $item->created_at->isoFormat('DD MMM YYYY HH:mm') }}</td>
                            <td>{{ $item->updated_at->isoFormat('DD MMM YYYY HH:mm') }}</td>
                            <td>
                                @canany(['roles-show', 'roles-edit', 'roles-delete'])
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>

                                    <div class="dropdown-menu" data-popper-placement="top-start"
                                         data-popper-reference-hidden="">
                                        <div class="dropdown-header">{{ __('Options') }}</div>
                                        @can('roles-show')
                                        <a href="#" class="dropdown-item" data-url="{{ route('admin.roles.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#show_modal">
                                            <i class="ph-eye me-2"></i>
                                            {{ __('Show role') }}
                                        </a>
                                        @endcan
                                        @can('roles-edit')
                                        <a href="{{ route('admin.roles.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-pen me-2"></i>
                                            {{ __('Edit role') }}
                                        </a>
                                        @endcan
                                        @can('roles-delete')
                                        <a href="#" class="dropdown-item text-danger"
                                           data-delete-url="{{ route('admin.roles.destroy', $item->id) }}"
                                           data-item-name="{{ $item->name }} rolunu">
                                            <i class="ph-trash me-2"></i>
                                            {{ __('Delete role') }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">{{ __('Data not found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-6 d-flex align-items-center">
                        <label for="limit" class="me-2 mb-0">{{ __('Display') }}:</label>
                        <select id="limit" name="limit" class="form-select w-auto" onchange="changeLimit(this.value)">
                            @foreach(config('pagination.per_pages') as $limit)
                            <option value="{{ $limit }}"{{ request('limit', 25) == $limit ? ' selected' : '' }}>{{ $limit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        @if(method_exists($items, 'links'))
                            {{ $items->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="show_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Show role') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-semibold text-muted">{{ __('ID') }}:</div>
                        <div class="col-7 text-end" id="id">-</div>
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
        function initializeDateRangePickers() {
            $('.daterange-picker').each(function() {
                const $this = $(this);
                const fieldName = $this.attr('name');
                let startName, endName;
                
                if (fieldName === 'creation_date_range') {
                    startName = 'created_from';
                    endName = 'created_to';
                } else if (fieldName === 'update_date_range') {
                    startName = 'updated_from';
                    endName = 'updated_to';
                }
                
                $this.daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Temizle',
                        applyLabel: 'Uygula',
                        fromLabel: 'Başlangıç',
                        toLabel: 'Bitiş',
                        customRangeLabel: 'Özel',
                        format: 'YYYY-MM-DD',
                        daysOfWeek: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
                        monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                        firstDay: 1
                    },
                    ranges: {
                        'Bugün': [moment(), moment()],
                        'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Son 7 Gün': [moment().subtract(6, 'days'), moment()],
                        'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
                        'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
                        'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                });

                $this.on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    $('input[name="' + startName + '"]').val(picker.startDate.format('YYYY-MM-DD'));
                    $('input[name="' + endName + '"]').val(picker.endDate.format('YYYY-MM-DD'));
                });

                $this.on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    $('input[name="' + startName + '"]').val('');
                    $('input[name="' + endName + '"]').val('');
                });
            });
        }

        // Module-specific functionality for roles
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize daterange pickers
            initializeDateRangePickers();
        });
    </script>
@endpush
