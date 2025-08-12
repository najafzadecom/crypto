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

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="sliderForm">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Image') }} <span class="text-danger">*</span>:</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*" {{ !isset($item) ? 'required' : '' }}>
                                <div class="form-text">{{ __('Recommended size: 1920x600 pixels') }}</div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                @if(isset($item) && $item->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Current image" 
                                             class="rounded border" style="max-width: 200px; max-height: 100px;">
                                        <div class="text-muted small mt-1">{{ __('Current image') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Button URL') }}:</label>
                                <input type="url" name="button_url" class="form-control @error('button_url') is-invalid @enderror"
                                       placeholder="{{ __('https://example.com') }}"
                                       value="{{ old('button_url', $item->button_url ?? '') }}">
                                @error('button_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Sort Order') }}:</label>
                                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                       placeholder="{{ __('0') }}"
                                       value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                                @error('sort_order')
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
                                                <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span>:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][title]" 
                                                       class="form-control @error('translations.'.$loop->index.'.title') is-invalid @enderror"
                                                       placeholder="{{ __('Slider title') }}"
                                                       value="{{ old('translations.'.$loop->index.'.title', $translation->title ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.title')
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
                                                       placeholder="{{ __('Slider slug') }}"
                                                       value="{{ old('translations.'.$loop->index.'.slug', $translation->slug ?? '') }}"
                                                       required>
                                                @error('translations.'.$loop->index.'.slug')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Subtitle') }}:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][subtitle]" 
                                                       class="form-control @error('translations.'.$loop->index.'.subtitle') is-invalid @enderror"
                                                       placeholder="{{ __('Slider subtitle') }}"
                                                       value="{{ old('translations.'.$loop->index.'.subtitle', $translation->subtitle ?? '') }}">
                                                @error('translations.'.$loop->index.'.subtitle')
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
                                                          placeholder="{{ __('Slider description') }}">{{ old('translations.'.$loop->index.'.description', $translation->description ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Button Text') }}:</label>
                                                <input type="text" 
                                                       name="translations[{{ $loop->index }}][button_text]" 
                                                       class="form-control @error('translations.'.$loop->index.'.button_text') is-invalid @enderror"
                                                       placeholder="{{ __('Button text') }}"
                                                       value="{{ old('translations.'.$loop->index.'.button_text', $translation->button_text ?? '') }}">
                                                @error('translations.'.$loop->index.'.button_text')
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
        });
    </script>
@endpush
