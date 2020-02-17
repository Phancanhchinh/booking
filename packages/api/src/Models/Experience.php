<?php

namespace GD\Api\Models;
use Illuminate\Database\Eloquent\Model;
class Experience extends Model
{
	protected $table = 'experiences';

	protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;
}
