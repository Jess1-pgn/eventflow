<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use App\Models\User;
use App\Models\Venue;
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
    }
}
