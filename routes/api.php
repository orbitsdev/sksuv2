<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\MonitorController;
use App\Http\Controllers\Api\OfficerController;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\FilePondController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CloudStorageController;
use App\Http\Controllers\Api\ManageSchoolController;
use App\Http\Controllers\Api\ManageUserRoleController;
use App\Http\Controllers\Api\ApplicationFormController;
use App\Http\Controllers\Api\DynamicFetchingController;
use App\Http\Controllers\Mail\NewPasswordMailController;
use App\Http\Controllers\Api\CurrentSboAdviserController;
use App\Http\Controllers\Api\FillUpApplicationController;
use App\Http\Controllers\Api\ManageSboAdviserControlller;
use App\Http\Controllers\Api\SboAdviserRequestController;
use App\Http\Controllers\Api\GoogleDriveStorageController;

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
    return $request->user()->load('roles', 'schools');
});


// AUTH
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// GOOGLE SIGNIN
Route::get('/authorize/{provider}/redirect', [GoogleController::class, 'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class, 'handleProviderCallback']);

// PASSWORD RESET
Route::post('/request-password-reset', [NewPasswordMailController::class, 'sendEmailForPasswordReset']);
Route::post('/set-password', [NewPasswordMailController::class, 'setNewPassword']);
Route::get('/role', function () {
    return redirect()->to('/authorize/google/callback?code=anna');
});


// Route::group(['middleware' => ['auth:sanctum']], function () {
    // FILEPOND
    Route::post('file/upload', [FilePondController::class, 'uploadToTemporaryStorage']);
    Route::delete('file/delete', [FilePondController::class, 'deleteFromLocalStorage']);

    // FILE CONTROLLER 
    Route::post('files/delete-temporary-files', [FileController::class, 'deleteTemporaryFiles']);

    // MANAGE SCHOOL
    Route::post('schools/search', [ManageSchoolController::class, 'search']);
    Route::post('schools/delete-all', [ManageSchoolController::class, 'deleteAll']);
    Route::post('schools/delete-selected', [ManageSchoolController::class, 'deleteSelectedSchool']);
    Route::post('schools/attach-to-user', [ManageSchoolController::class, 'attachSchoolToUser']);
    Route::apiResource('schools', ManageSchoolController::class);

    // MANAGE SBO ADVISERS
    Route::post('sbo-advisers/search', [ManageSboAdviserControlller::class, 'search']);
    Route::post('sbo-advisers/filter', [ManageSboAdviserControlller::class, 'filter']);
    Route::post('sbo-advisers/make-user-as-adviser', [ManageSboAdviserControlller::class, 'makeUsersAsAdviser']);
    Route::apiResource('sbo-advisers', ManageSboAdviserControlller::class);

    // SBO ROLE REQUEST
    Route::post('sbo-requests/confirm-selected-request', [SboAdviserRequestController::class, 'confirmSelectedSbo']);
    Route::post('sbo-requests/confirm', [SboAdviserRequestController::class, 'confirm']);
    Route::post('sbo-requests/request-role-as-sbo-adviser', [SboAdviserRequestController::class, 'requestSboAdviserRole']);
    Route::post('sbo-requests/filter', [SboAdviserRequestController::class, 'filter']);
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
    Route::get('manage-users-roles/get-users', [ManageUserRoleController::class, 'getUsers']);
    Route::post('manage-users-roles/change-role-selected-user', [ManageUserRoleController::class, 'changeSelectedUsersRoles']);
    Route::post('manage-users-roles/filter', [ManageUserRoleController::class, 'filter']);
    Route::post('manage-users-roles/search', [ManageUserRoleController::class, 'search']);
    Route::apiResource('roles', ManageUserRoleController::class);

    // MANAGE DEPARTMENT/ORGANIZATION
    Route::get('manage-department', [DepartmentController::class, 'getDepartment']);
    Route::post('manage-department-search', [DepartmentController::class, 'search']);
    Route::post('manage-department-create', [DepartmentController::class, 'createDepartment']);
    Route::post('manage-department-update', [DepartmentController::class, 'updateDepartment']);
    Route::post('manage-department-delete-selected', [DepartmentController::class, 'deleteSelectedDepartment']);
    Route::post('manage-department-delete-all', [DepartmentController::class, 'deleteAllDepartment']);

    // MANAGE APPLICATION FORM
    Route::get('manage-applications', [ApplicationFormController::class, 'getApplicationForms']);
    Route::get('manage-applications/{id}', [ApplicationFormController::class, 'getSingleApplication']);
    Route::post('manage-applications/create', [ApplicationFormController::class, 'createApplicationForm']);
    Route::post('manage-applications/update', [ApplicationFormController::class, 'updateApplicationForm']);
    Route::post('manage-applications/search', [ApplicationFormController::class, 'search']);
    Route::post('manage-applications/make-application-public', [ApplicationFormController::class, 'makeApplicationPublic']);
    Route::post('manage-applications/delete-selected', [ApplicationFormController::class, 'deleteSelectedApplicationForm']);


    //Forms
    Route::get('application-fields-for-select/fetch', [DynamicFetchingController::class, 'datatoFetch']);

    // APPLICATION REQUIREMENT
    Route::get('manage-requirement', [RequirementController::class, 'getRequirement']);
    Route::post('manage-requirement/create', [RequirementController::class, 'createRequirement']);
    Route::post('manage-requirement/update', [RequirementController::class, 'updateRequirement']);
    Route::post('manage-requirement/search', [RequirementController::class, 'search']);
    Route::post('manage-requirement/delete-selected', [RequirementController::class, 'deleteSelectedRequirement']);
    
    
    // Manage Sbo Officer 
    Route::get('manage-officer/get-students', [OfficerController::class, 'getStudents']);
    Route::get('manage-officer/get-school-department', [OfficerController::class, 'getSchoolDepartmentphp']);
    Route::get('manage-officer/get-officers', [OfficerController::class, 'getOfficers']);
    Route::post('manage-officer/create-officer', [OfficerController::class, 'createOfficer']);
    Route::post('manage-officer/update-officer', [OfficerController::class, 'updateOfficer']);
    Route::post('manage-officer/delete-selected-officer', [OfficerController::class, 'deleteSelectedOfficer']);
    
    
    // officers documents 
    Route::get('officers/documents', [ApprovalController::class, 'getAllOfficerApplications']);
    
    //get arppover 
    Route::get('form/approvers', [ApprovalController::class, 'getApproverRoles']);
    Route::post('form/approve', [ApprovalController::class, 'approveForm']);



    
    
    // SBO STUDENT 
    
    Route::get('application-form/all-application', [FillUpApplicationController::class, 'getApplications']);
    Route::get('application-form/get-application', [FillUpApplicationController::class, 'getApplcation']);
    Route::post('application-form/response/create', [FillUpApplicationController::class, 'createResponse']);
    Route::post('application-form/response/update', [FillUpApplicationController::class, 'updateResponse']);
    
    //monitor response
    Route::get('monitor/response', [MonitorController::class, 'getAllResponse']);
    Route::post('monitor/response', [MonitorController::class, 'applicationWithResponse']);
    Route::post('monitor/search', [MonitorController::class, 'search']);
    Route::post('monitor-form/searby/date', [MonitorController::class, 'searchByDate']);
    Route::post('monitor-form/searby/delete', [MonitorController::class, 'deleteSpicificResponse']);
    
    // ALIBABA
    Route::post('cloud/upload', [CloudStorageController::class, 'uploadFile']);
    Route::get('/oss/token', [CloudStorageController::class, 'getAccessToken']);

    // GOOGLE DRIVE
    Route::post('google-drive-upload', [GoogleDriveStorageController::class, 'fileUpload']);
    Route::post('google-drive-get-files', [GoogleDriveStorageController::class, 'getFiles']);
// });
