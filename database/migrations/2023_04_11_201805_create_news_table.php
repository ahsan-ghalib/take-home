<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('author')->default('N/A')->nullable();
            $table->string('category');
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->text('url');
            $table->text('url_to_image')->nullable();
            $table->dateTime('published_at');
            $table->json('source');
            $table->string('scraped_from');
            $table->softDeletes();
            $table->timestamps();

            $table->fullText(['description', 'content']);
            $table->index(['category', 'title', 'published_at']);
            $table->unique('slug');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
