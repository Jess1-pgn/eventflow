<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Demo Super Admin
        User::query()->firstOrCreate(
            ['email' => 'admin@eventflow.test'],
            [
                'name' => 'Admin EventFlow',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        )->syncRoles(['super-admin']);

        // Demo Organizers
        $organizer1 = User::query()->firstOrCreate(
            ['email' => 'organizer1@eventflow.test'],
            [
                'name' => 'Sarah Johnson',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $organizer1->syncRoles(['organizer']);

        $organizer2 = User::query()->firstOrCreate(
            ['email' => 'organizer2@eventflow.test'],
            [
                'name' => 'Michel Chen',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $organizer2->syncRoles(['organizer']);

        // Demo Staff
        $staff = User::query()->firstOrCreate(
            ['email' => 'staff@eventflow.test'],
            [
                'name' => 'John Smith (Staff)',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $staff->syncRoles(['staff']);

        // Demo Attendees
        User::query()->firstOrCreate(
            ['email' => 'attendee@eventflow.test'],
            [
                'name' => 'Emma Wilson',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        )->syncRoles(['attendee']);

        User::query()->firstOrCreate(
            ['email' => 'buyer@eventflow.test'],
            [
                'name' => 'David Martinez',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        )->syncRoles(['attendee']);
    }
}
