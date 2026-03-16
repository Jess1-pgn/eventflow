<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DemoCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Education', 'slug' => 'education'],
            ['name' => 'Entertainment', 'slug' => 'entertainment'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Health & Wellness', 'slug' => 'health-wellness'],
            ['name' => 'Networking', 'slug' => 'networking'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
