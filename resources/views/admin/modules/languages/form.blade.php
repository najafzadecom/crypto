@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger border-0 alert-dismissible fade show">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endforeach
                @endif

                <form action="{{ $action }}" method="POST">
                    @method($method)
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Code') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                placeholder="{{ __('Language code (e.g., az, en, tr)') }}"
                                value="{{ old('code', $item->code ?? '') }}"
                                maxlength="10"
                            />
                            <div class="form-text">{{ __('Enter a unique language code (maximum 10 characters)') }}</div>
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Locale') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="locale"
                                class="form-control @error('locale') is-invalid @enderror"
                                placeholder="{{ __('Language locale (e.g., az_AZ, en_US)') }}"
                                value="{{ old('locale', $item->locale ?? '') }}"
                                maxlength="10"
                            />
                            <div class="form-text">{{ __('Enter a unique language locale (maximum 10 characters)') }}</div>
                            @error('locale')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Name') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="{{ __('Language name') }}"
                                value="{{ old('name', $item->name ?? '') }}"
                            />
                            <div class="form-text">{{ __('Enter the full name of the language') }}</div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Flag') }}:</label>
                        <div class="col-lg-9">
                            <select name="flag" class="form-control @error('flag') is-invalid @enderror">
                                <option value="">{{ __('Select flag') }}</option>
                                @foreach($flagIcons as $file => $name)
                                    <option value="{{ $file }}" {{ old('flag', $item->flag ?? '') == $file ? 'selected' : '' }}>{{ __(ucfirst($name)) }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">{{ __('Select a flag icon for the language') }}</div>
                            @error('flag')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="mt-2">
                                <div id="flag-preview" class="d-flex align-items-center">
                                    @if(isset($item) && $item->flag)
                                        <img src="{{ asset('admin/assets/images/lang/' . $item->flag) }}" alt="{{ $item->name }}" height="20" class="me-2">
                                        <span>{{ $item->flag }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Status') }}:</label>
                        <div class="col-lg-9">
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $item->status ?? 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="0" {{ old('status', $item->status ?? 1) == 0 ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                            </select>
                            <div class="form-text">{{ __('Select the status of the language') }}</div>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-danger" onclick="history.back()">
                            <i class="ph-arrow-left me-2"></i> {{ __('Back') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }} <i class="ph-paper-plane-tilt ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($item) && $item->exists)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Language Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">{{ __('Created At') }}</label>
                        <div class="fw-semibold">{{ $item->created_at->format('d.m.Y H:i:s') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">{{ __('Updated At') }}</label>
                        <div class="fw-semibold">{{ $item->updated_at->format('d.m.Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Code sahəsini avtomatik olaraq kiçik hərflərə çevir
            $('input[name="code"]').on('input', function() {
                this.value = this.value.toLowerCase().replace(/[^a-z0-9]/g, '');
            });
            
            // Locale sahəsini avtomatik olaraq düzgün formata çevir
            $('input[name="locale"]').on('input', function() {
                this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
            });
            
            // Bayraq önizləməsini göstər
            $('select[name="flag"]').on('change', function() {
                var flagValue = $(this).val();
                var flagPreview = $('#flag-preview');
                
                if (flagValue) {
                    var flagUrl = '{{ asset("admin/assets/images/lang") }}/' + flagValue;
                    flagPreview.html('<img src="' + flagUrl + '" alt="Flag" height="20" class="me-2"><span>' + flagValue + '</span>');
                } else {
                    flagPreview.html('');
                }
            });
            
            // İlk yükləmədə bayraq seçilmişsə önizləməsini göstər
            $('select[name="flag"]').trigger('change');

            // Form validation
            $('form').on('submit', function(e) {
                var code = $('input[name="code"]').val();
                var locale = $('input[name="locale"]').val();
                var name = $('input[name="name"]').val();

                if (!code.trim()) {
                    e.preventDefault();
                    alert('{{ __("Language code is required") }}');
                    $('input[name="code"]').focus();
                    return false;
                }
                
                if (!locale.trim()) {
                    e.preventDefault();
                    alert('{{ __("Language locale is required") }}');
                    $('input[name="locale"]').focus();
                    return false;
                }

                if (!name.trim()) {
                    e.preventDefault();
                    alert('{{ __("Language name is required") }}');
                    $('input[name="name"]').focus();
                    return false;
                }

                if (code.length > 10) {
                    e.preventDefault();
                    alert('{{ __("Language code cannot be longer than 10 characters") }}');
                    $('input[name="code"]').focus();
                    return false;
                }
                
                if (locale.length > 10) {
                    e.preventDefault();
                    alert('{{ __("Language locale cannot be longer than 10 characters") }}');
                    $('input[name="locale"]').focus();
                    return false;
                }
            });
        });
    </script>
@endpush
