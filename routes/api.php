<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\FilePondController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\CloudStorageController;
use App\Http\Controllers\Api\CurrentSboAdviserController;
use App\Http\Controllers\Api\ManageSchoolController;
use App\Http\Controllers\Mail\NewPasswordMailController;
use App\Http\Controllers\Api\GoogleDriveStorageController;
use App\Http\Controllers\Api\ManageSboAdviserControlller;
use App\Http\Controllers\Api\ManageUserRoleController;
use App\Http\Controllers\Api\SboAdviserRequestController;

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
    return $request->user()->load('roles', 'schools','sboRequest');
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
Route::get('/role', function(){ return redirect()->to('/authorize/google/callback?code=anna');
});



// FILEPOND
Route::post('file/upload', [FilePondController::class, 'uploadToTemporaryStorage']);
Route::delete('file/delete', [FilePondController::class, 'deleteFromLocalStorage']);

// FILE CONTROLLER 
Route::post('files/delete-temporary-files', [FileController::class, 'deleteTemporaryFiles']);


// MANAGE SCHOOL

Route::post('schools/search', [ManageSchoolController::class,'search']);
Route::post('schools/delete-all', [ManageSchoolController::class,'deleteAll']);
Route::post('schools/delete-selected', [ManageSchoolController::class,'deleteSelectedSchool']);
Route::post('schools/attach-to-user', [ManageSchoolController::class,'attachSchoolToUser']);
Route::apiResource('schools', ManageSchoolController::class);

// MANAGE SBO ADVISERS
Route::post('sbo-advisers/search', [ManageSboAdviserControlller::class,'search']);
Route::post('sbo-advisers/filter', [ManageSboAdviserControlller::class,'filter']);
Route::post('sbo-advisers/make-user-as-adviser', [ManageSboAdviserControlller::class,'makeUsersAsAdviser']);
Route::apiResource('sbo-advisers', ManageSboAdviserControlller::class);

// SBO ROLE REQUEST
Route::post('sbo-requests/confirm-selected-request', [SboAdviserRequestController::class, 'confirmSelectedSbo']);
Route::post('sbo-requests/confirm', [SboAdviserRequestController::class, 'confirm']);
Route::post('sbo-requests/request-role-as-sbo-adviser', [SboAdviserRequestController::class, 'requestSboAdviserRole']);
Route::post('sbo-requests/filter', [SboAdviserRequestController::class,'filter']);
Route::post('sbo-requests/search', [SboAdviserRequestController::class, 'search']);
Route::get('sbo-requests/get-sbo-request', [SboAdviserRequestController::class, 'getRequest']);
Route::apiResource('sbo-requests', SboAdviserRequestController::class);


//  MANAGE CURRENT SBO ADVISERS
Route::get('current-sbo-advisers', [CurrentSboAdviserController::class, 'getCurrentSboAdvisers']);
Route::post('current-sbo-advisers/search', [CurrentSboAdviserController::class, 'search']);
Route::post('current-sbo-advisers/filter', [CurrentSboAdviserController::class, 'filter']);
Route::post('current-sbo-advisers/remove-sbo-adviser-role-to-user', [CurrentSboAdviserController::class, 'removeAdviserRoleToUser']);
Route::post('current-sbo-advisers/remove-sbo-adviser-role-to-the-selected-user', [CurrentSboAdviserController::class, 'removeAdviserRoleToTheSelectedUser']);


// MANAGE ROLES
Route::apiResource('roles', ManageUserRoleController::class);

// ALIBABA
Route::post('cloud/upload', [CloudStorageController::class, 'uploadFile']);
// PUBLIC


// ALIBABA
Route::get('/oss/token', [CloudStorageController::class ,'getAccessToken']);


// GOOGLE DRIVE
Route::post('google-drive-upload', [GoogleDriveStorageController::class, 'fileUpload']);
Route::post('google-drive-get-files', [GoogleDriveStorageController::class, 'getFiles']);




