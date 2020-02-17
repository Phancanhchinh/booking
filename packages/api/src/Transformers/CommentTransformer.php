<?php
namespace GD\Api\Transformers;
use GD\Api\Models\Comment;
use League\Fractal;
use Carbon\Carbon;


class CommentTransformer extends Fractal\TransformerAbstract{

    public function transform(Comment $comment){
        return [
            'id'      			=>  (int)$comment->id,
            'name'      		=>  $comment->name,
            'content'		    => 	$comment->content,
            'postId'		    => 	$comment->post_id,
            'userId'		    => 	$comment->user_id,
            'createdAt'			=>  Carbon::parse($comment->created_at)->format('Y-m-d'),
            'updatedAt'		    =>  Carbon::parse($comment->updated_at)->format('Y-m-d'),
        ];
    }
}

