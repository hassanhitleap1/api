<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const VERIFIED='1';
    const UN_VERIFIED='0';
    const USER_ADMIN='true';
    const REGULER_USER='false';

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


    public function genrateVerifactionCode(){
        return random_str(40);
    }
}
