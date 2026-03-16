<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Seeder;

class DemoTicketTypesSeeder extends Seeder
{
    public function run(): void
    {
        // Tech Conference tickets
        $event1 = Event::query()->where('seo_slug', 'tech-conference-2026')->first();
        if ($event1) {
            TicketType::query()->firstOrCreate(
                ['event_id' => $event1->id, 'name' => 'Early Bird'],
                [
                    'is_free' => false,
                    'price_amount' => 29900, // $299
                    'currency' => 'USD',
                    'max_per_order' => 5,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event1->id, 'name' => 'Standard'],
                [
                    'is_free' => false,
                    'price_amount' => 39900, // $399
                    'currency' => 'USD',
                    'max_per_order' => 5,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event1->id, 'name' => 'VIP Pass'],
                [
                    'is_free' => false,
                    'price_amount' => 79900, // $799
                    'currency' => 'USD',
                    'max_per_order' => 3,
                ]
            );
        }

        // Design Workshop tickets
        $event2 = Event::query()->where('seo_slug', 'design-workshop-ux')->first();
        if ($event2) {
            TicketType::query()->firstOrCreate(
                ['event_id' => $event2->id, 'name' => 'Participant'],
                [
                    'is_free' => false,
                    'price_amount' => 14900, // $149
                    'currency' => 'USD',
                    'max_per_order' => 2,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event2->id, 'name' => 'Student Discount'],
                [
                    'is_free' => false,
                    'price_amount' => 7900, // $79
                    'currency' => 'USD',
                    'max_per_order' => 1,
                ]
            );
        }

        // Networking Mixer tickets
        $event3 = Event::query()->where('seo_slug', 'business-networking-mixer')->first();
        if ($event3) {
            TicketType::query()->firstOrCreate(
                ['event_id' => $event3->id, 'name' => 'Free Entry'],
                [
                    'is_free' => true,
                    'price_amount' => 0,
                    'currency' => 'USD',
                    'max_per_order' => 2,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event3->id, 'name' => 'Premium Plus'],
                [
                    'is_free' => false,
                    'price_amount' => 4900, // $49
                    'currency' => 'USD',
                    'max_per_order' => 2,
                ]
            );
        }

        // Wellness Summit tickets
        $event4 = Event::query()->where('seo_slug', 'wellness-fitness-summit')->first();
        if ($event4) {
            TicketType::query()->firstOrCreate(
                ['event_id' => $event4->id, 'name' => 'Single Day'],
                [
                    'is_free' => false,
                    'price_amount' => 7900, // $79
                    'currency' => 'USD',
                    'max_per_order' => 4,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event4->id, 'name' => 'Full Summit Pass'],
                [
                    'is_free' => false,
                    'price_amount' => 19900, // $199
                    'currency' => 'USD',
                    'max_per_order' => 4,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event4->id, 'name' => 'VIP All-Access'],
                [
                    'is_free' => false,
                    'price_amount' => 39900, // $399
                    'currency' => 'USD',
                    'max_per_order' => 2,
                ]
            );
        }

        // Digital Marketing Masterclass tickets
        $event5 = Event::query()->where('seo_slug', 'digital-marketing-masterclass')->first();
        if ($event5) {
            TicketType::query()->firstOrCreate(
                ['event_id' => $event5->id, 'name' => 'Standard Access'],
                [
                    'is_free' => false,
                    'price_amount' => 29900, // $299
                    'currency' => 'USD',
                    'max_per_order' => 1,
                ]
            );

            TicketType::query()->firstOrCreate(
                ['event_id' => $event5->id, 'name' => 'Premium with Coaching'],
                [
                    'is_free' => false,
                    'price_amount' => 59900, // $599
                    'currency' => 'USD',
                    'max_per_order' => 1,
                ]
            );
        }
    }
}
