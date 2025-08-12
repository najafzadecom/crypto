# News Modulu - Ayrı Translation Table-ları ilə İstifadə Təlimatı

## Veritabanı Strukturu

### 1. news table
```sql
- id (primary key)
- image (nullable string)
- slug (unique string)
- is_featured (boolean)
- published_at (nullable timestamp)
- status (boolean)
- created_at, updated_at, deleted_at
```

### 2. news_translations table
```sql
- id (primary key)
- news_id (foreign key to news.id)
- locale (string, max 5 chars)
- title (string)
- content (longText)
- excerpt (nullable text)
- created_at, updated_at
- unique(news_id, locale)
```

## Model Konfiqurasiyası

### News Model
- `HasTranslations` trait istifadə edir
- `NewsTranslation` model ilə `hasMany` əlaqəsi
- Translatable sahələr: `title`, `content`, `excerpt`

### NewsTranslation Model
- `News` model ilə `belongsTo` əlaqəsi
- Fillable sahələr: `news_id`, `locale`, `title`, `content`, `excerpt`

## İstifadə Nümunələri

### 1. Yeni Xəbər Yaratmaq

#### Controller-də:
```php
public function store(StoreNewsRequest $request)
{
    // Əsas news məlumatlarını yarat
    $news = News::create([
        'image' => $request->image,
        'slug' => $request->slug,
        'is_featured' => $request->is_featured ?? false,
        'published_at' => $request->published_at,
        'status' => $request->status ?? true,
    ]);

    // Translation-ları əlavə et
    foreach ($request->translations as $translation) {
        $news->translations()->create([
            'locale' => $translation['locale'],
            'title' => $translation['title'],
            'content' => $translation['content'],
            'excerpt' => $translation['excerpt'] ?? null,
        ]);
    }

    return response()->json($news->load('translations'));
}
```

#### Request Data Format:
```json
{
    "slug": "unique-news-slug",
    "is_featured": true,
    "status": true,
    "published_at": "2024-01-15 10:00:00",
    "translations": [
        {
            "locale": "az",
            "title": "Azərbaycan dilində başlıq",
            "content": "Azərbaycan dilində məzmun...",
            "excerpt": "Qısa məzmun"
        },
        {
            "locale": "en", 
            "title": "English title",
            "content": "English content...",
            "excerpt": "Short excerpt"
        },
        {
            "locale": "tr",
            "title": "Türkçe başlık",
            "content": "Türkçe içerik...",
            "excerpt": "Kısa özet"
        }
    ]
}
```

### 2. Xəbərləri Oxumaq

#### Bütün translation-larla:
```php
$news = News::with('translations')->get();

foreach ($news as $item) {
    foreach ($item->translations as $translation) {
        echo $translation->locale . ': ' . $translation->title . PHP_EOL;
    }
}
```

#### Müəyyən dildə:
```php
$news = News::with(['translations' => function($query) {
    $query->where('locale', app()->getLocale());
}])->get();

// və ya
$news = News::with('translations')
    ->whereHas('translations', function($query) {
        $query->where('locale', 'az');
    })->get();
```

#### Spatie Translatable istifadə edərək:
```php
$news = News::find(1);

// Cari dildə
echo $news->title; // Spatie paketi avtomatik olaraq cari dildə göstərəcək

// Müəyyən dildə
echo $news->getTranslation('title', 'az');
echo $news->getTranslation('content', 'en');

// Bütün tərcümələr
$allTitles = $news->getTranslations('title');
// ['az' => '...', 'en' => '...', 'tr' => '...']
```

### 3. Xəbər Yeniləmək

```php
public function update(UpdateNewsRequest $request, News $news)
{
    // Əsas məlumatları yenilə
    $news->update([
        'image' => $request->image,
        'slug' => $request->slug,
        'is_featured' => $request->is_featured ?? false,
        'published_at' => $request->published_at,
        'status' => $request->status ?? true,
    ]);

    // Mövcud translation-ları sil və yenilərini əlavə et
    $news->translations()->delete();
    
    foreach ($request->translations as $translation) {
        $news->translations()->create([
            'locale' => $translation['locale'],
            'title' => $translation['title'],
            'content' => $translation['content'],
            'excerpt' => $translation['excerpt'] ?? null,
        ]);
    }

    return response()->json($news->load('translations'));
}
```

### 4. Axtarış və Filtrlər

#### Başlığa görə axtarış (müəyyən dildə):
```php
$news = News::whereHas('translations', function($query) use ($searchTerm) {
    $query->where('locale', 'az')
          ->where('title', 'like', '%' . $searchTerm . '%');
})->get();
```

#### Aktiv və published xəbərlər:
```php
$news = News::where('status', true)
    ->whereNotNull('published_at')
    ->where('published_at', '<=', now())
    ->with('translations')
    ->get();
```

#### Featured xəbərlər:
```php
$featuredNews = News::where('is_featured', true)
    ->where('status', true)
    ->with('translations')
    ->take(5)
    ->get();
```

## Migration İşə Salma

```bash
# Migration-ları işə sal
php artisan migrate

# Test məlumatları əlavə et
php artisan db:seed --class=NewsSeeder
```

## Üstünlükləri

1. **Ayrı Table-lar**: Hər dil üçün ayrı sətirlər
2. **Performans**: Index-lər və foreign key-lər
3. **Məlumat Bütövlüğü**: Referential integrity
4. **Genişlənə bilən**: Yeni dillər asanlıqla əlavə edilə bilər
5. **Sorğu Rahatlığı**: SQL JOIN-lar ilə effektiv sorğular
6. **Spatie Uyumluluğu**: Mövcud Spatie Translatable paketi ilə uyumlu

## Qeydlər

- `locale` sahəsi üçün index mövcuddur
- `news_id + locale` unique constraint-i vardır
- Foreign key constraint-i ilə referential integrity təmin olunur
- Spatie Translatable paketi ilə tam uyumludur
- Factory və Seeder-lər həm manual həm də avtomatik məlumat yaradır
