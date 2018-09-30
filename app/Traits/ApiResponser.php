<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


trait ApiResponser{

    private  function successResponce($data,$code){
        return response()->json($data,$code);
    }
    
    protected function errorResponce($message,$code){
        return response()->json(['error'=>$message,'code'=>$code]);
    }

    public function showAll(Collection $collection,$code=200){
        return $this->successResponce($collection ,$code);
    }

    public function showOne(Model $model,$code=200){
        return $this->successResponce($model, $code);
    }
} 