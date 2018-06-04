<?php

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Schema::hasTable(Transaction::getTableName()))
        {
            Transaction::truncate();

            $faker = \Faker\Factory::create();

            $user = User::findOrFail(1);

            for ($i = 0; $i < 50; $i++)
            {
                $date = $faker->date();
                $amount = $faker->randomFloat(2, 1, 255);

                $user->transactions()->create([
                    'date' => $date,
                    'amount' => $amount,
                ]);
            }
        }
    }
}
