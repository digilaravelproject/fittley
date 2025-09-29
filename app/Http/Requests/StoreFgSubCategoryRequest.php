<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFgSubCategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'fg_category_id' => 'required|exists:fg_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fg_sub_categories,slug',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];

        // If updating, exclude current record from unique validation
        if ($this->route('fgSubCategory')) {
            $rules['slug'] = 'nullable|string|max:255|unique:fg_sub_categories,slug,' . $this->route('fgSubCategory')->id;
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'fg_category_id.required' => 'Category is required.',
            'fg_category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Subcategory name is required.',
            'name.string' => 'Subcategory name must be a string.',
            'name.max' => 'Subcategory name cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order cannot be negative.',
        ];
    }
}
