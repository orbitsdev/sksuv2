<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\AuthResource;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        // return new AuthResource($request->all());
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);


        $user =   User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        
        if ($request->role != null) {
            $role = Role::where('name', $request->role)->pluck('id')->first();
            $user->roles()->attach($role);
        }

        // $role = Role::where('name', 'guest')->pluck('id')->first();
        // $user->roles()->attach($role);
        
        $token = $user->createToken('chrome')->plainTextToken;
        return new AuthResource(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->with('roles')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;
        return new AuthResource(['user' => $user, 'token' => $token]);
    }


    public function logout(Request $request)
    {



        $accessToken = $request->bearerToken();
        if ($accessToken) {

            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            $request->user()->tokens()->delete();
        }
        // Revoke token
        return new AuthResource(['success']);
    }
}
