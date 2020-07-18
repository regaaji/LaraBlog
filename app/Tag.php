<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    //many to many table posts
    public function posts()
    {
        //table post_tag
        return $this->belongsToMany(Post::class);
    }
}
