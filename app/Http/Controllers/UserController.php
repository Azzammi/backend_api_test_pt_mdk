<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $respon = User::select('name')->get();
        return response()->json($respon,200);
    }
    public function registerUser(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        
        if($validate->fails()){
            $respon = [
                'status' => 'error',
                'msg' => 'Validator error',
                'errors' => $validate->errors(),
                'content' => null,
            ];
            return response()->json($respon,200);
        }else{        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            $respon = [
                'status' => 'success',
                'msg'   => 'User Registered',
                'errors' => null,
                'content' => 'created succesfully'
            ];

            return response()->json($respon,200);
        }
    }
}
