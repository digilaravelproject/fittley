<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFgSingleRequest extends FormRequest
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
            'fg_sub_category_id' => 'nullable|exists:fg_sub_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fg_singles,slug',
            'description' => 'required|string',
            'language' => 'required|string|max:50',
            'cost' => 'nullable|numeric|min:0',
            'release_date' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'feedback' => 'nullable|numeric|min:0|max:5',
            'banner_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            // Trailer validation
            'trailer_type' => 'nullable|in:youtube,s3,upload',
            'trailer_url' => 'nullable|required_if:trailer_type,youtube,s3|url',
            'trailer_file_path' => 'nullable|required_if:trailer_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:102400',
            
            // Main video validation
            'video_type' => 'required|in:youtube,s3,upload',
            'video_url' => 'nullable|required_if:video_type,youtube,s3|url',
            'video_file_path' => 'nullable|required_if:video_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:512000',
            
            'is_published' => 'nullable|boolean',
        ];

        // If updating, exclude current record from unique validation
        if ($this->route('fgSingle')) {
            $rules['slug'] = 'nullable|string|max:255|unique:fg_singles,slug,' . $this->route('fgSingle')->id;
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
            'fg_sub_category_id.exists' => 'Selected subcategory does not exist.',
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'language.required' => 'Language is required.',
            'release_date.required' => 'Release date is required.',
            'release_date.date' => 'Release date must be a valid date.',
            'video_type.required' => 'Video type is required.',
            'video_type.in' => 'Video type must be youtube, s3, or upload.',
            'video_url.required_if' => 'Video URL is required for youtube and s3 video types.',
            'video_file_path.required_if' => 'Video file is required for upload video type.',
            'banner_image_path.image' => 'Banner must be an image file.',
            'banner_image_path.mimes' => 'Banner must be a file of type: jpeg, png, jpg, gif, webp.',
            'banner_image_path.max' => 'Banner size cannot exceed 2MB.',
            'video_file_path.max' => 'Video file size cannot exceed 500MB.',
            'trailer_file_path.max' => 'Trailer file size cannot exceed 100MB.',
        ];
    }
}
