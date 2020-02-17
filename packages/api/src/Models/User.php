<?php
namespace GD\Api\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    Const Admin = 0;
    Const Employer = 1;
    Const Customer = 2;
    protected $fillable = [
        'first_name','last_name','username', 'email', 'password','dob','gender','address','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activeAccount($token){
        $password_resets = DB::table('password_resets')->insert([
            'email'      => $this->email,
            'token'      => $token,
            'created_at' => Carbon::now()->format('Y-m-d h:i:s')
        ]);
        return $password_resets;
    }

    public function getFullName(){
        return $this->first_name.' '.$this->last_name;
    }
}
