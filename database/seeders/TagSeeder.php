<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Random\RandomException;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws RandomException
     */
    public function run(): void
    {
        Blog::all()->each(function (Blog $blog) {
            $maxTags = random_int(1, 10);
            for ($i = 0; $i < $maxTags; $i++) {
                Tag::factory()->create(['blog_id' => $blog->id]);
            }

            $blog->posts()->each(function (Post $post) use ($blog, $maxTags) {
                for ($i = 0; $i < random_int(1, min(5, $maxTags)); $i++) {
                    /** @var Tag $tag */
                    $tag = $blog->tags()->get()->random();
                    $tag->posts()->attach($post->id);
                }
            });
        });
    }
}
