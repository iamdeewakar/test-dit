<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function createUser(Request $request){
        try{

            $validateUser = validator()->make($request->all(),
            [
                'name'=>'required',
                'email'=>'required',
                'password'=>'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'validation failed',
                    'error'=>'validateUser->errors()'
                ],401);
            }
    
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
    
            return response()->json([
                'status'=>true,
                'message'=>'created successfully',
                'token'=>$user->createToken('API Token')->plainTextToken,
            ],200);


        }
        catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'error'=>$e->getMessage(),
            ],500);
        }
       
    }


    public function login(Request $request){
        try{
            $validate = validator()->make($request->all(),[
                'email'=>'required',
                'password'=>'required',
            ]);
            if($validate->fails()){
                return response()->json([
                    'message'=>'validation fails',
                    'error'=>$validate->errors(),
                ],401);
            }

            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status'=>false,
                    'message'=>'email or password do not match',
                ],401);
            }

            $user = User::where('email',$request->email)->first();
            return response()->json([
                'status'=>true,
                'message'=>'login successfull'
            ],200);
        }
        catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'error'=>$e->getMessage(),
            ],500);
        }
    }
}
