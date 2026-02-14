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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('teacher_id');
    $table->unsignedBigInteger('class_id');
    $table->string('title');
    $table->text('description')->nullable();
    $table->enum('type', ['document', 'video', 'image', 'text']);
    $table->string('file_path')->nullable(); // for documents, videos, images
    $table->text('content')->nullable(); // for text materials
    $table->timestamps();

    $table->foreign('teacher_id')->references('id')->on('users');
    $table->foreign('class_id')->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
