<?php 

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Model;



class BuyerScope implements Scope {

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model){
       $builder->with('transactions');
    }

  
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function remove(Builder $builder, Model $model){} 


    
}
?>