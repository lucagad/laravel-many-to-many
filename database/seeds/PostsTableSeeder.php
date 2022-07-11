<?php
use App\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 50; $i++){

            $new_post = new Post();

            $new_post->title = $faker->sentence();
            $new_post->slug = $this->createSlug($new_post->title);
            $new_post->content =  $faker->text();

            $new_post->save();

        }
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
