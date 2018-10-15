<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBuyerTransactionController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $buyer)
    {
        $rules=[
            'quantity'=>'integer|min:1'
        ];
        $this->validate($request->all(),$rules);

        if($buyer->id ==$product->seller_id){
            return $this->errorResponce('the bouyer same seller ',409);
        }
        if(! $buyer->isVerified()){
            return $this->errorResponce('the buyer not buyer virefied  ',409);
        }
        if(! $product->seller->isVerified()){
            return $this->errorResponce('the buyer not seller virefied  ',409);
        }
        if(! $product->isAvailable()){
            return $this->errorResponce('the product in snoy avaliable ',409);
        }
        if($product->quantity < $request->quantity ){
            return $this->errorResponce('the product dosnot have enagh unit for thes transaction ',409);
        }

        return DB::transaction(function()use ($request,$product,$buyer){
            $product->quantity=$request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity'=>$request->quantity,
                'buyer_id'=>$buyer->id,
                'product_id'=>$product->id,
            ]);
            return $this->showOne($transaction,201);
        });
    }
}
