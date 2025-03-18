<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'sender_user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'recipient_user_id' => User::inRandomOrder()->first()->id ?? null,
            'subscription_id' => $this->faker->randomNumber(),
            'post_id' => $this->faker->randomNumber(),
            'stream_id' => $this->faker->randomNumber(),
            'invoice_id' => $this->faker->randomNumber(),
            'user_message_id' => $this->faker->randomNumber(),
            'unlock_type' => $this->faker->randomElement(['unlock_video', 'unlock_audio', 'message']),
            'video_call_id' => Str::random(10),
            'audio_call_id' => Str::random(10),
            'chat_id' => Str::random(10),
            'stripe_transaction_id' => Str::random(20),
            'stripe_session_id' => Str::random(20),
            'paypal_transaction_id' => Str::random(20),
            'paypal_transaction_token' => Str::random(20),
            'coinbase_charge_id' => Str::random(20),
            'coinbase_transaction_token' => Str::random(20),
            'nowpayments_payment_id' => Str::random(20),
            'nowpayments_order_id' => Str::random(20),
            'ccbill_payment_token' => Str::random(20),
            'ccbill_transaction_id' => Str::random(20),
            'ccbill_subscription_id' => Str::random(20),
            'paystack_payment_token' => Str::random(20),
            'status' => $this->faker->randomElement(['approved', 'canceled', 'declined', 'initiated']),
            'type' => $this->faker->randomElement(['deposit', 'withdrawal', 'one-month-subscription', 'tip', 'message-unclock', 'post-unlock', 'stream-access']),
            'payment_provider' => $this->faker->randomElement(['stripe', 'paypal', 'coinbase', 'paystack']),
            'currency' => $this->faker->currencyCode,
            'paypal_payer_id' => Str::random(10),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'taxes' => json_encode(['tax' => $this->faker->randomFloat(2, 0, 50)]),
        ];
    }
}
