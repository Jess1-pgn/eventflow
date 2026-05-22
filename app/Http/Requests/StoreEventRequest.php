<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Event::class) ?? false;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description_html' => ['nullable', 'string'],
            'venue_id' => ['nullable', 'integer', 'exists:venues,id'],
            'timezone' => ['required', 'timezone'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'status' => ['required', Rule::in(Event::STATUSES)],
            'seo_slug' => ['required', 'string', 'max:255', Rule::unique('events', 'seo_slug')],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'cover_image_path' => ['nullable', 'string', 'max:255'],
            'banner_image_path' => ['nullable', 'string', 'max:255'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $title = (string) $this->input('title', '');
        $providedSlug = (string) $this->input('seo_slug', '');

        $slug = $providedSlug !== ''
            ? Event::buildUniqueSlug($providedSlug)
            : Event::buildUniqueSlug($title);

        $this->merge([
            'seo_slug' => $slug,
        ]);
    }
}
