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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id')->index()->nullable();
            $table->unsignedBigInteger('api_source_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('url')->nullable();
            $table->text('url_to_image')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('sources')->noActionOnDelete();
            $table->foreign('api_source_id')->references('id')->on('api_sources')->noActionOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->noActionOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table->dropForeign(['api_source_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('articles');
    }
};
