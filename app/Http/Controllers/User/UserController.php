<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;



class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::all();
        return $this->showAll($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules=[
            'name'=>'required',
            'email'=>'email|required|unique:users',
            'password'=>'required|min:6|confirmed',
        ];

        $this->validate($request,$rules);
        $data=$request->all();
        $data['password']= bcrypt($data['password']);
        $data['verified']= User::UN_VERIFIED;
        $data['verifiecation_code']=User::genrateVerifactionCode();
        $data['admin']= User::REGULER_USER;
        $user =User::create($data);
        return $this->showOne($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::findOrFail($id);
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= User::findOrFail($id);
        
        $rules=[
            'email'=>'email|unique:users,email,',$user->id,
            'password'=>'min:6|confirmed',
            'admin'=>'in:'.User::ADMIN_USER.','.User::REGULER_USER,
        ];
       
        if($request->has('name')){
         $user->name= $request->name ; 
        }
        
        if($request->has('email') && $user->email != $request->email){
            $user->verified=User::UN_VERIFIED;
            $user->validation_code=User::genrateVerifactionCode();
            $user->email= $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')){
            if(! $user->isVerified){
                return $this->errorResponce('only verified users can modified admin fialed ' ,409);
            }
            $user->admin= $request->admin;
        }
       
        if($user->isDirty){
            return $this->errorResponce('you need defirante value to update',422);  
        }
        $user->save();
        return response()->json(['data'=>$user,'code'=>201],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::findOrFail($id);
        $user->delete();
        return $this->showOne($user,201);
    }
}
