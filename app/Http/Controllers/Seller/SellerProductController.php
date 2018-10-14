<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Product;
use App\User;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products =$seller->products;
        return $this->showAll($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $seller)
    {
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|integer|main:1',
            'image'=>'required|image',
        ];
        
        $this->validate($request ,$rules);
        $data=  $request->all();
        $data['status']=Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.png';
        $data['seller_id'] =$seller->id;
        $product=Product::create($data);
        
        return $this->showOne($product);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,Product $product)
    {
        $rules=[
            'quantity'=>'integer|min:1',
            'status'=>'in'.Product::AVAILABLE_PRODUCT.','.Product::AVAILABLE_PRODUCT,
            'iamge'=>'image',
        ];

        $this->validate();
        $this->checkSeller($seller,$product);
        $this->fill($request->intersect([
            'name',
            'description',
            'quantity',
         ]));

         if($request->has('status')){
             $product->status =$request->status;
            if($product->isAvailable() && $product->categories()->count() ==0){
                return $this->errorResponce('an active this product must be have lest one categories',409);  
            }
         } 
         if($product->isClean()){
            return $this->errorResponce('deffrat value is update ',422);  
        }
        $product->save();
        $this->showOne($product);
    }  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }

    protected function checkSeller(Seller $seller, Product $product){

        if($seller->id != $product->seller_id){
            throw new HttpExaption(404,'the spacefiy actual in snotsller or prohct');
        }
    }
}
