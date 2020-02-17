<?php
namespace GD\Api\Transformers;

use GD\Api\Transformers\AccountTransformer;
use GD\Api\Models\User;
use GD\Api\Models\UserDetail;
use GD\Api\Models\Experience;
use League\Fractal;
use Carbon\Carbon;
class UserTransformer extends Fractal\TransformerAbstract{

	public function transform(User $user){
	    return [
	        'id'      			=> (int)    $user->id,
	        'firstName'      	=> (string) $user->first_name,
	        'lastName'      	=> (string) $user->last_name,
	        'email'    			=> (string) $user->email,
	        'dob'      			=> Carbon::parse($user->dob)->format('Y-m-d'),
	        'phone'      		=> (string) $user->phone,
	        'gender'      		=> (int) 	$user->gender,
	        'address'      		=> (string) $user->address,
	        'type'      		=> (int) 	$user->type,
	        'status'			=> (int)    $user->status,
	        'createdAt'		    => Carbon::parse($user->created_at)->format('Y-m-d'),
	        'updatedAt'		    => Carbon::parse($user->updated_at)->format('Y-m-d'),
	    ];
	}
}