<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'subscription_id',
        'post_id',
        'stream_id',
        'invoice_id',
        'user_message_id',
        'unlock_type',
        'video_call_id',
        'audio_call_id',
        'chat_id',
        'stripe_transaction_id',
        'stripe_session_id',
        'paypal_transaction_id',
        'paypal_transaction_token',
        'coinbase_charge_id',
        'coinbase_transaction_token',
        'nowpayments_payment_id',
        'nowpayments_order_id',
        'ccbill_payment_token',
        'ccbill_transaction_id',
        'ccbill_subscription_id',
        'paystack_payment_token',
        'status',
        'type',
        'payment_provider',
        'currency',
        'paypal_payer_id',
        'amount',
        'taxes',
    ];

    protected $table = 'transactions';

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    // Define a relationship to the receiver user (User model)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}
