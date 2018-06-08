<?php

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'date' => $faker->date(Transaction::DATE_FORMAT_SET),
        'amount' => $faker->randomFloat(2, 1, 255),
    ];
});
