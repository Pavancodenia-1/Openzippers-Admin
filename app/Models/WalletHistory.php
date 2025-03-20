<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class WalletHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'user_id',
        'wallet_id',
        'amount',
        'balance_before',
    ];
    protected $table = 'wallet_histories';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Define a relationship to the receiver user (User model)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
