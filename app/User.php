<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable ,SoftDeletes;
    const VERIFIED='1';
    const UN_VERIFIED='0';
    const ADMIN_USER ='true';
    const REGULER_USER='false';

    protected $table='users';
    protected $dates=['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
         'remember_token',
         'verification_code',
    ];


    public function isVerified(){
        return $this->verified ==Self::VERIFIED;
    }


    public function isAdmin(){
        return $this->admin ==Self::USER_ADMIN;
    }


    public  static function genrateVerifactionCode(){
        return str_random(40);
    }

    public function setNameAttribute($name){
        return $this->attributes['name']= strtolower($name) ;
    }

    public function getNameAttribute($name){
        return ucwords($name);
    }

    public function setEmailAttribute($email){
        return $this->attributes['email']= strtolower($email) ; 
    }

}
