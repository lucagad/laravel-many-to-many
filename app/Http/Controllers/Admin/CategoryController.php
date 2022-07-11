<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Use App\Category;

class CategoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.categories.createCategory', compact ('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $new_category = new Category();
        $data['slug'] = $this->createSlug($data['name']);

        $new_category ->fill($data);
        $new_category ->save();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Category::find($id);
        
        if($category){

            return view('admin.categories.editCategory', compact('category'));

        } else { abort(404, 'Category not present in the database');}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $new_data = $request->all();

        if($category->name != $new_data['name']){

            $new_data['slug'] = $this->createSlug($new_data['name']);

        }else{

            $new_data['slug'] = $category->slug;
            
        }

        $category->update($new_data);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        
    }

    private function createSlug ($string) {

        $slug = Str::slug($string,'-');
        $control_slug = Category::where('slug', $slug)->first();
        $i = 0;

        while($control_slug){

            $slug = Str::slug ($string , '-');
            $i++;
            $control_slug = Category::where('slug', $slug)->first();

        }

        return $slug;
    }
}
