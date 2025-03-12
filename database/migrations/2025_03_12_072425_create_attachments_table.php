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
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('filename');
            $table->integer('driver');
            $table->string('type', 191);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('wfilename');
            $table->unsignedBigInteger('message_id')->nullable();
            $table->unsignedBigInteger('payment_request_id')->nullable();
            $table->tinyinteger('mtype')->nullable();
            $table->string('attachmentscol', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
