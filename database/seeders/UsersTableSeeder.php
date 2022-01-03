<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 2,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Broker',
            'email' => 'broker@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 3,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 4,
            'email_verified_at' => now()
        ]);
    }
}
