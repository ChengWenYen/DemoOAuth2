<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineNotificationRecipient extends Model
{
    use HasFactory;

    protected $table = "line_notification_recipients";

    protected $fillable = [
        'line_notification_id',
        'recipient_id'
    ];

    public function name() {
        return $this->belongsTo(User::class, 'recipient_id')->first()->name;
    }
}
