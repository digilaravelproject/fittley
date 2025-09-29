<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFitFlixShortsCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $categoryId = $this->route('fitflix_shorts_category') ? $this->route('fitflix_shorts_category')->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fit_flix_shorts_categories', 'name')->ignore($categoryId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('fit_flix_shorts_categories', 'slug')->ignore($categoryId),
            ],
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:255',
            'color' => [
                'nullable',
                'string',
                'size:7',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'banner_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048', // 2MB
            ],
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'slug.unique' => 'This slug already exists.',
            'slug.alpha_dash' => 'Slug can only contain letters, numbers, dashes, and underscores.',
            'color.regex' => 'Color must be a valid hex color code (e.g., #f7a31a).',
            'banner_image.image' => 'Banner must be a valid image file.',
            'banner_image.mimes' => 'Banner must be a JPEG, JPG, PNG, or WebP file.',
            'banner_image.max' => 'Banner image must not be larger than 2MB.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order must be at least 0.',
            'sort_order.max' => 'Sort order must not exceed 9999.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox to boolean
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);

        // Set default sort order if not provided
        if (!$this->has('sort_order') || $this->sort_order === null) {
            $this->merge([
                'sort_order' => 0,
            ]);
        }

        // Set default color if not provided
        if (!$this->has('color') || empty($this->color)) {
            $this->merge([
                'color' => '#f7a31a',
            ]);
        }
    }
} 