<?php

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\CampusDirector;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VpaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\RemarkController;
use App\Http\Controllers\CampusDeanController;
use App\Http\Controllers\Api\MonitorController;
use App\Http\Controllers\Api\OfficerController;
use App\Http\Controllers\EndorseMentController;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\FilePondController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SchoolYearController;
use App\Http\Controllers\CampusDirectorController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CloudStorageController;
use App\Http\Controllers\Api\ManageSchoolController;
use App\Http\Controllers\Api\CampusAdviserController;
use App\Http\Controllers\Api\ManageUserRoleController;
use App\Http\Controllers\Api\ApplicationFormController;
use App\Http\Controllers\Api\DynamicFetchingController;
use App\Http\Controllers\Mail\NewPasswordMailController;
use App\Http\Controllers\Api\CurrentSboAdviserController;
use App\Http\Controllers\Api\FillUpApplicationController;
use App\Http\Controllers\Api\ManageSboAdviserControlller;
use App\Http\Controllers\Api\SboAdviserRequestController;
use App\Http\Controllers\Api\GoogleDriveStorageController;
use App\Http\Controllers\CampusDirectorEndorsementController;

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

// Manage User Account 

Route::get('/get-user-without-google', [AccountController::class, 'getUser']);
Route::post('/search-user-account', [AccountController::class, 'search']);
Route::post('/change-user-password', [AccountController::class, 'changePassword']);


