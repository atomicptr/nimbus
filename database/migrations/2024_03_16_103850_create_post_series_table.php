<?php

use App\Models\Blog;
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
        Schema::create('post_series', function (Blueprint $table) {
            $table->id();

            $table->string("title", 255);
            $table->string("slug", 255)->unique();
            $table->string("description", 255)->nullable();

            $table->foreignIdFor(Blog::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_series');
    }
};
