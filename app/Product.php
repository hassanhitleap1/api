<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Transaction;
use App\Seller;
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

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }


    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
