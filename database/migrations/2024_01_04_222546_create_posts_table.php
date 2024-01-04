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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id')->index();
            $table->unsignedBigInteger('api_source_id')->index();
            $table->text('title');
            $table->text('description');
            $table->text('url');
            $table->text('url_to_image');
            $table->dateTime('published_at');
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('sources')->noActionOnDelete();
            $table->foreign('api_source_id')->references('id')->on('api_sources')->noActionOnDelete();

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
