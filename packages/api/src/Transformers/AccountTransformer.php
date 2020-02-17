<?php
namespace GD\Api\Transformers;
use GD\Api\Models\UserDetail;
use League\Fractal;
use Carbon\Carbon;
class AccountTransformer extends Fractal\TransformerAbstract{

	public function transform(UserDetail $detail){
	    return [
	        'id'      			=> (int)    $detail->id,
	        'userID'      		=> (int)    $detail->user_id,
	        'background'    	=> (string) $detail->background,
	        'image'				=> (string) $detail->image,
	        'imageIntro'		=> (string) $detail->image_intro,
	        'flag'		    	=> (string) $detail->flag,
	        'description'		=> (string) $detail->description,
	        'createdAt'			=> Carbon::parse($detail->created_at)->format('Y-m-d'),
	       	'updatedAt'		    => Carbon::parse($detail->updated_at)->format('Y-m-d'),
	    ];
	}
}