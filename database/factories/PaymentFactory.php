<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Payment;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'dvla_application_id' => 1,
        'momo_transaction_id' => $faker->uuid,
        'status' => 'SUCCESSFUL',
        'amount' => $faker->randomFloat(2, 0, 1000),
        'payer_message' => $faker->realText,
        'payee_note' => $faker->realText,
    ];
});
