<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth('customer')
            ->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view(
            'user.notifications',
            compact('notifications')
        );
    }

    public function markAllRead()
    {
        auth('customer')
            ->user()
            ->notifications()
            ->whereNull('read_at')
            ->update([
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function markRead(Notification $notification)
    {
        abort_unless(
            $notification->customer_id == auth('customer')->id(),
            403
        );

        if (!$notification->read_at) {
            $notification->update([
                'read_at' => now()
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

}
