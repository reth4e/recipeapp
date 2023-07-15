<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('sample00'),
            'is_admin' => TRUE,
        ]);

        User::create([
            'name' => '一般ユーザー' ,
            'email' => 'user@example.com',
            'password' => Hash::make('sample01'),
        ]);
    }
}
