<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Random\RandomException;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws RandomException
     */
    public function run(): void
    {
        $blogs = Blog::all();

        for ($i = 0; $i < 100; $i++) {
            $blog = $blogs->random();
            $author = $blog->users()->get()->random();

            /** @var Post $post */
            Post::factory()->create([
                'author_id' => $author->id,
                'blog_id' => $blog->id,
            ]);
        }
    }
}
