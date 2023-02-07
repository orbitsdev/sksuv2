<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResources;
use App\Http\Resources\UserResource;

class ManageUserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getRoles(){
            $roles = Role::whereNotIn('name', ['sbo-student'])->get();

            return new RolesResources($roles);
    }

    public function changeUserRole(Request $request)
    {
        $user = User::where('id', $request->input('id'))->first();
        $roles = Role::whereIn('id', $request->input('usersid'))->pluck('id')->get();
        $user->roles()->sync($roles);
        return response()->json(['success'], 200);
    }

    public function changeSelectedUsersRoles(Request $request)
    {


        $users = User::whereIn('id', $request->input('usersid'))->get();
        $role = Role::where('id', $request->input('role'))->first();
        foreach ($users as $user) {
            $user->roles()->sync($role->id);
        }
        return response()->json(['success'], 200);
    }

    public function filter(Request $request)
    {

        if ($request->input('filter') == 'none') {
            return $this->getUsers();
        } else {
            $users = User::where('id', '!=', auth('sanctum')->user()->id)->whereHas('schools', function ($query) use ($request) {
                $query->where('name', $request->input('filter'));
            })->with('schools', 'roles')->paginate(10);
            return new UserResource($users);
        }
    }
    public function search(Request $request)
    {
       
       $users = User::where('id', '!=' ,auth('sanctum')->user()->id)->when($request->input('search'), function($query) use ($request){
        $query->where(function($query) use ($request){
            $query->where('first_name', 'like', $request->input('search'))->orWhere('last_name', 'like', '%'.$request->input('search').'%');
           });
       })->with('roles','schools')->get();

        return new UserResource($users);
    }

    public function getUsers()
    {
        $users = User::where(function ($query) {
            $query->where('id', '!=', auth('sanctum')->user()->id);
        })->with('schools', 'roles')->paginate(10);

        return new UserResource($users);
    }


    public function index()
    {
        return new RolesResources(Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
