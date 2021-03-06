<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/getUsers",
     *     tags={"get name"},
     *     summary="Returns API response JSON",
     *     description="An API to get list of name",
     *     operationId="getUsers",
     *     @OA\Response(
     *         response="default",
     *         description="return list of name in json format"
     *     )
     * )
     */
    public function index(){
        $respon = User::select('name')->get();
        return response()->json($respon,200);
    }
    /**
     * @OA\Get(
     *     path="/registerUser",
     *     tags={"register"},
     *     summary="Returns API response message",
     *     description="An API to register new user",
     *     operationId="registerUser",
     *     @OA\Parameter(
     *          name="name",
     *          description="nama pengguna",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="alamat email pengguna",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="password pengguna",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
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
