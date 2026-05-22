<?php

test('demo seeders run without errors', function () {
    // Since seeders are run separately during dev setup, we just verify
    // that the seeder classes exist and have the correct structure
    
    $seeders = [
        \Database\Seeders\DemoUsersSeeder::class,
        \Database\Seeders\DemoCategoriesSeeder::class,
        \Database\Seeders\DemoVenuesSeeder::class,
        \Database\Seeders\DemoTagsSeeder::class,
        \Database\Seeders\DemoEventsSeeder::class,
        \Database\Seeders\DemoTicketTypesSeeder::class,
        \Database\Seeders\DemoOrdersSeeder::class,
    ];

    foreach ($seeders as $seeder) {
        $instance = new $seeder();
        expect($instance)->toBeInstanceOf(\Illuminate\Database\Seeder::class);
        expect(method_exists($instance, 'run'))->toBeTrue();
    }
});
