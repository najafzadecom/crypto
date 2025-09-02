# HasTranslatedAttributes Trait İstifadəsi

Bu trait bütün translatable modellərə əlavə edilib və tərcümə olunan sahələri rahat şəkildə almağa imkan verir.

## Əsas Metodlar

### 1. `getTranslatedAttribute($attribute, $locale = null)`
Hər hansı bir translate edilən sahəni alır.

```php
$category = Category::first();
$name = $category->getTranslatedAttribute('name'); // Cari dildə
$name = $category->getTranslatedAttribute('name', 'en'); // İngiliscədə
```

### 2. `getTranslatedName($locale = null)`
Name sahəsini alır (ən çox istifadə olunan).

```php
$category = Category::first();
$name = $category->getTranslatedName(); // Cari dildə ad
$name = $category->getTranslatedName('tr'); // Türkcədə ad
```

### 3. `getTranslatedTitle($locale = null)`
Title sahəsini alır.

```php
$news = News::first();
$title = $news->getTranslatedTitle(); // Cari dildə başlıq
```

### 4. Digər metodlar
- `getTranslatedDescription($locale = null)` - Təsvir
- `getTranslatedContent($locale = null)` - Məzmun  
- `getTranslatedExcerpt($locale = null)` - Qısa məzmun
- `getTranslatedSlug($locale = null)` - Slug

### 5. Magic Getter
`translated_` prefiksi ilə də istifadə edə bilərsiniz:

```php
$category = Category::first();
echo $category->translated_name; // getTranslatedName() ilə eyni
echo $category->translated_title; // getTranslatedTitle() ilə eyni
```

## Fallback Mexanizmi

Trait aşağıdakı ardıcıllıqla translation axtarır:

1. **Cari dil** - `app()->getLocale()` 
2. **Default dil** - `config('app.locale', 'az')`
3. **İlk mövcud translation**
4. **null** (heç bir translation yoxdursa)

## View-lərdə İstifadə

### Əvvəl (uzun kod):
```blade
@php
    $categoryTranslation = $category->translations->where('locale', app()->getLocale())->first();
    $categoryName = $categoryTranslation ? $categoryTranslation->name : ($category->translations->first()->name ?? 'N/A');
@endphp
{{ $categoryName }}
```

### İndi (qısa və təmiz):
```blade
{{ $category->getTranslatedName() }}
```

## Mövcud Modellər

Bu trait aşağıdakı modellərə əlavə edilib:

- `Category`
- `News`
- `Page`
- `Package`
- `StaticBlock`
- `Testimonial`
- `Faq`

## Nümunə Kod

```php
// Controller-də
$categories = Category::all();

// View-də
@foreach($categories as $category)
    <option value="{{ $category->id }}">
        {{ $category->getTranslatedName() }}
    </option>
@endforeach
```

Bu yanaşma kodu təkrarlamağın qarşısını alır və bütün layihədə vahid translation mexanizmi təmin edir.
