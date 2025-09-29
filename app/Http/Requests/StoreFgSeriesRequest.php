<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFgSeriesRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255|unique:fg_series,slug',
            'description' => 'required|string',
            'language' => 'required|string|max:50',
            'cost' => 'nullable|numeric|min:0',
            'release_date' => 'required|date',
            'feedback' => 'nullable|numeric|min:0|max:5',
            'banner_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            // Trailer validation
            'trailer_type' => 'nullable|in:youtube,s3,upload',
            'trailer_url' => 'nullable|required_if:trailer_type,youtube,s3|url',
            'trailer_file_path' => 'nullable|required_if:trailer_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:102400',
            
            'is_published' => 'nullable|boolean',
            
            // Episodes validation
            'episodes' => 'nullable|array|min:1',
            'episodes.*.title' => 'required_with:episodes|string|max:255',
            'episodes.*.description' => 'nullable|string',
            'episodes.*.episode_number' => 'required_with:episodes|integer|min:1',
            'episodes.*.duration_minutes' => 'nullable|integer|min:1',
            'episodes.*.video_type' => 'required_with:episodes|in:youtube,s3,upload',
            'episodes.*.video_url' => 'nullable|required_if:episodes.*.video_type,youtube,s3|url',
            'episodes.*.video_file_path' => 'nullable|required_if:episodes.*.video_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:512000',
            'episodes.*.is_published' => 'nullable|boolean',
        ];

        // If updating, exclude current record from unique validation
        if ($this->route('fgSeries')) {
            $rules['slug'] = 'nullable|string|max:255|unique:fg_series,slug,' . $this->route('fgSeries')->id;
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
            'banner_image_path.image' => 'Banner must be an image file.',
            'banner_image_path.mimes' => 'Banner must be a file of type: jpeg, png, jpg, gif, webp.',
            'banner_image_path.max' => 'Banner size cannot exceed 2MB.',
            'trailer_file_path.max' => 'Trailer file size cannot exceed 100MB.',
            
            // Episode validation messages
            'episodes.*.title.required_with' => 'Episode title is required.',
            'episodes.*.episode_number.required_with' => 'Episode number is required.',
            'episodes.*.video_type.required_with' => 'Episode video type is required.',
            'episodes.*.video_url.required_if' => 'Episode video URL is required for youtube and s3 video types.',
            'episodes.*.video_file_path.required_if' => 'Episode video file is required for upload video type.',
            'episodes.*.video_file_path.max' => 'Episode video file size cannot exceed 500MB.',
        ];
    }
}
