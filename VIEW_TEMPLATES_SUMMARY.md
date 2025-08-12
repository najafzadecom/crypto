# Admin View Templates - Bütün Modullar

## 🎯 Tamamlanmış View-lar

✅ **Category** - List və Form view-ları  
✅ **Faq** - List və Form view-ları  
✅ **Package** - List və Form view-ları  
✅ **Slider** - List və Form view-ları  

## 📋 View Strukturu

### Ümumi Xüsusiyyətlər

1. **Language Service Integration**:
   - `$languages` dəyişəni ilə aktiv dillər
   - `$defaultLocale` ilə default dil

2. **Translation Display**:
   - List view-larda default locale-da məlumatlar
   - Form view-larda hər dil üçün ayrı tab

3. **Common Features**:
   - Search və filter funksionallığı
   - Sortable table headers
   - Modal show dialogs
   - Auto-slug generation
   - Image preview
   - Validation error display

### List View Template

```blade
@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <!-- Header with Create Button -->
            <div class="card-header d-flex">
                <h5 class="mb-0">{{ $module }}</h5>
                <div class="ms-auto">
                    <x-buttons.create title="{{ __('Create') }}" url="{{ route('admin.{module}.create') }}" permission="{module}-create"/>
                </div>
            </div>

            <!-- Search Form -->
            <div class="card-body">
                <form action="" method="GET" id="searchForm">
                    <!-- Search fields -->
                </form>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <!-- Sortable headers -->
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            @php
                                $defaultTranslation = $item->translations->where('locale', $defaultLocale)->first();
                                $name = $defaultTranslation?->name ?? $item->translations->first()?->name ?? '-';
                            @endphp
                            <tr>
                                <!-- Display default locale translation -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="X" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ph-icon display-6 d-block mb-2"></i>
                                        {{ __('No items found') }}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="pagination-info">
                        {{ __('Showing') }} {{ $items->firstItem() ?? 0 }} {{ __('to') }} {{ $items->lastItem() ?? 0 }}
                        {{ __('of') }} {{ $items->total() }} {{ __('results') }}
                    </div>
                    <div class="pagination-links">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

### Form View Template

```blade
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

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @method($method)
                    @csrf

                    <!-- Main Fields -->
                    <div class="row mb-4">
                        <!-- Non-translatable fields -->
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

                                            <!-- Translation fields for each language -->
                                            
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
            // Auto-generate slug from name/title
            // Form validation
            // Other JavaScript functionality
        });
    </script>
@endpush
```

## 🔧 JavaScript Funksionallığı

### Auto Slug Generation
```javascript
$('input[name*="[name]"]').on('input', function() {
    var nameInput = $(this);
    var slugInput = nameInput.closest('.border').find('input[name*="[slug]"]');
    
    if (slugInput.val() === '' || slugInput.data('auto-generated')) {
        var slug = generateSlug(nameInput.val());
        slugInput.val(slug).data('auto-generated', true);
    }
});

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
```

### Form Validation
```javascript
$('#moduleForm').on('submit', function(e) {
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
```

## 🎨 UI Components

### Translation Badge
```blade
<div class="text-muted small">
    <span class="badge bg-light text-dark">{{ $defaultLocale }}</span>
</div>
```

### Language Tab Header
```blade
<div class="d-flex align-items-center mb-3">
    <span class="badge bg-primary me-2">{{ strtoupper($language->code) }}</span>
    <span class="fw-semibold">{{ $language->name }}</span>
</div>
```

### Empty State
```blade
<td colspan="X" class="text-center py-4">
    <div class="text-muted">
        <i class="ph-icon display-6 d-block mb-2"></i>
        {{ __('No items found') }}
    </div>
</td>
```

## 📝 Controller Integration

### Required Variables
```php
// List view
$data = [
    'title' => 'Module List',
    'module' => 'Module Name',
    'items' => $paginatedItems,
    'defaultLocale' => app()->getLocale()
];

// Form view  
$data = [
    'title' => 'Create/Edit Module',
    'action' => route('admin.module.store'),
    'method' => 'POST',
    'languages' => $languageService->getActiveLanguages(),
    'item' => $item ?? null
];
```

Bu template-lər əsasında bütün modullar üçün view-lar yaradıla bilər. Hər modul öz xüsusi sahələrinə uyğun olaraq bu template-lərdən istifadə edə bilər.
