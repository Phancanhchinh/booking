<?php
namespace GD\Api\Transformers;
use GD\Api\Models\Experience;
use League\Fractal;
use Carbon\Carbon;
class ExperienceTransformer extends Fractal\TransformerAbstract{
	public function transform(Experience $exper){
	    return [
	        'id'      		=> (int)  $exper->id,
	        'userID'      	=> (int)  $exper->user_id,
	        'title'			=> (string) $exper->title,
	        'postTime'		=> Carbon::parse($exper->post_time)->format('Y-m-d'),
	        'description'   => (string) $exper->description,
 	        'createdAt'		=> Carbon::parse($exper->created_at)->format('Y-m-d'),
	       	'updatedAt'		=> Carbon::parse($exper->updated_at)->format('Y-m-d'),
	    ];
	}
}