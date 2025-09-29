<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules(): array
    {
        $subCategoryId = $this->route('subCategory') ? $this->route('subCategory')->id : null;
        
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:120',
            'slug' => 'nullable|string|unique:sub_categories,slug,' . $subCategoryId,
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
