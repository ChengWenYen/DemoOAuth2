<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineNotification extends Model
{
    use HasFactory;

    protected $table = "line_notifications";

    protected $fillable = [
        'message',
        'sender_id'
    ];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients() {
        return $this->hasMany(LineNotificationRecipient::class, 'line_notification_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
