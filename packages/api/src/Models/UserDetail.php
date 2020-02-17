<?php

namespace GD\Api\Models;
use GD\Api\Models\User;
use Illuminate\Database\Eloquent\Model;
class UserDetail extends Model
{
	protected $table = 'user_details';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;
}
