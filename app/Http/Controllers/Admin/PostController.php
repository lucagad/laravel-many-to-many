<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
Use App\Http\Requests\PostsRequest;
use Illuminate\Support\Str;

Use App\Post;
Use App\Category;
Use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
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
        $tags = Tag::all();

        return view('admin.posts.create', compact ('categories','tags'));
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

        // dd($data);

        if(array_key_exists('tags',$data)){
            foreach ($data['tags'] as $tag) {
                $new_post->tags()->attach($tag);
            }
        }

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
        $tags = Tag::all();
        $post = Post::find($id);
        
        if($post){

            return view('admin.posts.edit', compact('post','categories','tags'));

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
        } else{
            $new_data['slug'] = $post->slug;
        }

        $post->update($new_data);

        if(array_key_exists('tags',$new_data)){
            // se esiste l'array tags lo uso per sincronizzare i dati della tabella ponte
            $post->tags()->sync($new_data['tags']);
        } else {
            // se non esiste la chiave vuol dire che devo cancellare tutte le relazioni eventualmente presenti
            $post->tags()->detach();
        }

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
        $post->tags()->detach();
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
