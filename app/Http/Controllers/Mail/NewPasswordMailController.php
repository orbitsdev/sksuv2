<?php

namespace App\Http\Controllers\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use GrahamCampbell\ResultType\Success;
use Illuminate\Validation\ValidationException;
use App\Mail\ResetPassword as MailResetPassword;

class NewPasswordMailController extends Controller
{

    public function sendEmailForPasswordReset(Request $request)
    {

        $request->validate([
            'email' => ['required:email']
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user != null) {

            if (count($user->socialAccounts) <= 0) {
                $token = $user->createToken($user->first_name)->plainTextToken;
                $domain = URL::to('/');
                $set_new_password_url =  $domain . "/set-new-password?email=" . $user->email . "&token=" . $token;


                if (!$userPasswordRequest = ResetPassword::where('email', $user->email)->first()) {
                    ResetPassword::create([
                        'email' => $user->email,
                        'token' => $token,
                    ]);
                } else {
                    $userPasswordRequest->update([
                        'email' => $user->email,
                        'token' => $token,
                    ]);
                }


                Mail::to($user->email, $user->first_name)->queue(new MailResetPassword($user, $token, $set_new_password_url,));
                return response()->json([$user->email]);
            } else {
                return response()->json(['You cannot change Google Account Type in this application'], 401);
            }
        } else {
            return response()->json([$request->email.' is not registered in this application'], 404);
        }
    }



    public function setNewPassword(Request $request)
    {



        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $password_reset  = ResetPassword::where('email', $request->email)->first();
        if ($request->email == $request->actual_email) {
            if ($password_reset != null) {



                if ($password_reset->token != $request->token) {
                    return response()->json([$request->email . ' Mismatch Token '], 400);
                } else {

                    $account =  User::where('email', $request->email)->first();
                    if (count($account->socialAccounts) <= 0) {

                        $account->update([
                            'password' => Hash::make($request->password),
                        ]);

                        return response()->json('Password Succesfully update');
                    } else {

                        return response()->json([$request->email . ' is registered as Google Account  you cannot change the password of this email  in this application'], 404);
                    }
                }
            } else {
                return response()->json([$request->email . 'Did not send reset password request'], 404);
            }
        } else {
            return response()->json([' Do not  change the actual email '], 404);
        }
    }
}
