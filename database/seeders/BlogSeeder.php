<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // generate 3 blogs
        for ($i = 0; $i < 3; $i++) {
            $user = $users->random();
            $user->blogs()->attach(Blog::factory()->create());
        }
    }
}
