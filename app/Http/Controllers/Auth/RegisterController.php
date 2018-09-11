<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required|unique:users,email',
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        if (! $token = auth()->attempt($request->only(['email','password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return (new UserResource($request->user()))
        ->additional([
            'meta' => $this->respondWithToken($token),
        ]); 
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
