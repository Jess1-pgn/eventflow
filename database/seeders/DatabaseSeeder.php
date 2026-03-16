<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            DemoUsersSeeder::class,
            DemoCategoriesSeeder::class,
            DemoVenuesSeeder::class,
            DemoTagsSeeder::class,
            DemoEventsSeeder::class,
            DemoTicketTypesSeeder::class,
            DemoOrdersSeeder::class,
        ]);
    }
}
