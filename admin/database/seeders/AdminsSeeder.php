<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name' => 'Admin',
                'username' => 'admin123',
                'password' => md5('123456789'),
                'email' => 'duchoaikevin279@gmail.com'
            ],
        ];
        Admin::insert($data);
    }
}
