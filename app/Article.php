<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;
class Article extends Model
{
    //
    protected $fillable = ['title', 'article_text'];
    public function tag(){
    	return $this->belongsToMany('App\Tag','article_tag');
    }
}
