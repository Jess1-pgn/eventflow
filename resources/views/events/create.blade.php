<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.events.index') }}" class="w-8 h-8 rounded-full bg-white/80 flex items-center justify-center hover:bg-white transition shadow-sm">
                <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('ui.create_event') }}</h2>
                <p class="mt-0.5 text-sm text-gray-500">Fill in the details below</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-6 md:p-8">
                <form method="POST" action="{{ route('dashboard.events.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="seo_slug" :value="__('Slug')" />
                        <x-text-input id="seo_slug" name="seo_slug" type="text" class="mt-1 block w-full" :value="old('seo_slug')" />
                        <x-input-error :messages="$errors->get('seo_slug')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description_html" :value="__('Description')" />
                        <textarea id="description_html" name="description_html" rows="5" class="form-input-modern mt-1 block w-full">{{ old('description_html') }}</textarea>
                        <x-input-error :messages="$errors->get('description_html')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="venue_id" :value="__('Venue')" />
                        <select id="venue_id" name="venue_id" class="form-input-modern mt-1 block w-full">
                            <option value="">{{ __('No venue') }}</option>
                            @foreach ($venues as $venue)
                                <option value="{{ $venue->id }}" @selected((int) old('venue_id') === $venue->id)>{{ $venue->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category_ids" :value="__('Categories')" />
                            <select id="category_ids" name="category_ids[]" multiple class="form-input-modern mt-1 block w-full">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(in_array($category->id, old('category_ids', []), true))>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_ids')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tag_ids" :value="__('Tags')" />
                            <select id="tag_ids" name="tag_ids[]" multiple class="form-input-modern mt-1 block w-full">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', []), true))>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tag_ids')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="timezone" :value="__('Timezone')" />
                            <select id="timezone" name="timezone" class="form-input-modern mt-1 block w-full" required>
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone }}" @selected(old('timezone', 'Africa/Casablanca') === $timezone)>{{ $timezone }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="starts_at" :value="__('Starts At')" />
                            <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full" :value="old('starts_at')" required />
                            <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="ends_at" :value="__('Ends At')" />
                            <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full" :value="old('ends_at')" required />
                            <x-input-error :messages="$errors->get('ends_at')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="form-input-modern mt-1 block w-full" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', 'draft') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="meta_title" :value="__('Meta Title')" />
                            <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title')" />
                            <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="meta_description" :value="__('Meta Description')" />
                            <x-text-input id="meta_description" name="meta_description" type="text" class="mt-1 block w-full" :value="old('meta_description')" />
                            <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="cover_image_path" :value="__('Cover Image Path')" />
                            <x-text-input id="cover_image_path" name="cover_image_path" type="text" class="mt-1 block w-full" :value="old('cover_image_path')" />
                            <x-input-error :messages="$errors->get('cover_image_path')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="banner_image_path" :value="__('Banner Image Path')" />
                            <x-text-input id="banner_image_path" name="banner_image_path" type="text" class="mt-1 block w-full" :value="old('banner_image_path')" />
                            <x-input-error :messages="$errors->get('banner_image_path')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <x-primary-button>{{ __('Create') }}</x-primary-button>
                        <a href="{{ route('dashboard.events.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
