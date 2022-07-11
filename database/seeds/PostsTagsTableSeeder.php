<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Tag;


class PostsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {

        // estraggo random un post
        $post = Post::inRandomOrder()->first();

        // estraggo random l'ID di N tag
        $tag_id = Tag::inRandomOrder()->first()->id;
        // inserisco il dato nella tabella ponte

        $post->tags()->attach($tag_id);
        }
    }
}
