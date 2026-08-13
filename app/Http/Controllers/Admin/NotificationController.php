<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = AdminNotification::latest();

        if ($filter === 'unread') {
            $query->unread();
        } elseif (! in_array($filter, ['all', 'unread'])) {
            $query->where('type', $filter);
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $notifications = $query->paginate(16)->withQueryString();

        $counts = [
            'all'      => AdminNotification::count(),
            'unread'   => AdminNotification::unread()->count(),
            'order'    => AdminNotification::where('type', 'order')->count(),
            'stock'    => AdminNotification::where('type', 'stock')->count(),
            'customer' => AdminNotification::where('type', 'customer')->count(),
            'payment'  => AdminNotification::where('type', 'payment')->count(),
            'return'   => AdminNotification::where('type', 'return')->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'counts', 'filter', 'search'));
    }

    public function markRead(AdminNotification $notification)
    {
        $notification->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        AdminNotification::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function clearRead()
    {
        AdminNotification::whereNotNull('read_at')->delete();
        return response()->json(['success' => true]);
    }

    public function destroy(AdminNotification $notification)
    {
        $notification->delete();
        return response()->json(['success' => true]);
    }
}