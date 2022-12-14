<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SboAdviserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\SboRequestResource;

class SboAdviserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function confirmSelectedSbo(Request $request){
        
    
        $users =  User::whereHas('roles', function($query){
            $query->where('name' ,'!=' ,'sbo-adviser');
        })->whereHas('sboRequest')->whereIn('id', $request->input('userid'))->get();

        $sboadviserrole  = Role::where('name', 'sbo-adviser')->pluck('id')->first();


        foreach($users as $user){
            $user->roles()->sync([$sboadviserrole]);
            $user->sboRequest()->delete();
        }


        return response()->json(['success', $user->roles], 200);
     }

     public function confirm(Request $request){
       
        $user = User::whereHas('sboRequest')->where('id', $request->input('id'))->first();

        $sboadviserrole  = Role::where('name', 'sbo-adviser')->pluck('id')->first();
        $user->roles()->sync([$sboadviserrole]);
        $user->sboRequest()->delete();
    
        return response()->json(['success', $user->roles], 200);
    }


    public function filter(Request $request){
        
        if($request->input('filter') == 'none'){
            return $this->index();
        }else{
            $users =   User::whereHas('schools', function($query) use ($request){
                $query->where('name', $request->input('filter'));
            })->whereHas('roles',function($query){
                $query->where('name', '!=', 'sbo-adviser');
              })->whereHas('sboRequest')->with('sboRequest','schools')->paginate(10);
    
    
            return new SboRequestResource($users);
        }

     
    }   


     public function search(Request $request)
     {
        $users= User::when($request->input('filter') != 'none', function($query) use ($request){
            $query->whereHas('schools', function($query) use ($request){
                    $query->where('name', $request->input('filter'));
            });
        })->whereHas('sboRequest')->where(function($query) use ($request){
        $query->where('email', 'like','%'.$request->input('search').'%')->orWhere('first_name', 'like','%'.$request->input('search').'%')->orWhere('last_name', 'like','%'.$request->input('search').'%'); })->with('sboRequest','schools')->get();
        return new SboRequestResource($users);
     }
     public function getRequest(){
        return response()->json([auth('sanctum')->user()->sboRequest]);
     }
     public function requestSboAdviserRole(Request $request){
        auth('sanctum')->user()->sboRequest()->updateOrCreate(['status'=> 'pending']);
        
        return response()->json(['success'], 200);
     }
    public function index()
    {

      $users =   User::whereHas('roles',function($query){
        $query->where('name', '!=', 'sbo-adviser');
      })->whereHas('sboRequest')->with('sboRequest','schools')->paginate(10);
        return new SboRequestResource($users);
            
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
