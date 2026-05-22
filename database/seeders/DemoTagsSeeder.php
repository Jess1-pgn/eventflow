<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class DemoTagsSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'AI & Machine Learning', 'slug' => 'ai-machine-learning'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Leadership', 'slug' => 'leadership'],
            ['name' => 'Innovation', 'slug' => 'innovation'],
            ['name' => 'Trending', 'slug' => 'trending'],
            ['name' => 'Beginner Friendly', 'slug' => 'beginner-friendly'],
            ['name' => 'Expert Level', 'slug' => 'expert-level'],
            ['name' => 'Networking', 'slug' => 'networking'],
            ['name' => 'Hands-on Workshop', 'slug' => 'hands-on-workshop'],
            ['name' => 'Virtual', 'slug' => 'virtual'],
            ['name' => 'Hybrid', 'slug' => 'hybrid'],
            ['name' => 'Large Event', 'slug' => 'large-event'],
            ['name' => 'Intimate Gathering', 'slug' => 'intimate-gathering'],
            ['name' => 'Free Entry', 'slug' => 'free-entry'],
            ['name' => 'Premium', 'slug' => 'premium'],
        ];

        foreach ($tags as $tag) {
            Tag::query()->firstOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }
    }
}