// Route::group(['middleware' => ['auth:sanctum']], function () {
    // FILEPOND
    Route::post('file/upload', [FilePondController::class, 'uploadToTemporaryStorage']);
    Route::delete('file/delete', [FilePondController::class, 'deleteFromLocalStorage']);

    // FILE CONTROLLER 
    Route::post('files/delete-temporary-files', [FileController::class, 'deleteTemporaryFiles']);

    //manage School Year


    Route::get('school-year', [SchoolYearController::class, 'getAllSchoolYear']);
    Route::get('school-year-with-schools', [SchoolYearController::class, 'getAllSchoolYearWithSchools']);
    Route::post('school-year/create', [SchoolYearController::class, 'createSchoolYear']);
    Route::post('school-year/update', [SchoolYearController::class, 'updateSchoolYear']);
    Route::post('school-year/delete-selected-school-year', [SchoolYearController::class, 'deleteSelectedSchoolYear']);

    // MANAGE SCHOOL
    Route::post('schools/search', [ManageSchoolController::class, 'search']);
    Route::post('schools/delete-all', [ManageSchoolController::class, 'deleteAll']);
    Route::post('schools/delete-selected', [ManageSchoolController::class, 'deleteSelectedSchool']);
    Route::post('schools/attach-to-user', [ManageSchoolController::class, 'attachSchoolToUser']);
    Route::apiResource('schools', ManageSchoolController::class);
    
    //Manage Campus Adviser 
    Route::get('campus-available-users', [CampusAdviserController::class, 'getAvailableUser']);

    Route::get('campus/campus-advisers', [CampusAdviserController::class, 'getAllCampusAdvisers']);
    Route::post('campus/delete-selected', [CampusAdviserController::class, 'deleteSelectedCampusAdviser']);
    Route::post('campus/campus-adviser', [CampusAdviserController::class, 'addCampusAdviser']);
    Route::post('campus/campus-adviser/update', [CampusAdviserController::class, 'updateCampusAdviser']);
    Route::post('campus/campus-adviser/search', [CampusAdviserController::class, 'search']);
    
    // Manage VPA
    Route::get('available-users', [VpaController::class, 'getUsers']);
    Route::get('vpa', [VpaController::class, 'getVpa']);
    Route::post('vpa/search', [VpaController::class, 'search']);
    Route::post('vpa/create', [VpaController::class, 'create']);
    Route::post('vpa/delete-selected', [VpaController::class, 'deleteSelected']);

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
    Route::get('manage-users-roles/get-roles', [ManageUserRoleController::class, 'getRoles']);
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
    Route::get('manage-officer/school-year', [OfficerController::class, 'getAllSchoolYear']);
    Route::post('manage-officer/school-year-school', [OfficerController::class, 'getSchoolYearSchool']);
    Route::post('manage-officer/get-students', [OfficerController::class, 'getStudents']);
    Route::post('manage-officer/get-school-department', [OfficerController::class, 'getSchoolDeparment']);
    Route::post('manage-officer/get-officers', [OfficerController::class, 'getOfficers']);
    Route::post('manage-officer/create-officer', [OfficerController::class, 'createOfficer']);
    Route::post('manage-officer/update-officer', [OfficerController::class, 'updateOfficer']);
    Route::post('manage-officer/delete-selected-officer', [OfficerController::class, 'deleteSelectedOfficer']);
    
    
    //Manage Campus Directors
    Route::get('manage-campus-director/get-all-campus-director', [CampusDirectorController::class, 'getAllCampusDirectors']);
    Route::post('manage-campus-director/create', [CampusDirectorController::class, 'create']);
    Route::post('manage-campus-director/delete-selected', [CampusDirectorController::class, 'deleteSelected']);
    
    //Manage Campus Deans
    Route::get('manage-campus-dean/get-all-campus-dean', [CampusDeanController::class, 'getAllDeans']);
    Route::post('manage-campus-dean/create', [CampusDeanController::class, 'create']);
    Route::post('manage-campus-dean/delete-selected', [CampusDeanController::class, 'deleteSelected']);
    
    // officers documents 
    Route::get('officers/schools', [ApprovalController::class, 'getSchools']);
    Route::post('officers/documents', [ApprovalController::class, 'getAllOfficerApplications']);
    

    //Sbo Endorsement 
    Route::get('get-school-year-with-campus-directors', [EndorseMentController::class, 'getSchoolYearWithCampusDirector']);
    Route::post('endorse-to-campus_director', [EndorseMentController::class, 'endorseResponseToCampusDirector']);
    Route::get('get-endorsed-documents', [EndorseMentController::class, 'getCampusAdviserEdorsement']);
    Route::post('delete-selected-endorsement', [EndorseMentController::class, 'deleteSelectedEndorsement']);
    
    
    // approver sbo endorsement
    Route::post('delete-selected-endorsement', [EndorseMentController::class, 'deleteSelectedEndorsement']);
    Route::get('get-endorsementt-from-campus-adviser', [CampusDirectorEndorsementController::class, 'getendorsementtFromCampusAdviser']);
    Route::post('approve-sbo-adviser-endorsement', [CampusDirectorEndorsementController::class, 'approveform']);
    Route::post('return-sbo-adviser-endorsement', [CampusDirectorEndorsementController::class, 'returnform']);

    //get arppover 
    Route::get('form/approvers', [ApprovalController::class, 'getApproverRoles']);
    Route::post('form/approve', [ApprovalController::class, 'approveForm']);
    Route::post('form/return', [ApprovalController::class, 'returnForm']);
    Route::post('form/remark/update', [RemarkController::class, 'updateSboRemarkInOfficerDocumentResponse']);
    Route::post('form/remark/delete', [RemarkController::class, 'deleteSboRemarkInOfficerDocumentResponse']);
    
        
    // SBO STUDENT 
    
    Route::get('application-form/get-school-year-application', [FillUpApplicationController::class, 'getAllSchoolYear']);
    Route::get('application-form/get-school-of-officer', [FillUpApplicationController::class, 'getAuthenticatedSboSchool']);
    Route::post('application-form/all-application', [FillUpApplicationController::class, 'getApplications']);
    Route::get('application-form/get-application', [FillUpApplicationController::class, 'getApplcation']);
    Route::post('application-form/response/create', [FillUpApplicationController::class, 'createResponse']);
    Route::post('application-form/response/update', [FillUpApplicationController::class, 'updateResponse']);
    
    //monitor response
    Route::get('monitor/school-with-response', [MonitorController::class, 'getAuthenticatedSboSchool']);
    Route::post('monitor/specific-response', [MonitorController::class, 'getSpecificResponse']);
    Route::post('monitor/application-with-response', [MonitorController::class, 'applicationWithResponse']);
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
