<?php

use App\Models\Blog;
use App\Models\PostSeries;
use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->foreignIdFor(PostSeries::class)->nullable();
            $table->foreignIdFor(User::class, "author_id");
            $table->boolean('is_draft')->default(true);
            $table->dateTime("starttime")->nullable();
            $table->string("promo_image", 255)->nullable();

            $table->foreignIdFor(Blog::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
