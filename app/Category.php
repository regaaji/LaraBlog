<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //digunakan unutk create seeder and create database
    protected $fillable = ['name', 'slug']; 

    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
