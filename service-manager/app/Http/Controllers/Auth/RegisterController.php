<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:8'
        ]);

        try {

            $request['password'] = bcrypt($request->password);
            $user = User::create( $request->only('name', 'email', 'password') );

            return new UserResource( $user );

        }catch (\Exception $exception){

            return response()->json([ 'message' => $exception->getMessage() ], 500);

        }
    }
}
