<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFitDocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Temporarily bypass authorization for testing
        return true;
        // return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fit_docs,slug,' . $this->route('fitDoc')?->id,
            'type' => 'required|in:single,series',
            'description' => 'required|string',
            'language' => 'required|string|max:50',
            'cost' => 'nullable|numeric|min:0',
            'release_date' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'total_episodes' => 'nullable|integer|min:1',
            'feedback' => 'nullable|numeric|between:0,5',
            'is_published' => 'boolean',
            
            // Banner image validation
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            
            // Trailer validation
            'trailer_type' => 'nullable|in:youtube,s3,upload',
            'trailer_url' => 'nullable|string|max:500',
            'trailer_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB
            
            // Video validation (for single type)
            'video_type' => 'nullable|in:youtube,s3,upload',
            'video_url' => 'nullable|string|max:500',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000', // 500MB
        ];

        // Additional validation based on type
        if ($this->input('type') === 'single') {
            $rules['video_type'] = 'required|in:youtube,s3,upload';
            $rules['duration_minutes'] = 'required|integer|min:1';
            
            // Video URL or file required for single videos
            if ($this->input('video_type') === 'youtube' || $this->input('video_type') === 's3') {
                $rules['video_url'] = 'required|string|max:500';
            } elseif ($this->input('video_type') === 'upload') {
                $rules['video_file'] = 'required|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000';
            }
        }

        // Trailer URL or file validation
        if ($this->input('trailer_type') === 'youtube' || $this->input('trailer_type') === 's3') {
            $rules['trailer_url'] = 'required|string|max:500';
        } elseif ($this->input('trailer_type') === 'upload') {
            $rules['trailer_file'] = 'required|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'type.required' => 'Please select a content type.',
            'type.in' => 'The selected type is invalid.',
            'description.required' => 'The description field is required.',
            'language.required' => 'The language field is required.',
            'release_date.required' => 'The release date field is required.',
            'release_date.date' => 'The release date must be a valid date.',
            'cost.numeric' => 'The cost must be a number.',
            'cost.min' => 'The cost must be at least 0.',
            'duration_minutes.integer' => 'The duration must be a number.',
            'duration_minutes.min' => 'The duration must be at least 1 minute.',
            'total_episodes.integer' => 'The total episodes must be a number.',
            'total_episodes.min' => 'The total episodes must be at least 1.',
            'feedback.numeric' => 'The feedback must be a number.',
            'feedback.between' => 'The feedback must be between 0 and 5.',
            
            // File validation messages
            'banner_image.image' => 'The banner must be an image file.',
            'banner_image.mimes' => 'The banner must be a file of type: jpeg, jpg, png, gif.',
            'banner_image.max' => 'The banner may not be greater than 2MB.',
            
            'trailer_file.file' => 'The trailer must be a valid file.',
            'trailer_file.mimes' => 'The trailer must be a file of type: mp4, avi, mov, wmv, flv, webm.',
            'trailer_file.max' => 'The trailer may not be greater than 100MB.',
            
            'video_file.file' => 'The video must be a valid file.',
            'video_file.mimes' => 'The video must be a file of type: mp4, avi, mov, wmv, flv, webm.',
            'video_file.max' => 'The video may not be greater than 500MB.',
            
            'trailer_url.required' => 'The trailer URL is required when trailer type is YouTube or S3.',
            'video_url.required' => 'The video URL is required when video type is YouTube or S3.',
            'video_type.required' => 'The video type is required for single videos.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'duration_minutes' => 'duration',
            'total_episodes' => 'total episodes',
            'banner_image' => 'banner image',
            'trailer_file' => 'trailer file',
            'trailer_url' => 'trailer URL',
            'video_file' => 'video file',
            'video_url' => 'video URL',
            'video_type' => 'video type',
            'trailer_type' => 'trailer type',
            'is_published' => 'publish status',
        ];
    }
}
