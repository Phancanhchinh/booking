<?php
namespace GD\Api\Transformers;
use GD\Api\Models\Follow;
use League\Fractal;
use Carbon\Carbon;
class FollowTransformer extends Fractal\TransformerAbstract{
	public function transform(Follow $follow){
	    return [
	        'id'      			=> (int)    $follow->id,
	        'userID'      		=> (int)    $follow->user_id,
	        'followUser'		=> (int) 	$follow->follow_user,
	        'status'			=> (int) 	$follow->status,
	        'createdAt'			=> Carbon::parse($follow->created_at)->format('Y-m-d'),
	       	'updatedAt'		    => Carbon::parse($follow->updated_at)->format('Y-m-d'),
	    ];
	}
}