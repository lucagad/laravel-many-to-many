<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
Use App\Http\Requests\PostsRequest;
use Illuminate\Support\Str;

Use App\Post;
Use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(6);
        $categories = Category::all();
        return view('admin.posts.index', compact('posts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact ('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        $data = $request->all();

        $new_post = new Post();
        $data['slug'] = $this->createSlug($data['title']);

        $new_post->fill($data);
        $new_post->save();

        return redirect()->route('admin.posts.show', $new_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view ('admin.posts.show' , compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = Category::all();
        $post = Post::find($id);
        
        if($post){

            return view('admin.posts.edit', compact('post','categories'));

        } else { abort(404, 'Post not present in the database');}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, Post $post)
    {
        
        $new_data = $request->all();

        if($post->title != $new_data['title']){

            $new_data['slug'] = $this->createSlug($new_data['title']);

        }else{

            $new_data['slug'] = $post->slug;
            
        }

        $post->update($new_data);

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('post_deleted', "Il post ## $post->title ##  è stato cancellato correttamente.");
    }

    private function createSlug ($string) {

        $slug = Str::slug($string,'-');
        $control_slug = Post::where('slug', $slug)->first();
        $i = 0;

        while($control_slug){

            $slug = Str::slug ($string , '-');
            $i++;
            $control_slug = Post::where('slug', $slug)->first();

        }

        return $slug;
    }
}
