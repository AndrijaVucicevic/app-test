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
        Schema::create('post_authors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id');
            $table->bigInteger('author_id');
            $table->timestamps();

            $table
            ->foreign('post_id')
            ->references('id')
            ->on('posts')
            ->onDelete('cascade');
        $table
            ->foreign('author_id')
            ->references('id')
            ->on('authors')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_authors');
    }
};
