<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $post = new Post;
        $post->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
        $post->user_id = 1;
        $post->save();

        $post = new Post;
        $post->body = "My dog is quite hip, except when he takes a dip, he looks like a fool, when he jumps in the pool, and reminds me of a sinking ship";
        $post->user_id = 2;
        $post->save();

    }
}
