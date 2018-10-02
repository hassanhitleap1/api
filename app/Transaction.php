<?php

namespace App;
use App\Product;
use App\Buyer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'quantity',
        'buyer_id',
        'product_id',
    ];
    protected $dates=['deleted_at'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }
}
