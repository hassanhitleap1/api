<?php

use Faker\Generator as Faker;
use App\User;
use App\Product;
use App\Seller;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'), // secret
        'remember_token' => str_random(10),
        'verified'=> $verified= $faker->randomElement([User::VERIFIED,User::UN_VERIFIED]),
        'verification_code'=>($verified)?null:User::genrateVerifactionCode(),
        'admin'=>  $faker->randomElement([User::REGULER_USER, User::ADMIN_USER]),
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' =>$faker->word,
        'description' => $faker->paragraph(1),
        'quantity'=> mt_rand(1,10),
        'status'=> $faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
        'image'=> $faker->randomElement(['1.png', '2.png','3.png']),
        'seller_id'=>User::all()->random()->id,
    ];
});

$factory->define(App\Transaction::class, function (Faker $faker) {
    $seller = Seller::has('products')->get()->random();
    $buyer  = User::all()->except($seller->id)->random();

    return [
        'quantity' =>  mt_rand(1,3),
        'buyer_id' =>$buyer->id,
        'product_id' =>$seller->products->random()->id,
    ];
});