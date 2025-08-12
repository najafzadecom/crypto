# Controller Update Script

Bütün controller-ləri aşağıdakı template-ə uyğun yeniləmək lazımdır:

## 1. Constructor-a LanguageService əlavə etmək

```php
use App\Services\LanguageService;

private LanguageService $languageService;

public function __construct(Service $service, LanguageService $languageService)
{
    // middleware-lər
    
    $this->service = $service;
    $this->languageService = $languageService;
    $this->module = 'moduleName';
}
```

## 2. Index method-unu yeniləmək

```php
public function index()
{
    $this->data = [
        'module' => __('Module Name'),
        'title' => __('List'),
        'items' => $this->service->paginate(),
        'defaultLocale' => $this->languageService->getDefaultLocale()
    ];

    return $this->render('list');
}
```

## 3. Create method-unu yeniləmək

```php
public function create()
{
    $this->data = [
        'title' => __('Create Module'),
        'method' => 'POST',
        'action' => route('admin.' . $this->module . '.store'),
        'languages' => $this->languageService->getActiveLanguages()
    ];

    return $this->render('form');
}
```

## 4. Show method-unu yeniləmək

```php
public function show(string $id)
{
    $item = $this->service->getById($id);
    
    $this->data = [
        'id' => $item->id,
        // module specific fields
        'status' => $item->status,
        'status_html' => $item->status_html,
        'translations' => $item->translations,
        'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
        'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
    ];

    return $this->json();
}
```

## 5. Edit method-unu yeniləmək

```php
public function edit(string $id)
{
    $item = $this->service->getById($id);
    
    $this->data = [
        'title' => __('Edit Module'),
        'item' => $item,
        'method' => 'PUT',
        'action' => route('admin.' . $this->module . '.update', $id),
        'languages' => $this->languageService->getActiveLanguages()
    ];

    return $this->render('form');
}
```

## Module-specific Show Data

### PackageController
```php
'price' => $item->price,
'currency' => $item->currency,
'duration_days' => $item->duration_days,
'is_popular' => $item->is_popular,
```

### SliderController
```php
'image' => $item->image,
'button_url' => $item->button_url,
'sort_order' => $item->sort_order,
```

### NewsController
```php
'image' => $item->image,
'is_featured' => $item->is_featured,
'published_at' => $item->published_at?->format('d.m.Y H:i:s'),
```

### TestimonialController
```php
'image' => $item->image,
'company' => $item->company,
'rating' => $item->rating,
```

Bu template-ə uyğun olaraq bütün controller-ləri yeniləyəcəyəm.
