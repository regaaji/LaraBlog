<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\{Category, Post, Tag};
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
  //proteksi page auth login 
  // public function __construct()
  // { 
  //     $this->middleware('auth')->except([
  //       'index', 'show',
  //       ]);
  // }

  public function index()
  {
    return view('posts.index', [
        'posts' => Post::latest()->paginate(6),
    ]);
  }
  
  public function show(Post $post)
  {
      $posts = Post::where('category_id', $post->category_id)->latest()->limit(6)->get();
      return view('posts.show', compact('post', 'posts'));
  }

  public function create()
  {
      return view('posts.create', [
        'post' => new Post(),
        'categories' => Category::get(),
        'tags' => Tag::get(),
      ]);
  }

  public function store(PostRequest $request)
  {
    //validate image
    $request->validate([

      'thumbnail' => 'image|mimes: jpeg, jpg, png, svg|max:2048',

    ]);

    $attr = $request->all();
    
    //Assign title to the slug    
    $slug = \Str::slug(request('title'));
    $attr['slug'] = $slug;
 
    $attr['category_id'] = request('category');

    //agar field thumbnail di database tidak nullable
     //if (request()->file('thumbnail')) {
        //jangan lupa config File Stystem Storage di .env
         //$thumbnail = request()->file('thumbnail');
         // $thumbnailUrl = $thumbnail->storeAs("image/posts", "{$slug}.{$thumbnail->extension()}");
         //$thumbnailUrl = $thumbnail->store("image/posts");

       //  $thumbnail = request()->file('thumbnail')->store("image/posts");
     //}  else {
       // $thumbnail = null;
     //}
    //jika menggunakan ternary operator
     $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store("image/posts") : null;

    $attr['thumbnail'] = $thumbnail;

    //Create new post
    $post = auth()->user()->posts()->create($attr); 

    $post->tags()->attach(request('tags'));

    session()->flash('success', 'The post was created');

     return redirect()->to('posts');
    //return back();
  }

  public function edit(Post $post)
  {
    return view('posts.edit', [
      'post' => $post,
      'categories' => Category::get(),
      'tags' => Tag::get(),
    ]);
  }

  public function update(PostRequest $request,Post $post)
  {
    
      //postpolicy
      $this->authorize('update', $post);

       //validate image
      $request->validate([

        'thumbnail' => 'image|mimes: jpeg, jpg, png, svg|max:2048',

      ]);


      if (request()->file('thumbnail')) {
          \Storage::delete($post->thumbnail);
          //jangan lupa config File Stystem Storage di .env
          $thumbnail = request()->file('thumbnail')->store("image/posts");

      } else {
        $thumbnail = $post->thumbnail;
      }


      //validate the field
      $attr = $this->validateRequest();


      $attr['category_id'] = request('category'); 
      $attr['thumbnail'] = $thumbnail; 
      
      
      //Update new Post
      $post->update($attr);

      $post->tags()->sync(request('tags'));

    session()->flash('success', 'The post was updated');

     return redirect()->to('posts');
  }

  public function validateRequest()
  {
    return request()->validate([
      'title' => 'required|min:3',
      'body' => 'required',
    ]);
  }

  public function destroy(Post $post)
  {

    // if(auth()->user()->is($post->author)){
    //   $post->tags()->detach();
    //   $post->delete();
    //   session()->flash('success', 'The post was destroyed');
    //    return redirect('posts');
    // } else {
    //   session()->flash('error', "It was'nt was post");
    //    return redirect('posts');
    // }

    $this->authorize('delete', $post);

    \Storage::delete($post->thumbnail);
    
    $post->tags()->detach();
    $post->delete();
    session()->flash('success', 'The post was destroyed');
    return redirect('posts');

   
  }
}
