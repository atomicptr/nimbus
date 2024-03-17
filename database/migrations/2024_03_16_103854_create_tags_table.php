<?php

use App\Models\Blog;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('description', 255)->nullable();

            $table->foreignIdFor(Blog::class);
            $table->timestamps();
        });

        Schema::create('tagged_posts', function (Blueprint $table) {
            $table->foreignIdFor(Tag::class);
            $table->foreignIdFor(Post::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tagged_posts');
    }
};
