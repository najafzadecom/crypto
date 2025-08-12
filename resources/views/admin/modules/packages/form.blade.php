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

                <form action="{{ $action }}" method="POST" id="packageForm">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Price') }} <span class="text-danger">*</span>:</label>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                                       placeholder="{{ __('Package price') }}"
                                       value="{{ old('price', $item->price ?? '') }}" required>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Currency') }} <span class="text-danger">*</span>:</label>
                                <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                                    <option value="USD" {{ old('currency', $item->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency', $item->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="AZN" {{ old('currency', $item->currency ?? '') == 'AZN' ? 'selected' : '' }}>AZN</option>
                                </select>
                                @error('currency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Duration (Days)') }}:</label>
                                <input type="number" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror"
                                       placeholder="{{ __('Leave empty for unlimited') }}"
                                       value="{{ old('duration_days', $item->duration_days ?? '') }}">
                                @error('duration_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Options') }}:</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_popular" value="1" class="form-check-input" 
                                           {{ old('is_popular', $item->is_popular ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ __('Popular Package') }}</label>
                                </div>
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
                                                       placeholder="{{ __('Package name') }}"
                                                       value="{{ old('translations.'.$loop->index.'.name', $translation->name ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Slug') }} <span class="text-danger">*</span>:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][slug]" 
                                                       class="form-control slug-input @error('translations.'.$loop->index.'.slug') is-invalid @enderror"
                                                       placeholder="{{ __('Package slug') }}"
                                                       value="{{ old('translations.'.$loop->index.'.slug', $translation->slug ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.slug')
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
                                                          placeholder="{{ __('Package description') }}">{{ old('translations.'.$loop->index.'.description', $translation->description ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Features') }}:</label>
                                                <textarea name="translations[{{ $loop->index }}][features]" 
                                                          class="form-control @error('translations.'.$loop->index.'.features') is-invalid @enderror"
                                                          rows="4"
                                                          placeholder="{{ __('Package features (one per line)') }}">{{ old('translations.'.$loop->index.'.features', $translation->features ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.features')
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-generate slug from name
            $('input[name*="[name]"]').on('input', function() {
                var nameInput = $(this);
                var slugInput = nameInput.closest('.border').find('input[name*="[slug]"]');
                
                if (slugInput.val() === '' || slugInput.data('auto-generated')) {
                    var slug = generateSlug(nameInput.val());
                    slugInput.val(slug).data('auto-generated', true);
                }
            });

            // Mark slug as manually edited
            $('input[name*="[slug]"]').on('input', function() {
                $(this).data('auto-generated', false);
            });

            // Generate slug function
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/ə/g, 'e')
                    .replace(/ı/g, 'i')
                    .replace(/ö/g, 'o')
                    .replace(/ü/g, 'u')
                    .replace(/ç/g, 'c')
                    .replace(/ş/g, 's')
                    .replace(/ğ/g, 'g')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
            }
        });
    </script>
@endpush
