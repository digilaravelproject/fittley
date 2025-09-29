<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFitFlixShortsRequest extends FormRequest
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
        $shortsId = $this->route('fitflix_short') ? $this->route('fitflix_short')->id : null;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('fitflix_shorts', 'slug')->ignore($shortsId),
            ],
            'description' => 'nullable|string|max:2000',
            'category_id' => [
                'required',
                'integer',
                'exists:fit_flix_shorts_categories,id',
            ],
            'video_file' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'file',
                'mimes:mp4,mov,avi,mkv,webm',
                'max:512000', // 500MB
            ],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048', // 2MB
            ],
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Short title is required.',
            'slug.unique' => 'This slug already exists.',
            'slug.alpha_dash' => 'Slug can only contain letters, numbers, dashes, and underscores.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'video_file.required' => 'Video file is required.',
            'video_file.mimes' => 'Video must be MP4, MOV, AVI, MKV, or WebM format.',
            'video_file.max' => 'Video file must not be larger than 500MB.',
            'thumbnail.image' => 'Thumbnail must be a valid image file.',
            'thumbnail.mimes' => 'Thumbnail must be a JPEG, JPG, PNG, or WebP file.',
            'thumbnail.max' => 'Thumbnail image must not be larger than 2MB.',
            'published_at.date' => 'Published date must be a valid date.',
            'meta_title.max' => 'Meta title must not exceed 255 characters.',
            'meta_description.max' => 'Meta description must not exceed 500 characters.',
            'meta_keywords.max' => 'Meta keywords must not exceed 255 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkboxes to boolean
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'is_featured' => $this->boolean('is_featured'),
        ]);

        // Set published_at if is_published is true and published_at is not set
        if ($this->boolean('is_published') && !$this->has('published_at')) {
            $this->merge([
                'published_at' => now(),
            ]);
        }
    }
} 