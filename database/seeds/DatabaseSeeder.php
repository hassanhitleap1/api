<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\User;
use App\Category;
use App\Transaction;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHCKES =1 ');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $usersQuantity=200;
        $categoryQuantity=30;
        $productsQuantity=1000;
        $transctionsQuantity=1000;

        factory(User::class,$usersQuantity)-create();

        factory(Category::class,$categoryQuantity)-create();

        factory(Product::class,$productsQuantity)-create()->each(function($product){
            $categories=Category::all()->random(mt_rand(1,5))->plack('id');
            $product->categories()->attach($categories);
        });

        factory(Transaction::class,$transctionsQuantity)-create();
    }
}
