<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'feedback_date',
        'name',
        'email',
        'phone',
        'message',
        'promotion',
        'channel_sms',
        'channel_whatsapp',
        'channel_email',
    ];

    protected function casts(): array
    {
        return [
            'feedback_date' => 'date',
        ];
    }
}