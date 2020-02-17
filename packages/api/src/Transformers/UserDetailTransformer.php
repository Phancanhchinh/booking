<?php
namespace GD\Api\Transformers;
use GD\Api\Models\UserDetail;
use League\Fractal;
use Carbon\Carbon;

class UserDetailTransformer extends Fractal\TransformerAbstract{
    public function transform(UserDetail $detail){
        $url = 'http://bookingevent.xyz/uploads/images/';
        return [
            'id'      	    =>  (int) $detail->id,
            'userID'      	=>  (int) $detail->user_id,
            'background'	=> 	(string) $url.$detail->background,
            'image'         =>  (string) $url.$detail->image,
            'imageIntro'   =>  (string) $url.$detail->image_intro,
            'flag'          =>  (string) $url.$detail->flag,
            'createdAt'	    =>  Carbon::parse($detail->created_at)->format('Y-m-d'),
            'updatedAt'		=>  Carbon::parse($detail->updated_at)->format('Y-m-d'),
        ];
    }
}

