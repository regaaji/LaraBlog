<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['title', 'slug', 'body', 'category_id', 'thumbnail'];
    // protected $guarded = [];

    //handle query yang berulang
    protected $with = ['author', 'category', 'tags'];

    //one to manny table category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTakeImageAttribute()
    {
        return '/storage/' . $this->thumbnail;
    }

    //many to many table tags
    public function tags()
    {
       return $this->belongsToMany(Tag::class);
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


//    public function scopeLatestFirst()
//    {
//        return $this->latest()->first();
//    }

//    public function scopeLatestPost()
//    {
//        return $this->get();
//    }
}
