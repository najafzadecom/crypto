<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('menu-item-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Main menu item fields
            'menu_id' => 'required|exists:menus,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'url' => 'nullable|string|max:255',
            'target' => 'required|string|in:_self,_blank,_parent,_top',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.slug' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'menu_id' => 'menyu',
            'parent_id' => 'valideyn element',
            'url' => 'link',
            'target' => 'hədəf',
            'icon' => 'ikon',
            'sort_order' => 'sıralama',
            'translations.*.locale' => 'dil',
            'translations.*.title' => 'başlıq',
            'translations.*.slug' => 'slug',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'menu_id.required' => 'Menyu sahəsi tələb olunur.',
            'menu_id.exists' => 'Seçilmiş menyu mövcud deyil.',
            'parent_id.exists' => 'Seçilmiş valideyn element mövcud deyil.',
            'target.in' => 'Hədəf yalnız _self, _blank, _parent və ya _top ola bilər.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.title.required' => 'Başlıq sahəsi tələb olunur.',
            'translations.*.slug.required' => 'Slug sahəsi tələb olunur.',
        ];
    }
}
