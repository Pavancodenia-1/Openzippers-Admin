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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
            $table->double('price', 8, 2)->default(0.00);
            $table->string('type')->nullable();
            $table->string('type_id')->nullable();
            $table->integer('status')->default(1);
            $table->string('is_certified')->nullable();
            $table->string('is_publish')->nullable();
            $table->string('audio_image_url')->nullable();
            $table->string('stream_audio_image')->nullable();
            $table->string('video_image_url')->nullable();
            $table->string('filename')->nullable();
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
