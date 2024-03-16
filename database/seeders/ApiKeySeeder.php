<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            $user->blogs()->each(function (Blog $blog) use($user) {
                ApiKey::factory()->create([
                    "user_id" => $user->id,
                    "blog_id" => $blog->id,
                ]);
            });
        });
    }
}
