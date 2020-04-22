<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\DvlaApplication;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(DvlaApplication::class, function (Faker $faker) {
    return [
        //'user_id' => 1,
        'name' => $faker->name,
        'license_class' => 'B',
        'dvla_center' => 'Koforidua',
        'service_type' => 'Standard',
        'payment_option' => 'MTN_MOMO',
        'comments' => $faker->realText,
    ];
});
