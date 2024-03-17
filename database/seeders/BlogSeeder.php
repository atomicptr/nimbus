<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // generate 3 blogs
        for ($i = 0; $i < 3; $i++) {
            Blog::factory()->create();
        }

        User::all()->each(function (User $user) {
            Blog::all()->random(random_int(1, 3))->each(function (Blog $blog) use ($user) {
                $user->blogs()->attach($blog->id);
            });
        });
    }
}
