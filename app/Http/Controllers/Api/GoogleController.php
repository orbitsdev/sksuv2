<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialAccount;
use App\Http\Resources\Api\GoogleResource;

class GoogleController extends Controller
{

    public function redirectToProvider($provider)
    {

        $url =   Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        // return response()->json(["url"=> $url]);
        return new GoogleResource(['url'=> $url]);
         
    }


    public function handleProviderCallback($provider)
    {

        $user =  Socialite::driver($provider)->stateless()->user();
     
        
    // Return error
        if (!$user->token) {
            return response()->json(['msg', 'failed'], 400);
        }

    //  Get user account from the actual web application 
        $user_account =   User::where('email', $user->email)->first();
     

    //  User not exist
        if (!$user_account) {
    // create user account        
           $user_account =  User::create([
                'first_name' => $user->user["given_name"],
                'last_name' => $user->user["family_name"],
                'email' => $user->email,
                'password' => Hash::make($provider . $user->emal . $user->name), // provider plus + email + complete name
            ]); 

    // create social account
          SocialAccount::create([
                'user_id'=> $user_account->id,
                'provider_user_id'=>$user->id,
                'provider'=> $provider
            ]);

        // asign deault roles

        $osas = Role::where('name', 'developer')->pluck('id')->first();
        if($osas){
            
                    $user_account->roles()->attach($osas);

        }
        

        } else {
    // Get user social account 
            $user_social_account = $user_account->socialAccounts()->where('provider', $provider)->first();
            
     // If not exist
            if (!$user_social_account) {
    // Create social account
       $social_account = SocialAccount::create([
                    'user_id'=> $user_account->id,
                    'provider_user_id'=>$user->id,
                    'provider'=> $provider
                ]);
            }
            
            
        }
        
        // you can also return set details

        // return token

        
        $token = $user_account->createToken('browser')->plainTextToken;
   

    //    return response()->json($user_account, 200, ['Access-Token' => $token]);
    // return view('callback', compact('token'));
        // return redirect('/authorize/google/callback', ['token'=>$token]);

        return redirect()->to('/authorize/google/callback?code='.$token);


    }
    
}
