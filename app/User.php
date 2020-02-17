<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Passport\HasApiTokens;
use App\Role;
use App\PasswordSecurity;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="User"))
 */
class User extends Authenticatable
{
    use Notifiable,EntrustUserTrait,HasApiTokens;
    
    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'google2fa_secret',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token' ,'google2fa_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles(){
       return $this->belongsToMany('App\Role');
    }
    public function getAll(){
        return static::all();
    }
    public function findUser($id){
        return static::find($id);
    }
    public function deleteUser($id){
        return static::find($id)->delete();
    }

    public function passwordSecurity(){
        return $this->hasOne(PasswordSecurity::class,'user_id','id');
    }

    public function sendPasswordResetNotification($token){
       $this->notify(new PasswordResetNotification($token));
    }

    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }
}
