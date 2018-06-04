<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->call(UsersTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);

        $this->enableForeignKeys();
    }
}
