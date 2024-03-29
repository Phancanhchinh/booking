<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use App\User;
use App\Permission;
class Role extends EntrustRole
{
    //
    protected $table ="roles";
    public function users(){
    	return $this->belongsToMany('App\User');
    }
    public function teachers(){
    	return $this->belongsToMany('App\User');
    }
    public function permissions(){
    	return $this->belongsToMany('App\Permission');
    }
}
