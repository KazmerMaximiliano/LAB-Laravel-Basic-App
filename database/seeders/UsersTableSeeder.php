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
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Other',
            'email' => 'other@mail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
            'email_verified_at' => now()
        ]);
    }
}
