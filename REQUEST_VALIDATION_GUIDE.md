# Request Validation Təlimatı - Bütün Modullar

## 🎯 Tamamlanmış Request Faylları

✅ **News** - Store/Update Request (artıq konfiqurasiya edilmişdi)  
✅ **Category** - Store/Update Request  
✅ **Faq** - Store/Update Request  
✅ **Package** - Store/Update Request  
✅ **Page** - Store/Update Request  
✅ **Slider** - Store/Update Request  
✅ **StaticBlock** - Store/Update Request  
✅ **Testimonial** - Store/Update Request  
✅ **Menu** - Store/Update Request  
✅ **MenuItem** - Store/Update Request  

## 📋 Validation Qaydaları

### Ümumi Struktur

Hər bir request faylı aşağıdakı strukturu izləyir:

```php
public function rules(): array
{
    return [
        // Əsas sahələr (non-translatable)
        'field1' => 'validation_rules',
        'field2' => 'validation_rules',
        
        // Translation sahələri
        'translations' => 'required|array|min:1',
        'translations.*.locale' => 'required|string|in:az,en,tr',
        'translations.*.field' => 'validation_rules',
    ];
}
```

### Dil Dəstəyi
- **Dəstəklənən dillər**: `az`, `en`, `tr`
- **Tələb olunan**: Ən azı 1 dil üçün tərcümə
- **Locale formatı**: 2 simvol (ISO 639-1)

## 🗂️ Modullar üzrə Validation Qaydaları

### 1. **Category** (Kateqoriya)

#### Əsas sahələr:
- `image`: nullable|image|max:2048
- `icon`: nullable|string|max:255
- `status`: boolean

#### Translation sahələri:
- `name`: required|string|max:255
- `slug`: required|string|max:255
- `description`: nullable|string|max:1000

### 2. **Faq** (Tez-tez verilən suallar)

#### Əsas sahələr:
- `status`: boolean

#### Translation sahələri:
- `question`: required|string|max:500
- `slug`: required|string|max:255
- `answer`: required|string

### 3. **Package** (Paketlər)

#### Əsas sahələr:
- `price`: required|numeric|min:0
- `currency`: required|string|size:3
- `duration_days`: nullable|integer|min:1
- `is_popular`: boolean
- `status`: boolean

#### Translation sahələri:
- `name`: required|string|max:255
- `slug`: required|string|max:255
- `description`: nullable|string|max:1000
- `features`: nullable|string

### 4. **Page** (Səhifələr)

#### Əsas sahələr:
- `template`: required|string|max:255
- `status`: boolean

#### Translation sahələri:
- `title`: required|string|max:255
- `slug`: required|string|max:255
- `content`: required|string
- `meta_title`: nullable|string|max:255
- `meta_description`: nullable|string|max:500

### 5. **Slider** (Slayderlər)

#### Əsas sahələr:
- `image`: required|image|max:2048 (Store), nullable (Update)
- `button_url`: nullable|url|max:255
- `sort_order`: nullable|integer|min:0
- `status`: boolean

#### Translation sahələri:
- `title`: required|string|max:255
- `slug`: required|string|max:255
- `subtitle`: nullable|string|max:255
- `description`: nullable|string|max:1000
- `button_text`: nullable|string|max:100

### 6. **StaticBlock** (Statik Bloklar)

#### Əsas sahələr:
- `status`: boolean

#### Translation sahələri:
- `title`: required|string|max:255
- `slug`: required|string|max:255
- `content`: required|string

### 7. **Testimonial** (Rəylər)

#### Əsas sahələr:
- `image`: nullable|image|max:2048
- `company`: nullable|string|max:255
- `rating`: required|integer|min:1|max:5
- `status`: boolean

#### Translation sahələri:
- `name`: required|string|max:255
- `slug`: required|string|max:255
- `position`: nullable|string|max:255
- `comment`: required|string

### 8. **Menu** (Menyular)

#### Əsas sahələr:
- `location`: required|string|max:255|unique
- `status`: boolean

#### Translation sahələri:
- `name`: required|string|max:255
- `slug`: required|string|max:255

### 9. **MenuItem** (Menyu Elementləri)

#### Əsas sahələr:
- `menu_id`: required|exists:menus,id
- `parent_id`: nullable|exists:menu_items,id
- `url`: nullable|string|max:255
- `target`: required|string|in:_self,_blank,_parent,_top
- `icon`: nullable|string|max:255
- `sort_order`: nullable|integer|min:0
- `status`: boolean

#### Translation sahələri:
- `title`: required|string|max:255
- `slug`: required|string|max:255

## 🔧 Xüsusi Validation Qaydaları

### Update Request-lərində Fərqlər

1. **Unique Constraint-lər**: Update zamanı mövcud record istisna edilir
```php
'location' => 'required|string|max:255|unique:menus,location,' . $menuId
```

2. **Parent-Child Relationship**: MenuItem özünün parent-i ola bilməz
```php
'parent_id' => 'nullable|exists:menu_items,id|not_in:' . $menuItemId
```

3. **Image Fields**: Store-da required, Update-də nullable
```php
// Store
'image' => 'required|image|max:2048'

// Update  
'image' => 'nullable|image|max:2048'
```

## 📝 Xəta Mesajları

### Azərbaycan dilində xəta mesajları:

```php
public function messages(): array
{
    return [
        'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
        'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
        'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
        // ...
    ];
}
```

### Sahə adları (Attributes):

```php
public function attributes(): array
{
    return [
        'translations.*.locale' => 'dil',
        'translations.*.name' => 'ad',
        'translations.*.slug' => 'slug',
        // ...
    ];
}
```

## 🚀 İstifadə Nümunəsi

### Frontend-dən gələn məlumat formatı:

```json
{
    "image": "file_upload",
    "status": true,
    "translations": [
        {
            "locale": "az",
            "name": "Kateqoriya adı",
            "slug": "kateqoriya-adi",
            "description": "Təsvir..."
        },
        {
            "locale": "en", 
            "name": "Category name",
            "slug": "category-name",
            "description": "Description..."
        },
        {
            "locale": "tr",
            "name": "Kategori adı",
            "slug": "kategori-adi", 
            "description": "Açıklama..."
        }
    ]
}
```

### Controller-də istifadə:

```php
public function store(StoreCategoryRequest $request)
{
    // Request artıq validate edilib
    $validatedData = $request->validated();
    
    // Əsas məlumatları yarat
    $category = Category::create([
        'image' => $request->image,
        'status' => $request->status ?? true,
    ]);
    
    // Translation-ları əlavə et
    foreach ($request->translations as $translation) {
        $category->translations()->create($translation);
    }
    
    return response()->json($category->load('translations'));
}
```

## ✅ Faydalar

1. **Tutarlı Validation**: Bütün modullar eyni strukturu izləyir
2. **Çoxdilli Dəstək**: 3 dil üçün tam validation
3. **Azərbaycan dilində Xətalar**: İstifadəçi dostu mesajlar
4. **Type Safety**: Düzgün data tipləri və formatlar
5. **Unique Constraint-lər**: Məlumat bütövlüğü
6. **File Upload**: Şəkil faylları üçün düzgün validation

Artıq bütün modullarınız üçün tam validation sistemi hazırdır və istifadəyə başlaya bilərsiniz! 🎉
