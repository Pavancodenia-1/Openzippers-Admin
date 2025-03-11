<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'text', 'price', 'type', 'type_id', 'status', 'is_certified','is_publish','audio_image_url','stream_audio_image','video_image_url','filename'
    ];
    protected $table = 'posts';

}
