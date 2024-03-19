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
        User::factory()->create(['name' => 'Iam Admin', 'email' => 'admin@nimbus.tld', 'is_admin' => true]);
        User::factory()->create(['name' => 'Iam User', 'email' => 'user@nimbus.tld', 'is_admin' => false]);
        User::factory(8)->create();

        $this->call(BlogSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostSeriesSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ApiKeySeeder::class);
        $this->call(LinkSeeder::class);
    }
}
