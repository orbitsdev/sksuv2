<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function search(Request $request){
        $users = User::when($request->input('search'), function($query) use ($request){
            $query->where('first_name', 'like', '%'.$request->input('search').'%');
        })->whereHas('roles', function($query){
            $query->where('name', '!=', 'osas' );
        })->whereDoesntHave('socialAccounts')->get();

        return new UserResource($users);
    }
    public function getUser(){

        $users = User::whereHas('roles', function($query){
            $query->where('name', '!=', 'osas' );
        })->whereDoesntHave('socialAccounts')->get();
        return new UserResource($users);
    }

    public function changePassword(Request $request){
        
        $request->validate([
            'password'=> 'required'
        ]);


        $user = User::where('id', $request->input('id'))->first();
        $user->update([
            'password'=> Hash::make($request->input('password'))
        ]);

        return response()->json(['success']);
    }




}
