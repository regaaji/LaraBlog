<?php

use Illuminate\Support\Facades\Route;

Route::get('search', 'SearchController@post')->name('search.posts');


//tidak di proteksi halaman login
Route::get('posts', 'PostController@index')->name('posts.index');

//proteksi halaman login 
Route::prefix('posts')->middleware('auth')->group(function (){
    Route::get('create', 'PostController@create')->name('posts.create');
    Route::post('store', 'PostController@store');
    Route::get('{post:slug}/edit', 'PostController@edit');
    Route::patch('{post:slug}/edit', 'PostController@update');
    Route::delete('{post:slug}/delete', 'PostController@destroy');
});

//di buat di bawah karena agar tidak terpengaruh slug middleware group
Route::get('posts/{post:slug}', 'PostController@show')->name('posts.show');

Route::get('categories/{category:slug}', 'CategoryController@show')->name('categories.show');


Route::get('tags/{tag:slug}', 'TagController@show')->name('tags.show');


    

// Route::get('contact', function() {
//     //menampilkan semua link url
//     //request->fullUrl()

//     //menampilkan pathnemae atau nama url terkait
//     //request->path()

//     //result contact
//     return request()->path('contact') == 'contact' ? 'Sama' : 'Tidak';

//     //result contact == contact    
//     return request()->is('contact') ? 'Sama' : 'Tidak';
// });


Route::view('contact', 'contact');

Route::view('about', 'about');

Route::view('login', 'login');



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
