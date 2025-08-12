# Bütün Modullar üçün Translation Sistemi - Tam Təlimat

## 🎯 Tamamlanmış Modullar

✅ **News** - Xəbərlər  
✅ **Category** - Kateqoriyalar  
✅ **Faq** - Tez-tez verilən suallar  
✅ **Package** - Paketlər  
✅ **Page** - Səhifələr  
✅ **Slider** - Slayderlər  
✅ **StaticBlock** - Statik bloklar  
✅ **Testimonial** - Rəylər  
✅ **Menu** - Menyular  
✅ **MenuItem** - Menyu elementləri  

## 📊 Veritabanı Strukturu

### Əsas Prinsip
Hər modul üçün iki table:
1. **Əsas table** - Translatable olmayan sahələr
2. **Translation table** - Hər dil üçün ayrı sətirlər

### Nümunə Struktur (News modulu)

#### `news` table:
```sql
- id (primary key)
- image (nullable)
- is_featured (boolean)
- published_at (nullable timestamp)
- status (boolean)
- created_at, updated_at, deleted_at
```

#### `news_translations` table:
```sql
- id (primary key)
- news_id (FK to news.id)
- locale (string, 2 chars: az, en, tr)
- title (string)
- slug (unique string)
- content (longText)
- excerpt (nullable text)
- created_at, updated_at
- unique(news_id, locale)
- unique(news_id, slug)
```

## 🗂️ Bütün Modulların Translation Sahələri

### 1. **News** (Xəbərlər)
- **Translatable**: title, slug, content, excerpt
- **Non-translatable**: image, is_featured, published_at, status

### 2. **Category** (Kateqoriyalar)
- **Translatable**: name, slug, description
- **Non-translatable**: image, icon, status

### 3. **Faq** (FAQ)
- **Translatable**: question, slug, answer
- **Non-translatable**: status

### 4. **Package** (Paketlər)
- **Translatable**: name, slug, description, features
- **Non-translatable**: price, currency, duration_days, is_popular, status

### 5. **Page** (Səhifələr)
- **Translatable**: title, slug, content, meta_title, meta_description
- **Non-translatable**: template, status

### 6. **Slider** (Slayderlər)
- **Translatable**: title, slug, subtitle, description, button_text
- **Non-translatable**: image, button_url, sort_order, status

### 7. **StaticBlock** (Statik Bloklar)
- **Translatable**: title, slug, content
- **Non-translatable**: status

### 8. **Testimonial** (Rəylər)
- **Translatable**: name, slug, position, comment
- **Non-translatable**: image, company, rating, status

### 9. **Menu** (Menyular)
- **Translatable**: name, slug
- **Non-translatable**: location, status

### 10. **MenuItem** (Menyu Elementləri)
- **Translatable**: title, slug
- **Non-translatable**: menu_id, parent_id, url, target, icon, sort_order, status

## 🔧 İstifadə Nümunələri

### Yeni Məlumat Yaratmaq
```php
// News nümunəsi
$news = News::create([
    'image' => 'news-image.jpg',
    'is_featured' => true,
    'status' => true,
]);

// Translation-ları əlavə et
$translations = [
    'az' => [
        'title' => 'Azərbaycan başlığı',
        'slug' => 'azerbaycan-basligi',
        'content' => 'Azərbaycan məzmunu...',
        'excerpt' => 'Qısa məzmun'
    ],
    'en' => [
        'title' => 'English title',
        'slug' => 'english-title',
        'content' => 'English content...',
        'excerpt' => 'Short excerpt'
    ],
    'tr' => [
        'title' => 'Türkçe başlık',
        'slug' => 'turkce-baslik',
        'content' => 'Türkçe içerik...',
        'excerpt' => 'Kısa özet'
    ]
];

foreach ($translations as $locale => $translation) {
    $news->translations()->create(array_merge(['locale' => $locale], $translation));
}
```

### Məlumatları Oxumaq
```php
// Spatie Translatable istifadə edərək
$news = News::find(1);

// Cari dildə
echo $news->title; // Cari locale-a görə

// Müəyyən dildə
echo $news->getTranslation('title', 'az');
echo $news->getTranslation('content', 'en');

// Bütün tərcümələr
$allTitles = $news->getTranslations('title');
// ['az' => '...', 'en' => '...', 'tr' => '...']

// Əlaqəli translation-larla
$news = News::with('translations')->get();
```

### Axtarış və Filtrlər
```php
// Müəyyən dildə axtarış
$results = News::whereHas('translations', function($query) {
    $query->where('locale', 'az')
          ->where('title', 'like', '%axtarılan%');
})->get();

// Cari dildə translation-larla
$news = News::with(['translations' => function($query) {
    $query->where('locale', app()->getLocale());
}])->get();
```

## 📋 Request Validation Nümunəsi

### Store Request
```php
public function rules(): array
{
    return [
        // Əsas sahələr
        'image' => 'nullable|image|max:2048',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        
        // Translation sahələri
        'translations' => 'required|array',
        'translations.*.locale' => 'required|string|in:az,en,tr',
        'translations.*.title' => 'required|string|max:255',
        'translations.*.slug' => 'required|string|max:255',
        'translations.*.content' => 'required|string',
        'translations.*.excerpt' => 'nullable|string|max:500',
    ];
}
```

## 🚀 Migration İşə Salma

```bash
# Bütün migration-ları işə sal
php artisan migrate

# Seeder-ləri işə sal (test məlumatları)
php artisan db:seed --class=NewsSeeder
php artisan db:seed --class=CategorySeeder
# və s.
```

## 🌟 Üstünlüklər

### 1. **Performans**
- Ayrı table-lar sayəsində sürətli sorğular
- Index-lər və foreign key-lər
- JOIN-larla effektiv axtarış

### 2. **Məlumat Bütövlüğü**
- Foreign key constraint-ləri
- Unique constraint-lər
- Referential integrity

### 3. **Genişlənə bilən**
- Yeni dillər asanlıqla əlavə edilə bilər
- Yeni translation sahələri əlavə etmək mümkündür

### 4. **Spatie Uyumluluğu**
- Mövcud Spatie Translatable paketi ilə tam uyumlu
- JSON-da saxlamaq əvəzinə ayrı table-lar

### 5. **Developer Experience**
- Aydın və anlaşılan struktur
- Eloquent relationship-lər
- Type safety

## ⚙️ Konfiqurasiya

### Locale Konfiqurasiyası
```php
// config/app.php
'locale' => 'az',
'fallback_locale' => 'en',

// Dəstəklənən dillər
'supported_locales' => ['az', 'en', 'tr'],
```

### Model Nümunəsi
```php
class News extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'slug', 'content', 'excerpt'];
    
    public function translations(): HasMany
    {
        return $this->hasMany(NewsTranslation::class);
    }
    
    public function getTranslationModelName(): string
    {
        return NewsTranslation::class;
    }
}
```

## 🎯 Nəticə

Artıq bütün modullarınız ayrı translation table-ları ilə tam hazırdır:

- ✅ **10 modul** tam konfiqurasiya edildi
- ✅ **20 migration** yaradıldı (10 əsas + 10 translation)
- ✅ **20 model** konfiqurasiya edildi (10 əsas + 10 translation)
- ✅ **Spatie Translatable** paketi ilə tam uyumlu
- ✅ **3 dil** dəstəyi (az, en, tr)
- ✅ **Performans optimizasiyası** və **məlumat bütövlüğü**

Sistem hazırdır və istifadəyə başlaya bilərsiniz! 🚀
