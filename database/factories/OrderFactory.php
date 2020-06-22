<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'order_id'=>$faker->randomNumber($nbDigits=6),
        'order_type'=> $faker->text(50),
        'order_message'=>$faker->text(50),
        'order_price'=> 20.00,
        'order_status'=> 'unclaimed',
        'payout_status'=>'in-progress',

    ];
});
