<?php
namespace GD\Api\Transformers;
use GD\Api\Models\Post;
use League\Fractal;
use Carbon\Carbon;


class PostTransformer extends Fractal\TransformerAbstract{

    public function transform(Post $post){
        return [
            'id'      			=>  (int)$post->id,
            'title'      		=>  $post->title,
            'slug'              =>  $post->slug,
            'content'		    => 	$post->content,
            'image'			    => 	$post->image,
            'video'			    => 	$post->video,
            'authorId'			=> 	$post->author_id,
            'status'			=> 	$post->status,
            'typePost'			=> 	$post->type_post,
            'numberView'		=> 	$post->number_view,
            'rateStar'			=> 	$post->rate_star,
            'createdAt'			=>  Carbon::parse($post->created_at)->format('Y-m-d'),
            'updatedAt'		    =>  Carbon::parse($post->updated_at)->format('Y-m-d'),
        ];
    }
}

