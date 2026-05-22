<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Role::findOrCreate('super-admin');
        Role::findOrCreate('organizer');
        Role::findOrCreate('staff');
        Role::findOrCreate('attendee');
    }
}
