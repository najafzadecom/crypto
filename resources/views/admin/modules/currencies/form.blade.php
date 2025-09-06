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

                <form action="{{ $action }}" method="POST" id="currencyForm">
                    @method($method)
                    @csrf

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span>:</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="{{ __('Currency name') }}"
                                       value="{{ old('name', $item->name ?? '') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Code') }} <span class="text-danger">*</span>:</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                       placeholder="{{ __('e.g. USD, EUR, GBP') }}" maxlength="3"
                                       value="{{ old('code', $item->code ?? '') }}" required>
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Symbol') }} <span class="text-danger">*</span>:</label>
                                <input type="text" name="symbol" class="form-control @error('symbol') is-invalid @enderror"
                                       placeholder="{{ __('e.g. $, €, £') }}" maxlength="10"
                                       value="{{ old('symbol', $item->symbol ?? '') }}" required>
                                @error('symbol')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Rate') }} <span class="text-danger">*</span>:</label>
                                <input type="number" step="0.00000001" name="rate" class="form-control @error('rate') is-invalid @enderror"
                                       placeholder="{{ __('Exchange rate') }}"
                                       value="{{ old('rate', $item->rate ?? '1') }}" required>
                                <div class="form-text">{{ __('Exchange rate relative to the base currency') }}</div>
                                @error('rate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Options') }}:</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_default" value="1" class="form-check-input" 
                                           {{ old('is_default', $item->is_default ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ __('Default Currency') }}</label>
                                    <div class="form-text">{{ __('Only one currency can be default. Setting this as default will unset any other default currency.') }}</div>
                                </div>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="status" value="1" class="form-check-input" 
                                           {{ old('status', $item->status ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light" onclick="history.back()">
                            <i class="ph-arrow-left me-2"></i> {{ __('Back') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }} <i class="ph-check ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
