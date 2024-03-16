<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $this->call(BlogSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostSeriesSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ApiKeySeeder::class);
    }
}
