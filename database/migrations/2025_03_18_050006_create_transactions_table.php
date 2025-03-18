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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_user_id');
            $table->unsignedBigInteger('recipient_user_id')->nullable();
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('stream_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('user_message_id')->nullable();

            $table->string('unlock_type', 50)->nullable();
            $table->string('video_call_id', 50)->nullable();
            $table->string('audio_call_id', 50)->nullable();
            $table->string('chat_id', 50)->nullable();
            // $table->foreignId('user_message_id')->nullable()->constrained('messages')->onDelete('set null');
            $table->string('stripe_transaction_id', 191)->nullable();
            $table->string('stripe_session_id', 191)->nullable();
            $table->string('paypal_transaction_id', 191)->nullable();
            $table->string('paypal_transaction_token', 191)->nullable();
            $table->string('coinbase_charge_id', 191)->nullable();
            $table->string('coinbase_transaction_token', 191)->nullable();
            $table->string('nowpayments_payment_id', 191)->nullable();
            $table->string('nowpayments_order_id', 191)->nullable();
            $table->string('ccbill_payment_token', 191)->nullable();
            $table->string('ccbill_transaction_id', 191)->nullable();
            $table->string('ccbill_subscription_id', 191)->nullable();
            $table->string('paystack_payment_token', 191)->nullable();
            $table->string('status', 191);
            $table->string('type', 191);
            $table->string('payment_provider', 191);
            $table->string('currency', 191);
            $table->string('paypal_payer_id', 191)->nullable();
            $table->double('amount', 8, 2);
            $table->text('taxes')->nullable();
            $table->timestamps();

            $table->foreign('sender_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('recipient_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('set null');
            $table->foreign('stream_id')->references('id')->on('streams')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
            $table->foreign('user_message_id')->references('id')->on('messages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
