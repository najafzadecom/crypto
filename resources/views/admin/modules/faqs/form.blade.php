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

                <form action="{{ $action }}" method="POST" id="faqForm">
                    @method($method)
                    @csrf

                    <!-- Status -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Status') }}:</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status', $item->status ?? 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ old('status', $item->status ?? 1) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
                                                        <label class="form-label">{{ __('Question') }} <span class="text-danger">*</span>:</label>
                                                        <input type="text" 
                                                               name="translations[{{ $loop->index }}][question]" 
                                                               class="form-control @error('translations.'.$loop->index.'.question') is-invalid @enderror"
                                                               placeholder="{{ __('FAQ question') }}"
                                                               value="{{ old('translations.'.$loop->index.'.question', $translation->question ?? '') }}"
                                                               required>
                                                        @error('translations.'.$loop->index.'.question')
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
                                                               placeholder="{{ __('FAQ slug') }}"
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
                                                <label class="form-label">{{ __('Answer') }} <span class="text-danger">*</span>:</label>
                                                <textarea name="translations[{{ $loop->index }}][answer]" 
                                                          class="form-control editor @error('translations.'.$loop->index.'.answer') is-invalid @enderror"
                                                          rows="6"
                                                          placeholder="{{ __('FAQ answer') }}"
                                                          required>{{ old('translations.'.$loop->index.'.answer', $translation->answer ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.answer')
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
            // Auto-generate slug from question
            $('input[name*="[question]"]').on('input', function() {
                var questionInput = $(this);
                var slugInput = questionInput.closest('.border').find('input[name*="[slug]"]');
                
                if (slugInput.val() === '' || slugInput.data('auto-generated')) {
                    var slug = generateSlug(questionInput.val());
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

            // Form validation
            $('#faqForm').on('submit', function(e) {
                var hasValidTranslation = false;
                
                $('input[name*="[question]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasValidTranslation = true;
                        return false;
                    }
                });

                if (!hasValidTranslation) {
                    e.preventDefault();
                    alert('{{ __("At least one language question is required") }}');
                    $('input[name*="[question]"]').first().focus();
                    return false;
                }
            });
        });
    </script>
@endpush
