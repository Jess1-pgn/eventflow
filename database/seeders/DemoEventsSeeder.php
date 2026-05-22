<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use App\Models\User;
use App\Models\Venue;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class DemoEventsSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = User::query()->whereHas('roles', fn ($q) => $q->where('name', 'organizer'))->get();
        $categories = Category::all();
        $venues = Venue::all();
        $tags = Tag::all();

        // Event 1: Tech Conference 2026
        $event1 = Event::query()->firstOrCreate(
            ['seo_slug' => 'tech-conference-2026'],
            [
                'organizer_id' => $organizers->first()->id,
                'venue_id' => $venues->where('city', 'San Francisco')->first()->id,
                'title' => 'Tech Conference 2026: The Future of AI',
                'description_html' => '<h2>Join us for the biggest tech conference of the year!</h2>
<p>Discover cutting-edge innovations, network with industry leaders, and explore the future of artificial intelligence and machine learning.</p>
<h3>What to Expect:</h3>
<ul>
<li>Keynote speeches from top tech leaders</li>
<li>Interactive workshops and hands-on sessions</li>
<li>Exhibition floor with 50+ vendor booths</li>
<li>Networking mixers and social events</li>
<li>Catered meals and refreshments</li>
</ul>',
                'timezone' => 'America/Los_Angeles',
                'starts_at' => now()->addDays(45)->startOfDay()->addHours(9),
                'ends_at' => now()->addDays(47)->startOfDay()->addHours(17),
                'status' => Event::STATUS_PUBLISHED,
                'meta_title' => 'Tech Conference 2026 - AI & Innovation Summit',
                'meta_description' => 'Join 1,000+ tech leaders at the premier AI and innovation conference. March 2026 in San Francisco.',
            ]
        );
        $event1->categories()->sync($categories->whereIn('slug', ['technology', 'business'])->pluck('id'));
        $event1->tags()->sync($tags->whereIn('name', ['AI & Machine Learning', 'Trending', 'Large Event'])->pluck('id'));

        // Event 2: Design Workshop
        $event2 = Event::query()->firstOrCreate(
            ['seo_slug' => 'design-workshop-ux'],
            [
                'organizer_id' => $organizers->last()->id,
                'venue_id' => $venues->where('city', 'Los Angeles')->first()->id,
                'title' => 'Modern UX Design Workshop',
                'description_html' => '<h2>Master the latest UX design techniques in just one day!</h2>
<p>An intensive hands-on workshop for designers of all levels who want to improve their craft.</p>
<h3>Topics Covered:</h3>
<ul>
<li>Design thinking and user research</li>
<li>Wireframing and prototyping</li>
<li>Design systems and component libraries</li>
<li>Accessibility best practices</li>
<li>Tools and frameworks for modern design</li>
</ul>
<p><strong>Includes:</strong> Materials, lunch, and certificate of completion</p>',
                'timezone' => 'America/Los_Angeles',
                'starts_at' => now()->addDays(30)->startOfDay()->addHours(10),
                'ends_at' => now()->addDays(30)->startOfDay()->addHours(17),
                'status' => Event::STATUS_PUBLISHED,
                'meta_title' => 'UX Design Workshop - One Day Intensive',
                'meta_description' => 'Learn modern UX design in a hands-on workshop. Limited to 40 participants.',
            ]
        );
        $event2->categories()->sync($categories->whereIn('slug', ['design', 'education'])->pluck('id'));
        $event2->tags()->sync($tags->whereIn('name', ['Hands-on Workshop', 'Beginner Friendly', 'Expert Level'])->pluck('id'));

        // Event 3: Business Networking Mixer
        $event3 = Event::query()->firstOrCreate(
            ['seo_slug' => 'business-networking-mixer'],
            [
                'organizer_id' => $organizers->first()->id,
                'venue_id' => $venues->where('city', 'New York')->first()->id,
                'title' => 'Enterprise Leaders Networking Mixer',
                'description_html' => '<h2>Meet the brightest minds in business and startups!</h2>
<p>A casual evening networking event with refreshments, food, and great conversation.</p>
<h3>Who Should Attend:</h3>
<ul>
<li>Founders and CEOs</li>
<li>Business development professionals</li>
<li>Investors and venture capitalists</li>
<li>Corporate strategy leaders</li>
</ul>
<p>Come make meaningful connections that could lead to partnerships and collaborations!</p>',
                'timezone' => 'America/New_York',
                'starts_at' => now()->addDays(20)->startOfDay()->addHours(18),
                'ends_at' => now()->addDays(20)->startOfDay()->addHours(21),
                'status' => Event::STATUS_PUBLISHED,
                'meta_title' => 'Enterprise Leaders Networking - NYC',
                'meta_description' => 'Exclusive networking event for business leaders. Free entry for registered professionals.',
            ]
        );
        $event3->categories()->sync($categories->whereIn('slug', ['business', 'networking'])->pluck('id'));
        $event3->tags()->sync($tags->whereIn('name', ['Networking', 'Premium', 'Intimate Gathering'])->pluck('id'));

        // Event 4: Fitness Summit
        $event4 = Event::query()->firstOrCreate(
            ['seo_slug' => 'wellness-fitness-summit'],
            [
                'organizer_id' => $organizers->last()->id,
                'venue_id' => $venues->where('city', 'Austin')->first()->id,
                'title' => 'Wellness & Fitness Summit 2026',
                'description_html' => '<h2>Transform Your Health in 2026!</h2>
<p>A comprehensive summit covering fitness, nutrition, mental wellness, and holistic health.</p>
<h3>Features:</h3>
<ul>
<li>Expert talks on fitness trends</li>
<li>Yoga and meditation sessions</li>
<li>Nutrition masterclass with celebrity chefs</li>
<li>One-on-one coaching consultations</li>
<li>Wellness product exposition</li>
</ul>
<p>All skill levels welcome!</p>',
                'timezone' => 'America/Chicago',
                'starts_at' => now()->addDays(60)->startOfDay()->addHours(8),
                'ends_at' => now()->addDays(62)->startOfDay()->addHours(18),
                'status' => Event::STATUS_PUBLISHED,
                'meta_title' => 'Wellness & Fitness Summit 2026 - Austin TX',
                'meta_description' => 'Three days of fitness, health, and wellness education. Early bird tickets available.',
            ]
        );
        $event4->categories()->sync($categories->whereIn('slug', ['health-wellness', 'education'])->pluck('id'));
        $event4->tags()->sync($tags->whereIn('name', ['Beginner Friendly', 'Trending', 'Large Event'])->pluck('id'));

        // Event 5: Virtual Masterclass
        $event5 = Event::query()->firstOrCreate(
            ['seo_slug' => 'digital-marketing-masterclass'],
            [
                'organizer_id' => $organizers->first()->id,
                'venue_id' => $venues->where('city', 'Worldwide')->first()->id,
                'title' => 'Digital Marketing Masterclass',
                'description_html' => '<h2>Master Modern Digital Marketing Strategy</h2>
<p>Join industry experts for an intensive 4-week online masterclass on digital marketing strategy, tactics, and execution.</p>
<h3>Learn:</h3>
<ul>
<li>SEO and content marketing strategy</li>
<li>Social media marketing and advertising</li>
<li>Email marketing and automation</li>
<li>Analytics and conversion optimization</li>
<li>Building and scaling digital campaigns</li>
</ul>
<p><strong>Format:</strong> Live sessions 2x weekly + recorded content access + community support</p>',
                'timezone' => 'America/New_York',
                'starts_at' => now()->addDays(15)->startOfDay()->addHours(14),
                'ends_at' => now()->addDays(45)->startOfDay()->addHours(15),
                'status' => Event::STATUS_PUBLISHED,
                'meta_title' => 'Digital Marketing Masterclass - Online',
                'meta_description' => 'Live online masterclass with industry leaders. 4 weeks, flexible schedule.',
            ]
        );
        $event5->categories()->sync($categories->whereIn('slug', ['marketing', 'education'])->pluck('id'));
        $event5->tags()->sync($tags->whereIn('name', ['Virtual', 'Expert Level', 'Hands-on Workshop'])->pluck('id'));

        $this->seedDiscoveryCatalog($organizers, $venues, $categories, $tags);
    }

    private function seedDiscoveryCatalog($organizers, $venues, $categories, $tags): void
    {
        if ($organizers->isEmpty()) {
            return;
        }

        $catalog = [
            ['slug' => 'frontend-performance-lab', 'title' => 'Frontend Performance Lab', 'city' => 'San Francisco', 'timezone' => 'America/Los_Angeles', 'days' => 10, 'hour' => 9, 'duration' => 8, 'categories' => ['technology', 'workshop'], 'tags' => ['Web Development', 'Hands-on Workshop']],
            ['slug' => 'saas-pricing-intensive', 'title' => 'SaaS Pricing Intensive', 'city' => 'New York', 'timezone' => 'America/New_York', 'days' => 12, 'hour' => 14, 'duration' => 6, 'categories' => ['business', 'marketing'], 'tags' => ['Leadership', 'Premium']],
            ['slug' => 'creative-portfolio-bootcamp', 'title' => 'Creative Portfolio Bootcamp', 'city' => 'Los Angeles', 'timezone' => 'America/Los_Angeles', 'days' => 14, 'hour' => 10, 'duration' => 7, 'categories' => ['design', 'education'], 'tags' => ['Beginner Friendly', 'Hands-on Workshop']],
            ['slug' => 'future-of-remote-teams', 'title' => 'Future of Remote Teams Summit', 'city' => 'Worldwide', 'timezone' => 'America/New_York', 'days' => 16, 'hour' => 16, 'duration' => 3, 'categories' => ['business', 'networking'], 'tags' => ['Virtual', 'Trending']],
            ['slug' => 'founder-speed-networking-night', 'title' => 'Founder Speed Networking Night', 'city' => 'Austin', 'timezone' => 'America/Chicago', 'days' => 18, 'hour' => 19, 'duration' => 3, 'categories' => ['networking', 'business'], 'tags' => ['Networking', 'Intimate Gathering']],
            ['slug' => 'data-analytics-for-marketers', 'title' => 'Data Analytics for Marketers', 'city' => 'San Francisco', 'timezone' => 'America/Los_Angeles', 'days' => 22, 'hour' => 11, 'duration' => 6, 'categories' => ['marketing', 'education'], 'tags' => ['Trending', 'Expert Level']],
            ['slug' => 'product-leadership-masterclass', 'title' => 'Product Leadership Masterclass', 'city' => 'New York', 'timezone' => 'America/New_York', 'days' => 24, 'hour' => 9, 'duration' => 7, 'categories' => ['technology', 'business'], 'tags' => ['Leadership', 'Premium']],
            ['slug' => 'sports-startup-demo-day', 'title' => 'Sports Startup Demo Day', 'city' => 'Austin', 'timezone' => 'America/Chicago', 'days' => 27, 'hour' => 15, 'duration' => 5, 'categories' => ['sports', 'business'], 'tags' => ['Innovation', 'Networking']],
            ['slug' => 'mental-wellness-retreat-day', 'title' => 'Mental Wellness Retreat Day', 'city' => 'Los Angeles', 'timezone' => 'America/Los_Angeles', 'days' => 29, 'hour' => 8, 'duration' => 10, 'categories' => ['health-wellness', 'education'], 'tags' => ['Beginner Friendly', 'Large Event']],
            ['slug' => 'growth-marketing-live-clinic', 'title' => 'Growth Marketing Live Clinic', 'city' => 'Worldwide', 'timezone' => 'America/New_York', 'days' => 31, 'hour' => 17, 'duration' => 4, 'categories' => ['marketing', 'workshop'], 'tags' => ['Virtual', 'Hands-on Workshop']],
            ['slug' => 'laravel-livewire-community-day', 'title' => 'Laravel Livewire Community Day', 'city' => 'San Francisco', 'timezone' => 'America/Los_Angeles', 'days' => 34, 'hour' => 10, 'duration' => 8, 'categories' => ['technology', 'networking'], 'tags' => ['Web Development', 'Large Event']],
            ['slug' => 'creator-economy-summit', 'title' => 'Creator Economy Summit', 'city' => 'New York', 'timezone' => 'America/New_York', 'days' => 36, 'hour' => 9, 'duration' => 9, 'categories' => ['marketing', 'business'], 'tags' => ['Trending', 'Innovation']],
            ['slug' => 'visual-storytelling-studio', 'title' => 'Visual Storytelling Studio', 'city' => 'Los Angeles', 'timezone' => 'America/Los_Angeles', 'days' => 39, 'hour' => 13, 'duration' => 6, 'categories' => ['design', 'workshop'], 'tags' => ['Hands-on Workshop', 'Expert Level']],
            ['slug' => 'global-hr-innovation-forum', 'title' => 'Global HR Innovation Forum', 'city' => 'Worldwide', 'timezone' => 'America/New_York', 'days' => 42, 'hour' => 15, 'duration' => 4, 'categories' => ['business', 'education'], 'tags' => ['Virtual', 'Leadership']],
            ['slug' => 'women-in-tech-breakfast', 'title' => 'Women in Tech Breakfast', 'city' => 'Austin', 'timezone' => 'America/Chicago', 'days' => 44, 'hour' => 8, 'duration' => 3, 'categories' => ['technology', 'networking'], 'tags' => ['Networking', 'Intimate Gathering']],
            ['slug' => 'community-health-fair-2026', 'title' => 'Community Health Fair 2026', 'city' => 'San Francisco', 'timezone' => 'America/Los_Angeles', 'days' => 46, 'hour' => 10, 'duration' => 7, 'categories' => ['health-wellness', 'entertainment'], 'tags' => ['Free Entry', 'Large Event']],
            ['slug' => 'student-entrepreneur-challenge', 'title' => 'Student Entrepreneur Challenge', 'city' => 'New York', 'timezone' => 'America/New_York', 'days' => 49, 'hour' => 12, 'duration' => 6, 'categories' => ['education', 'business'], 'tags' => ['Beginner Friendly', 'Innovation']],
            ['slug' => 'ai-product-design-sprint', 'title' => 'AI Product Design Sprint', 'city' => 'Los Angeles', 'timezone' => 'America/Los_Angeles', 'days' => 53, 'hour' => 9, 'duration' => 8, 'categories' => ['technology', 'design'], 'tags' => ['AI & Machine Learning', 'Hands-on Workshop']],
            ['slug' => 'hybrid-sales-leadership-day', 'title' => 'Hybrid Sales Leadership Day', 'city' => 'Worldwide', 'timezone' => 'America/New_York', 'days' => 57, 'hour' => 16, 'duration' => 4, 'categories' => ['business', 'marketing'], 'tags' => ['Hybrid', 'Leadership']],
            ['slug' => 'startup-fitness-challenge', 'title' => 'Startup Fitness Challenge', 'city' => 'Austin', 'timezone' => 'America/Chicago', 'days' => 61, 'hour' => 7, 'duration' => 5, 'categories' => ['sports', 'health-wellness'], 'tags' => ['Trending', 'Beginner Friendly']],
        ];

        foreach ($catalog as $index => $entry) {
            $venue = $venues->firstWhere('city', $entry['city']) ?? $venues->first();
            $organizer = $organizers->get($index % $organizers->count());
            $startsAt = CarbonImmutable::now($entry['timezone'])
                ->addDays($entry['days'])
                ->setTime($entry['hour'], 0);

            $event = Event::query()->firstOrCreate(
                ['seo_slug' => $entry['slug']],
                [
                    'organizer_id' => $organizer->id,
                    'venue_id' => $venue?->id,
                    'title' => $entry['title'],
                    'description_html' => '<h2>'.$entry['title'].'</h2><p>Join this curated event experience on EventFlow. Meet peers, learn practical tactics, and leave with clear next steps.</p><p>Includes speaker sessions, networking opportunities, and actionable resources for attendees.</p>',
                    'timezone' => $entry['timezone'],
                    'starts_at' => $startsAt,
                    'ends_at' => $startsAt->addHours($entry['duration']),
                    'status' => Event::STATUS_PUBLISHED,
                    'meta_title' => $entry['title'].' | EventFlow',
                    'meta_description' => 'Explore '.$entry['title'].' and discover practical insights, networking, and curated sessions.',
                ]
            );

            $event->categories()->sync(
                $categories->whereIn('slug', $entry['categories'])->pluck('id')
            );

            $event->tags()->sync(
                $tags->whereIn('slug', $entry['tags'])->pluck('id')
            );
        }
    }
}
