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

                <form action="{{ $action }}" method="POST" id="partnerForm" enctype="multipart/form-data">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Logo') }}:</label>
                                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
                                <div class="form-text">{{ __('Recommended size: 200x100px') }}</div>
                                @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                @if(isset($item) && $item->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="img-thumbnail" width="100">
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Order') }}:</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                                       placeholder="{{ __('Display order') }}"
                                       value="{{ old('order', $item->order ?? 0) }}">
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Status') }}:</label>
                                <div class="form-check">
                                    <input type="checkbox" name="status" value="1" class="form-check-input" 
                                           {{ old('status', $item->status ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Translation Fields -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{ __('Translations') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($languages as $language)
                                    @php
                                        $translation = isset($item) ? $item->translations->where('locale', $language->code)->first() : null;
                                    @endphp
                                    <div class="col-lg-4 mb-4">
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="badge bg-primary me-2">{{ strtoupper($language->code) }}</span>
                                                <span class="fw-semibold">{{ $language->name }}</span>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span>:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][name]" 
                                                       class="form-control @error('translations.'.$loop->index.'.name') is-invalid @enderror"
                                                       placeholder="{{ __('Partner name') }}"
                                                       value="{{ old('translations.'.$loop->index.'.name', $translation->name ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Description') }}:</label>
                                                <textarea name="translations[{{ $loop->index }}][description]" 
                                                          class="form-control @error('translations.'.$loop->index.'.description') is-invalid @enderror"
                                                          rows="3"
                                                          placeholder="{{ __('Partner description') }}">{{ old('translations.'.$loop->index.'.description', $translation->description ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Website') }}:</label>
                                                <input type="url" 
                                                       name="translations[{{ $loop->index }}][website]" 
                                                       class="form-control @error('translations.'.$loop->index.'.website') is-invalid @enderror"
                                                       placeholder="https://example.com"
                                                       value="{{ old('translations.'.$loop->index.'.website', $translation->website ?? '') }}">
                                                @error('translations.'.$loop->index.'.website')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="translations[{{ $loop->index }}][locale]" value="{{ $language->code }}">
                                        </div>
                                    </div>
                                @endforeach
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
