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
            $table->string('author')->nullable()->index();
            $table->string('category')->index();
            $table->string('title')->index();
            $table->text('description')->fulltext();
            $table->text('content')->fulltext();
            $table->text('url');
            $table->text('url_to_image')->nullable();
            $table->dateTime('published_at');
            $table->json('source')->index();
            $table->string('scraped_from')->index();
            $table->softDeletes();
            $table->timestamps();
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
