<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoticeMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target',
        'subject',
        'message',
        'custom_emails',
    ];
}