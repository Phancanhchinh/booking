<?php
namespace GD\Api\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GD\Api\Models\Reply;
use Carbon\Carbon;
use DB;

class Comment extends Authenticatable
{
    use Notifiable;

    protected $table = 'comments';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;

    public function replies(){
    	return $this->hasMany(Reply::class,'id','comment_id');
    }
}
