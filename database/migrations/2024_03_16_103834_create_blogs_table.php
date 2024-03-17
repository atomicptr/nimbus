<?php

use App\Models\Blog;
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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('description', 255)->nullable();

            $table->timestamps();
        });

        Schema::create('user_blogs', function (Blueprint $table) {
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Blog::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('user_blogs');
    }
};
