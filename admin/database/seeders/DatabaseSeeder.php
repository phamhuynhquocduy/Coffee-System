<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'admin123',
            'email' => '521d6651b4-1d6551@inbox.mailtrap.io',
            'password' => Hash::make('admin')
        ];

        User::insert($admin);
    }
}
