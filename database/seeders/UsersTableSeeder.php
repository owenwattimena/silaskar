<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $users = [
            [
                "name" => "Owen Wattimena",
                "username" => "wentoxwtt",
                "password" =>  Hash::make("Wentox_superadmin12345"),
                "division_id" => 1,
                "phone_number" => "085244140715",
            ],
            [
                "name" => "Administrator",
                "username" => "administrator",
                "password" =>  Hash::make("admin12345"),
                "division_id" => 2,
            ]
        ];
        
        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}