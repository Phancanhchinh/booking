<?php

namespace GD\Api\Models;
use GD\Api\Models\User;
use Illuminate\Database\Eloquent\Model;
class UserToken extends Model
{
	protected $table = 'user_tokens';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;

    public function user(){
    	return $this->belongsTo(User::class ,'user_id' ,'id');
    }

    public static function findByToken($token){

       return self::where(['access_token' => $token])->first();
       
    }
}
