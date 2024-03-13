<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    Public function showRegisterPage(){
        return view('Register');
    }

    public function showLoginPage(){
        return view('login');
    }
    public function createUser(Request $request){
        try{

            $validateUser = validator()->make($request->all(),
            [
                'name'=>'required',
                'email'=>'required',
                'password'=>'required'
            ]);
            if($validateUser->fails()){
                return back()->withErrors($validateUser)->withInput();
            }
    
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
    
            return redirect()->route('home')->with('success','user created successfully');
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
                return back()->withErrors($validate)->withInput();
            }

            if(!Auth::attempt($request->only(['email','password']))){
               return back()->with('error','credentials do not match ');
            }

            $user = User::where('email',$request->email)->first();

            return [
                'status' => 'success',
                'message' => 'successfully loggedin ',
                'redirect' => route('home')
            ];
        }
        catch(\Exception $e){
            return [
                'status' => 'false',
                'message' => $e->getMessage(),
            ]; 
        }
    }
}
