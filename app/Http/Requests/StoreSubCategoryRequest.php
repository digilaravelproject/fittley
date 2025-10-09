<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategoryRequest extends FormRequest
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
    public function rules_old(): array
    {
        $subCategoryId = $this->route('subCategory') ? $this->route('subCategory')->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:120',
            'slug' => 'nullable|string|unique:sub_categories,slug,' . $subCategoryId,
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
    public function rules(): array
    {
        $subCategoryId = $this->route('subCategory') ? $this->route('subCategory')->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:120',
            'slug' => [
                'nullable',
                'string',
                // Check uniqueness only if slug is provided and different from the current slug
                Rule::unique('sub_categories')->ignore($subCategoryId)->where(function ($query) use ($subCategoryId) {
                    return $query->where('id', '!=', $subCategoryId);
                }),
            ],
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}