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

                <form action="{{ $action }}" method="POST" id="staticBlockForm">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Key') }} <span class="text-danger">*</span>:</label>
                                <input type="text" name="key" class="form-control @error('key') is-invalid @enderror"
                                       placeholder="{{ __('Unique block key (e.g., about-us)') }}"
                                       value="{{ old('key', $item->key ?? '') }}" required>
                                <div class="form-text">{{ __('Unique identifier for this block') }}</div>
                                @error('key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
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
                                    <div class="col-lg-12 mb-4">
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="badge bg-primary me-2">{{ strtoupper($language->code) }}</span>
                                                <span class="fw-semibold">{{ $language->name }}</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span>:</label>
                                                        <input type="text" 
                                                               name="translations[{{ $loop->index }}][title]" 
                                                               class="form-control @error('translations.'.$loop->index.'.title') is-invalid @enderror"
                                                               placeholder="{{ __('Block title') }}"
                                                               value="{{ old('translations.'.$loop->index.'.title', $translation->title ?? '') }}"
                                                               required>
                                                        @error('translations.'.$loop->index.'.title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Slug') }} <span class="text-danger">*</span>:</label>
                                                        <input type="text" 
                                                               name="translations[{{ $loop->index }}][slug]" 
                                                               class="form-control slug-input @error('translations.'.$loop->index.'.slug') is-invalid @enderror"
                                                               placeholder="{{ __('Block slug') }}"
                                                               value="{{ old('translations.'.$loop->index.'.slug', $translation->slug ?? '') }}"
                                                               required>
                                                        @error('translations.'.$loop->index.'.slug')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Content') }} <span class="text-danger">*</span>:</label>
                                                <textarea name="translations[{{ $loop->index }}][content]" 
                                                          class="form-control editor @error('translations.'.$loop->index.'.content') is-invalid @enderror"
                                                          rows="8"
                                                          placeholder="{{ __('Block content') }}"
                                                          required>{{ old('translations.'.$loop->index.'.content', $translation->content ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.content')
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
            // Auto-generate slug from title
            $('input[name*="[title]"]').on('input', function() {
                var titleInput = $(this);
                var slugInput = titleInput.closest('.border').find('input[name*="[slug]"]');
                
                if (slugInput.val() === '' || slugInput.data('auto-generated')) {
                    var slug = generateSlug(titleInput.val());
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

            // Auto-generate key from first title
            var firstTitleInput = $('input[name*="[title]"]').first();
            if (firstTitleInput.length && !$('input[name="key"]').val()) {
                firstTitleInput.on('input', function() {
                    var keyInput = $('input[name="key"]');
                    if (!keyInput.data('manually-edited')) {
                        var key = generateSlug($(this).val());
                        keyInput.val(key);
                    }
                });
            }

            // Mark key as manually edited
            $('input[name="key"]').on('input', function() {
                $(this).data('manually-edited', true);
            });

            // Form validation
            $('#staticBlockForm').on('submit', function(e) {
                var hasValidTranslation = false;
                
                $('input[name*="[title]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasValidTranslation = true;
                        return false;
                    }
                });

                if (!hasValidTranslation) {
                    e.preventDefault();
                    alert('{{ __("At least one language title is required") }}');
                    $('input[name*="[title]"]').first().focus();
                    return false;
                }
            });
        });
    </script>
@endpush
