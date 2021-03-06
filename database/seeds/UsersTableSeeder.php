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
        $cnp = str_random(60);

        User::create([
            'name' => 'Administrator',
            'cnp' => $cnp,
            'password' => $password
        ]);
    }
}
