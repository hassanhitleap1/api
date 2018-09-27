<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable=[
        'quanitty',
        'buyer_id',
        'product_id',
    ];
}
