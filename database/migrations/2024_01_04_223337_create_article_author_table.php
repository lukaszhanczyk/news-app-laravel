<?php

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
        Schema::create('article_author', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->index()->nullable();
            $table->unsignedBigInteger('article_id')->index()->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreign('article_id')->references('id')->on('articles')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_author', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['article_id']);
        });
        Schema::dropIfExists('article_author');
    }
};
