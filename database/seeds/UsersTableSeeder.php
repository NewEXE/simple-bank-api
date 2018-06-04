<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $password = Hash::make('secret');

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => $password,
        ]);

//        $faker = \Faker\Factory::create();

//        for ($i = 0; $i < 10; $i++) {
//            User::create([
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => $password,
//            ]);
//        }
    }
}
