<?php



namespace App\Traits;

use App\Models\Role;
use App\Models\SocialAccount;
use App\Traits;


trait UserRelations {

    
    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

}

