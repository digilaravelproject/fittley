<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\HomepageHero;

class StoreHomepageHeroRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'youtube_video_url' => 'required|url',
            'play_button_text' => 'required|string|max:50',
            'play_button_link' => 'nullable|url',
            'trailer_button_text' => 'required|string|max:50',
            'trailer_button_link' => 'nullable|url',
            'category' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:20',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'youtube_video_url.url' => 'Please provide a valid YouTube URL.',
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'play_button_text.required' => 'Play button text is required.',
            'trailer_button_text.required' => 'Trailer button text is required.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Extract YouTube video ID from URL
        $videoId = null;
        if ($this->has('youtube_video_url') && $this->youtube_video_url) {
            $videoId = HomepageHero::extractYoutubeId($this->youtube_video_url);
        }

        $this->merge([
            'youtube_video_id' => $videoId,
        ]);

        // Set defaults
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->integer('sort_order') ?: 0,
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->youtube_video_url) {
                $videoId = HomepageHero::extractYoutubeId($this->youtube_video_url);
                if (!$videoId) {
                    $validator->errors()->add('youtube_video_url', 'Invalid YouTube URL format.');
                }
            }
        });
    }
}
