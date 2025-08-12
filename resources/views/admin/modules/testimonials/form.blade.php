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

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="testimonialForm">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Photo') }}:</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <div class="form-text">{{ __('Client photo (optional)') }}</div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                @if(isset($item) && $item->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Current photo" 
                                             class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div class="text-muted small mt-1">{{ __('Current photo') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Company') }}:</label>
                                <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                                       placeholder="{{ __('Company name') }}"
                                       value="{{ old('company', $item->company ?? '') }}">
                                @error('company')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Rating') }}:</label>
                                <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                                    <option value="">{{ __('Select rating') }}</option>
                                    <option value="5" {{ old('rating', $item->rating ?? '') == 5 ? 'selected' : '' }}>5 ⭐⭐⭐⭐⭐</option>
                                    <option value="4" {{ old('rating', $item->rating ?? '') == 4 ? 'selected' : '' }}>4 ⭐⭐⭐⭐</option>
                                    <option value="3" {{ old('rating', $item->rating ?? '') == 3 ? 'selected' : '' }}>3 ⭐⭐⭐</option>
                                    <option value="2" {{ old('rating', $item->rating ?? '') == 2 ? 'selected' : '' }}>2 ⭐⭐</option>
                                    <option value="1" {{ old('rating', $item->rating ?? '') == 1 ? 'selected' : '' }}>1 ⭐</option>
                                </select>
                                @error('rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="mb-3">
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
                                                       placeholder="{{ __('Client name') }}"
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
                                                       placeholder="{{ __('Testimonial slug') }}"
                                                       value="{{ old('translations.'.$loop->index.'.slug', $translation->slug ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.slug')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Position') }}:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][position]" 
                                                       class="form-control @error('translations.'.$loop->index.'.position') is-invalid @enderror"
                                                       placeholder="{{ __('Job position') }}"
                                                       value="{{ old('translations.'.$loop->index.'.position', $translation->position ?? '') }}">
                                                @error('translations.'.$loop->index.'.position')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Comment') }} <span class="text-danger">*</span>:</label>
                                                <textarea name="translations[{{ $loop->index }}][comment]" 
                                                          class="form-control @error('translations.'.$loop->index.'.comment') is-invalid @enderror"
                                                          rows="5"
                                                          placeholder="{{ __('Testimonial comment') }}"
                                                          required>{{ old('translations.'.$loop->index.'.comment', $translation->comment ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.comment')
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

            // Form validation
            $('#testimonialForm').on('submit', function(e) {
                var hasValidTranslation = false;
                
                $('input[name*="[name]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasValidTranslation = true;
                        return false;
                    }
                });

                if (!hasValidTranslation) {
                    e.preventDefault();
                    alert('{{ __("At least one language name is required") }}');
                    $('input[name*="[name]"]').first().focus();
                    return false;
                }
            });
        });
    </script>
@endpush
