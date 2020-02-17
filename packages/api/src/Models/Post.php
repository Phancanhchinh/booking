<?php
namespace GD\Api\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;

class Post extends Authenticatable
{
    use Notifiable;

    protected $table = 'posts';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;
}
