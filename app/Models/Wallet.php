<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'price',
        'type',
        'type_id',
        'status',
        'is_certified',
        'is_publish',
        'audio_image_url',
        'stream_audio_image',
        'video_image_url',
        'filename'
    ];

    protected $table = 'wallets';

    // Set the primary key type to string (UUIDs are strings)
    protected $keyType = 'string';

    // Disable auto-incrementing (because UUIDs are not auto-incrementing)
    public $incrementing = false;

    // Set the primary key column name (optional, Laravel defaults to 'id')
    protected $primaryKey = 'id';

    // Automatically generate a UUID when a new Wallet is created
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wallet) {
            if (empty($wallet->id)) {
                $wallet->id = (string) Str::uuid(); // Generate a UUID
            }
        });
    }
}
