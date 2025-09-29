<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFiBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('admin') || 
            auth()->user()->hasRole('instructor')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $blogId = $this->route('fiBlog') ? $this->route('fiBlog')->id : null;
        
        return [
            // Basic Content
            'fi_category_id' => 'required|exists:fi_categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('fi_blogs', 'slug')->ignore($blogId)
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            
            // Images
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'featured_image_alt' => 'nullable|string|max:255',
            'social_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            
            // SEO Fields
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'social_title' => 'nullable|string|max:60',
            'social_description' => 'nullable|string|max:160',
            
            // Publishing
            'status' => 'required|in:draft,published,scheduled,archived',
            'published_at' => 'nullable|date|after_or_equal:now',
            'scheduled_at' => 'nullable|date|after:now',
            
            // Settings
            'allow_comments' => 'boolean',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            
            // Tags
            'tags' => 'nullable|array|max:10',
            'tags.*' => 'string|max:50',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'fi_category_id.required' => 'Please select a category.',
            'fi_category_id.exists' => 'Selected category does not exist.',
            'title.required' => 'Blog title is required.',
            'title.max' => 'Blog title cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'Slug can only contain lowercase letters, numbers, and hyphens.',
            'content.required' => 'Blog content is required.',
            'content.min' => 'Blog content must be at least 100 characters long.',
            'excerpt.max' => 'Excerpt cannot exceed 500 characters.',
            
            'featured_image.image' => 'Featured image must be a valid image file.',
            'featured_image.mimes' => 'Featured image must be JPEG, PNG, JPG, or WebP.',
            'featured_image.max' => 'Featured image cannot exceed 5MB.',
            'social_image.image' => 'Social image must be a valid image file.',
            'social_image.mimes' => 'Social image must be JPEG, PNG, JPG, or WebP.',
            'social_image.max' => 'Social image cannot exceed 5MB.',
            
            'meta_title.max' => 'Meta title should not exceed 60 characters for optimal SEO.',
            'meta_description.max' => 'Meta description should not exceed 160 characters for optimal SEO.',
            'canonical_url.url' => 'Canonical URL must be a valid URL.',
            'social_title.max' => 'Social title should not exceed 60 characters.',
            'social_description.max' => 'Social description should not exceed 160 characters.',
            
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'published_at.after_or_equal' => 'Published date cannot be in the past.',
            'scheduled_at.after' => 'Scheduled date must be in the future.',
            
            'tags.max' => 'You can add maximum 10 tags.',
            'tags.*.max' => 'Each tag cannot exceed 50 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values
        $this->merge([
            'allow_comments' => $this->boolean('allow_comments'),
            'is_featured' => $this->boolean('is_featured'),
            'is_trending' => $this->boolean('is_trending'),
        ]);

        // Auto-generate slug if not provided
        if (empty($this->slug) && !empty($this->title)) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->title)
            ]);
        }

        // Set author_id to current user if creating new blog
        if (!$this->route('fiBlog')) {
            $this->merge([
                'author_id' => auth()->id()
            ]);
        }

        // Process tags - convert comma-separated to array
        if ($this->has('tags') && is_string($this->tags)) {
            $tags = array_map('trim', explode(',', $this->tags));
            $tags = array_filter($tags); // Remove empty values
            $this->merge(['tags' => $tags]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate scheduled publishing
            if ($this->status === 'scheduled' && !$this->scheduled_at) {
                $validator->errors()->add('scheduled_at', 'Scheduled date is required when status is scheduled.');
            }
            
            // Validate published status
            if ($this->status === 'published' && $this->scheduled_at) {
                $validator->errors()->add('status', 'Cannot set status to published when scheduled date is set.');
            }
        });
    }
}
