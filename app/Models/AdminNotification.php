<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'reference',
        'icon',
        'color',
        'url',
        'link_text',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function getIsReadAttribute()
    {
        return ! is_null($this->read_at);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
    
    // app/Models/AdminNotification.php mein add karo:

public static function notify(array $data)
{
    return self::create([
        'type'      => $data['type'],
        'title'     => $data['title'],
        'message'   => $data['message'] ?? null,
        'reference' => $data['reference'] ?? null,
        'icon'      => $data['icon'] ?? 'fa-bell',
        'color'     => $data['color'] ?? null,
        'url'       => $data['url'] ?? null,
        'link_text' => $data['link_text'] ?? null,
    ]);
}
}