<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class PasswordSecurity extends Model
{
    //
    protected $table = "password_securities";

    protected $guarded = [];
 
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
