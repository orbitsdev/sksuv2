<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CloudStorageController;
use App\Http\Controllers\Api\FilePondController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\GoogleDriveStorageController;
use App\Http\Controllers\Api\ManageSchoolController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Mail\NewPasswordMailController;
use App\Http\Controllers\RolesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('roles');
});


// AUTH
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// GOOGLE SIGNIN
Route::get('/authorize/{provider}/redirect', [GoogleController::class ,'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class ,'handleProviderCallback']);

// PASSWORD RESET
Route::post('/request-password-reset', [NewPasswordMailController::class, 'sendEmailForPasswordReset']);
Route::post('/set-password', [NewPasswordMailController::class, 'setNewPassword']);
Route::get('/role', function(){
    return redirect()->to('/authorize/google/callback?code=anna');
});

Route::post('file/upload', [FilePondController::class, 'uploadToTemporaryStorage']);
Route::delete('file/delete', [FilePondController::class, 'deleteFromLocalStorage']);
// FILEPOND

// MANAGE SCHOOL
Route::post('schools/search', [ManageSchoolController::class,'search']);
Route::post('schools/delete-all', [ManageSchoolController::class,'deleteAll']);
Route::post('schools/delete-selected', [ManageSchoolController::class,'deleteSelectedSchool']);
Route::apiResource('schools', ManageSchoolController::class);


// ALIBABA
Route::post('cloud/upload', [CloudStorageController::class, 'uploadFile']);
// PUBLIC
Route::get('/roles', [RolesController::class, 'getAllRoles']);


// ALIBABA
Route::get('/oss/token', [CloudStorageController::class ,'getAccessToken']);


// GOOGLE DRIVE
Route::post('google-drive-upload', [GoogleDriveStorageController::class, 'fileUpload']);
Route::post('google-drive-get-files', [GoogleDriveStorageController::class, 'getFiles']);




