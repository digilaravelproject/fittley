<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFitLiveSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Handle route param as either model or string (id)
        $sessionParam = $this->route('fitLiveSession');
        $sessionId = is_object($sessionParam) ? $sessionParam->id : $sessionParam;

        return [
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'instructor_id' => 'required|exists:users,id',
            'title' => [
                'required',
                'string',
                'max:180',
                Rule::unique('fitlive_sessions', 'title')->ignore($sessionId),
            ],
            'description' => 'nullable|string|max:2000',
            'scheduled_at' => 'nullable|date|after:now',
            'status' => 'nullable|in:scheduled,live,ended',
            'chat_mode' => 'nullable|in:during,after,off',
            'visibility' => 'required|in:public,private',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
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
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'sub_category_id.exists' => 'Selected sub-category does not exist.',
            'instructor_id.required' => 'Please select an instructor.',
            'instructor_id.exists' => 'Selected instructor does not exist.',
            'title.required' => 'Session title is required.',
            'title.unique' => 'A session with this title already exists.',
            'title.max' => 'Session title cannot exceed 180 characters.',
            'description.max' => 'Description cannot exceed 2000 characters.',
            'scheduled_at.date' => 'Scheduled date must be a valid date.',
            'scheduled_at.after' => 'Scheduled date must be in the future.',
            'status.in' => 'Invalid status selected.',
            'chat_mode.in' => 'Invalid chat mode selected.',
            'visibility.required' => 'Please select visibility option.',
            'visibility.in' => 'Invalid visibility option selected.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate that subcategory belongs to the selected category
            if ($this->filled(['category_id', 'sub_category_id'])) {
                $subcategory = \App\Models\SubCategory::find($this->sub_category_id);
                if ($subcategory && $subcategory->category_id != $this->category_id) {
                    $validator->errors()->add('sub_category_id', 'The selected sub-category does not belong to the selected category.');
                }
            }

            // Validate that instructor has the instructor role
            if ($this->filled('instructor_id')) {
                $instructor = \App\Models\User::find($this->instructor_id);
                if ($instructor && !$instructor->hasRole('instructor')) {
                    $validator->errors()->add('instructor_id', 'The selected user is not an instructor.');
                }
            }
        });
    }
}
