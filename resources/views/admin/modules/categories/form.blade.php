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

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Image') }}:</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <div class="form-text">{{ __('Select category image (optional)') }}</div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                @if(isset($item) && $item->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Current image" 
                                             class="rounded border" style="max-width: 100px; max-height: 100px;">
                                        <div class="text-muted small mt-1">{{ __('Current image') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Icon') }}:</label>
                                <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                       placeholder="{{ __('Icon class (e.g., ph-house)') }}"
                                       value="{{ old('icon', $item->icon ?? '') }}">
                                <div class="form-text">{{ __('Enter icon class name (optional)') }}</div>
                                @error('icon')
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
                                                       placeholder="{{ __('Category name') }}"
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
                                                       placeholder="{{ __('Category slug') }}"
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
                                                          placeholder="{{ __('Category description') }}">{{ old('translations.'.$loop->index.'.description', $translation->description ?? '') }}</textarea>
                                                @error('translations.'.$loop->index.'.description')
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

    @if(isset($item) && $item->exists)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Category Information') }}</h5>
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
            $('#categoryForm').on('submit', function(e) {
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

            // Icon preview
            $('input[name="icon"]').on('input', function() {
                var iconClass = $(this).val();
                var preview = $(this).parent().find('.icon-preview');
                
                if (preview.length === 0) {
                    preview = $('<div class="icon-preview mt-2"></div>');
                    $(this).parent().append(preview);
                }
                
                if (iconClass) {
                    preview.html('<i class="' + iconClass + ' me-2"></i><span class="text-muted">Preview</span>');
                } else {
                    preview.empty();
                }
            });

            // Trigger icon preview on load
            $('input[name="icon"]').trigger('input');
        });
    </script>
@endpush
