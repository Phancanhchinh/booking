<?php
namespace GD\Api\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GD\Api\Models\Comment;
use Carbon\Carbon;
use DB;

class Reply extends Authenticatable
{
    use Notifiable;

    protected $table = 'replies';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;

    public function comments(){
        return $this->belongsTo(Comment::class, 'id', 'comment_id');
    }
}
