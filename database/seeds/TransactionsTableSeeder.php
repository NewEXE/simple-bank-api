<?php

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;

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

            for ($i = 0; $i < 50; $i++)
            {
                $transaction = new Transaction();

                $transaction->date = $faker->date();
                $transaction->amount = $faker->randomFloat(2, 1, 255);

                $transaction->save();
            }
        }
    }
}
