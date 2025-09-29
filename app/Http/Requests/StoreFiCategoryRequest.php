<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFiCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('fiCategory') ? $this->route('fiCategory')->id : null;
        
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('fi_categories', 'slug')->ignore($categoryId)
            ],
            'description' => 'nullable|string|max:1000',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'boolean',
            
            // SEO Fields
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'Slug can only contain lowercase letters, numbers, and hyphens.',
            'banner_image.image' => 'Banner must be a valid image file.',
            'banner_image.mimes' => 'Banner must be a JPEG, PNG, JPG, or WebP image.',
            'banner_image.max' => 'Banner image cannot exceed 5MB.',
            'color.regex' => 'Color must be a valid hex color code (e.g., #f7a31a).',
            'sort_order.min' => 'Sort order must be at least 0.',
            'sort_order.max' => 'Sort order cannot exceed 9999.',
            'meta_title.max' => 'Meta title should not exceed 60 characters for optimal SEO.',
            'meta_description.max' => 'Meta description should not exceed 160 characters for optimal SEO.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);

        // Auto-generate slug if not provided
        if (empty($this->slug) && !empty($this->name)) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name)
            ]);
        }
    }
}
