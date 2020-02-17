<?php
namespace GD\Api\Transformers;
use GD\Api\Models\Reply;
use League\Fractal;
use Carbon\Carbon;


class ReplyTransformer extends Fractal\TransformerAbstract{

    public function transform(Reply $reply){
        return [
            'id'      			=>  (int)$reply->id,
            'conmentId'      	=>  (int)$reply->comment_id,
            'name'      		=>  $reply->name,
            'content'		    => 	$reply->content,
            'userId'		    => 	$reply->user_id,
            'createdAt'			=>  Carbon::parse($reply->created_at)->format('Y-m-d'),
            'updatedAt'		    =>  Carbon::parse($reply->updated_at)->format('Y-m-d'),
        ];
    }
}

