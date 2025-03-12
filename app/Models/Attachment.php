<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attachment extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'filename', 'driver', 'type', 'user_id', 'post_id', 'wfilename', 'message_id', 'payment_request_id','mtype','attachmentscol'
    ];
    protected $table = 'attachments';
}
