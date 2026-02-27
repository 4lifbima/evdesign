<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku'],
            'barcode' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['nullable', 'boolean'],
            'is_best_seller' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'colors' => ['nullable', 'string'],
            'sizes' => ['nullable', 'string'],
            'materials' => ['nullable', 'string'],
            'dimensions' => ['nullable', 'string'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'artisan_ids' => ['nullable', 'array'],
            'artisan_ids.*' => ['exists:artisans,id'],
            'material_ids' => ['nullable', 'array'],
            'material_ids.*' => ['exists:materials,id'],
            'image_paths' => ['nullable', 'array'],
            'image_paths.*' => ['nullable', 'string', 'max:255'],
            'variant_names' => ['nullable', 'array'],
            'variant_names.*' => ['nullable', 'string', 'max:255'],
            'variant_colors' => ['nullable', 'array'],
            'variant_sizes' => ['nullable', 'array'],
            'variant_prices' => ['nullable', 'array'],
            'variant_stocks' => ['nullable', 'array'],
        ];
    }
}
