<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SboAdviserResource;

class ManageSboAdviserControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function makeUsersAsAdviser(Request $request){
        $sboadviserrole =  Role::where('name', 'sbo-adviser')->pluck('id')->first();
        
        $users  = User::whereIn('id', $request->input('usersid'))->get();
        if(count($users) > 0){
            foreach($users as $user){
                $user->roles()->sync([$sboadviserrole]);
            }

            
        }
        
        return new SboAdviserResource([$users]);
         
    }
     
     public function search(Request $request)
     {
            // return response()->json($request->input('search'));  
                  
        $users =  User::when($request->input('filter', function($query) use ($request){
            $query->where('name', $request->input('filter'));
        }))->whereHas('roles',function($query){

            $query->where('name' , '!=', 'sbo-adviser');

        })->whereHas('schools')->where(function($query) use ($request){
            $query->where('email', 'like','%'.$request->input('search').'%')->orWhere('first_name', 'like','%'.$request->input('search').'%')->orWhere('last_name', 'like','%'.$request->input('search').'%'); })->with('schools')->get();
        // $schools  = School::where('name', 'like', '%' . $request->input('search') . '%')->with('files')->get();
        return new SboAdviserResource($users);
   
     }
     
     public function filter(Request $request){
 
        $users = User::whereHas('roles', function($query){
            $query->where('name', '!=' ,'sbo-adviser');
        })->whereHas('schools', function($query) use ($request) {
                $query->where('name', $request->input('filter'));
        })->with('schools')->get();
        
    return new SboAdviserResource($users);
        
     }
    
    public function index()
    {    
    $sboadvisers = User::whereHas('roles', function($query){
       $query->where('name', '!=',  'sbo-adviser'); 
    })->whereHas('schools')->with('schools', 'roles')->get();
        // $sboadvisers = User::whereHas('schools')->with('schools')->paginate(10);

        return new SboAdviserResource($sboadvisers);
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
