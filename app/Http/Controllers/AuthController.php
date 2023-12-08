<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->model = new User();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        try{

            if(!Auth::Attempt($credentials)){
                return response(['message' => "Account is not registered"], 200);
            };

            $token = $user->createToken($request->email . Str::random(8))->plainTextToken;

            return response($token, 200);

        }catch(\Exception $e){
            return response(['messsage' => $e->getMessag()], 400);
        };
    }

    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        try{
            $request['role'] = '1';
            if(!$this->model->create($request->all())){
                return response(['message' => "Data not inserted"], 200); 
            }

            return response(['message' => "Registered Successfully!"], 201); 

        }catch(\Exception $e){
            return response(['messsage' => $e->getMessage()], 400);
        };
    }
}
