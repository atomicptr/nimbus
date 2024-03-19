<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Post;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::all()->each(function (Post $post) {
            $rand = random_int(0, 3);

            for ($i = 0; $i < $rand; $i++) {
                $link = Link::factory()->create(['post_id' => $post->id, 'blog_id' => $post->blog_id]);
                $post->links()->save($link);
            }
        });
    }
}
