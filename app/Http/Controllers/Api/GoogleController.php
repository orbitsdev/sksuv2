<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\Api\GoogleResource;

class GoogleController extends Controller
{

    public function redirectToProvider($provider)
    {



     $url =   Socialite::driver($provider)->stateless()->redirect();
        // return response()->json(["url"=> $url]);
        return new GoogleResource(['url' => $url]);
    }


    public function handleProviderCallback($provider)
    {

        $user =  Socialite::driver($provider)->stateless()->user();

        if (!$user->token) {
            return response()->json(['msg', 'failed'], 400);
        }
        $user_account =   User::where('email', $user->email)->first();

        if (!$user_account) {
            $user_account = User::create([
                'first_name' => $user->user["given_name"],
                'last_name' => $user->user["family_name"],
                'email' => $user->email,
                'password' => Hash::make($provider . $user->emal . $user->name), // provider plus + email + complet
            ]);

            SocialAccount::create([
                'user_id'=> $user_account->id,
                'provider_user_id'=>$user->id,
                'provider'=> $provider
            ]);

            if($guest= Role::where('name', 'guest')->pluck('id')->first()){
                $user_account->roles()->sync($guest);
            }
        }else{

            if(count($user_account->socialAccounts) < 0){
               $account =  SocialAccount::create([
                    'user_id'=> $user_account->id,
                    'provider_user_id'=>$user->id,
                    'provider'=> $provider
                ]);
            }

        }
        
        $token = $user_account->createToken('browser')->plainTextToken;
    
        return redirect()->to('/authorize/google/callback?code='.$token);
    }
}
