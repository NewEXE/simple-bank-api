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

        $cnp = str_random(60);

        User::create([
            'name' => 'Administrator',
            'cnp' => $cnp,
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
