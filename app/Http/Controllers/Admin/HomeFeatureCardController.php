<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeFeatureCard;
use Illuminate\Http\Request;

class HomeFeatureCardController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        $cards = HomeFeatureCard::orderBy('sort_order')
            ->paginate(10);

        return view(
            'admin.home.feature-cards.index',
            compact('cards')
        );
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.home.feature-cards.create');
    }

    /**
     * Store card
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'card_class' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        HomeFeatureCard::create([
            'icon' => $request->icon,
            'title' => $request->title,
            'content' => $request->content,
            'card_class' => $request->card_class,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.home-feature-cards.index')
            ->with(
                'success',
                'Feature card added successfully.'
            );
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $card = HomeFeatureCard::findOrFail($id);

        return view(
            'admin.home.feature-cards.edit',
            compact('card')
        );
    }

    /**
     * Update card
     */
    public function update(Request $request, $id)
    {
        $card = HomeFeatureCard::findOrFail($id);

        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'card_class' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $card->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'content' => $request->content,
            'card_class' => $request->card_class,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.home-feature-cards.index')
            ->with(
                'success',
                'Feature card updated successfully.'
            );
    }

    /**
     * Delete card
     */
    public function destroy($id)
    {
        $card = HomeFeatureCard::findOrFail($id);

        $card->delete();

        return response()->json([
            'message' => 'Feature card deleted successfully.'
        ]);
    }
}