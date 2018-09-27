<?php

use Illuminate\Http\Request;

/*clear
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 * route for buyers
*/
Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);

/**
 * route for categories
*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);


/**
 * route for products
*/
Route::resource('products','Product\ProductController',['only'=>['index','show']]);


/**
 * route for sellers
*/
//Route::resource('sellers','Seller/SellerController',['only'=>['index','show']]);


/**
 * route for transactions
*/
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);


/**
 * route for users
*/
Route::resource('users','User\UserController',['except'=>['create','edit']]);


