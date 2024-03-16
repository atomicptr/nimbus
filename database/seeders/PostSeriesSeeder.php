<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\PostSeries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class PostSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Blog::all()->each(function (Blog $blog) {
            $count = $blog->posts()->count();
            for ($i = 0; $i < random_int(1, $count); $i++) {
                $posts = $blog->posts()->get()->random(random_int(1, $count));

                foreach ($posts as $post) {
                    if ($post->post_series_id) {
                        continue;
                    }

                    $series = PostSeries::factory()->create(["blog_id" => $blog->id]);
                    $post->post_series_id = $series->id;
                    $post->save();
                }
            }
        });
    }
}
