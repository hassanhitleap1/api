<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const AVAILABLE_PRODUCT='available';
    const UNAVAILABLE_PRODUCT='unavailable';
    protected $fillable=[
        'name',
        'descrionton',
        'quanitty',
        'status',
        'image',
        'seller_id',
    ];


    public function isAvailable(){
        return $this->status == Self::AVILABLE_PRODUCT;
    }
}
