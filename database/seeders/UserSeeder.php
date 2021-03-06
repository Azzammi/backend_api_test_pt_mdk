<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clear the table first
        //User::truncate();
        $faker = \Faker\Factory::create();

        $password = Hash::make('admin');
        User::create([
            'email' => 'luthfia911@gmail.com',
            'name' => 'Luthfi',
            'password' => $password,
            'status' => 'aktif',
        ]);

        //Generate some for the sample purpose
        for($i = 0; $i < 20; $i++){
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password
            ]);
        }
    }
}
