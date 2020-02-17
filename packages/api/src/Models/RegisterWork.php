<?php

namespace GD\Api\Models;
use Illuminate\Database\Eloquent\Model;
class RegisterWork extends Model
{
	protected $table = 'register_works';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;
}
