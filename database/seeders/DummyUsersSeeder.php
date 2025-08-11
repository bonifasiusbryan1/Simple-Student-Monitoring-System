<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'username'=> 'Hernan Sandi Laksono',
                'email' => 'hernanlaksono@gmail.com',
                'role' => 'mahasiswa',
                'password' => bcrypt('123456')
            ],
            [
                'username'=> 'Guruh Aryetejo',
                'email' => 'guruharyetejo@gmail.com',
                'role' => 'dosenWali',
                'password' => bcrypt('123456')
            ],
            [
                'username'=> 'Aris Puji',
                'email' => 'arispuji@gmail.com',
                'role' => 'departemen',
                'password' => bcrypt('123456')
            ],[
                'username'=> 'Benny',
                'email' => 'benny@gmail.com',
                'role' => 'operator',
                'password' => bcrypt('123456')
            ],

        ];

        foreach ($userData as $key => $val){
            User::create($val);
        }
    }
}
