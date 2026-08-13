<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcement.index', compact('announcements'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.announcement.create');
    }

    /**
     * Store new announcement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'link' => 'nullable|url'
        ]);

        Announcement::create([
            'title' => $request->title,
            'link' => $request->link,
            'status' => $request->status ?? 0
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    /**
     * Show single (optional)
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcement.show', compact('announcement'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcement.edit', compact('announcement'));
    }

    /**
     * Update announcement
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'link' => 'nullable|url'
        ]);

        $announcement = Announcement::findOrFail($id);


        $announcement->update([
            'title' => $request->title,
            'link' => $request->link,
            'status' => $request->status ?? 0
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    /**
     * Delete announcement
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}