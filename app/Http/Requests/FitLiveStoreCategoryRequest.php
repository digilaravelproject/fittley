<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FitLiveStoreCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fitlive_categories', 'name')->ignore($this->route('category')?->id)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('fitlive_categories', 'slug')->ignore($this->route('category')?->id)
            ],
            'description' => 'nullable|string|max:1000',
            'chat_option' => ['required', Rule::in(['during', 'after', 'off'])],
            'record_enabled' => 'required|boolean',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'slug.unique' => 'A category with this slug already exists.',
            'slug.regex' => 'Slug must contain only lowercase letters, numbers, and hyphens.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'chat_option.required' => 'Please select a chat option.',
            'chat_option.in' => 'Invalid chat option selected.',
            'record_enabled.required' => 'Please specify if recording should be enabled.',
            'record_enabled.boolean' => 'Recording enabled must be true or false.',
            'is_active.required' => 'Please specify if the category should be active.',
            'is_active.boolean' => 'Active status must be true or false.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'slug',
            'description' => 'description',
            'chat_option' => 'chat option',
            'record_enabled' => 'recording enabled',
            'is_active' => 'active status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Generate slug if not provided
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name)
            ]);
        }

        // Convert string booleans to actual booleans
        if ($this->has('record_enabled')) {
            $this->merge([
                'record_enabled' => filter_var($this->record_enabled, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false
            ]);
        }

        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true
            ]);
        }
    }
} 
 