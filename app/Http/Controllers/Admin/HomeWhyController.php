<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeWhy;
use App\Models\HomeWhyCard;
use Illuminate\Support\Facades\Storage;

class HomeWhyController extends Controller
{
    public function index()
    {
        $why = HomeWhy::first();
        $cards = HomeWhyCard::latest()->get();

        return view('admin.home.why', compact('why', 'cards'));
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'sub_heading' => 'required',
        ]);

        $why = HomeWhy::first() ?? new HomeWhy();

        $why->heading = $request->heading;
        $why->sub_heading = $request->sub_heading;
        $why->save();

        return back()->with('success', 'Section updated');
    }

    public function storeCard(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'required',
        ]);

        HomeWhyCard::create([
            'title' => $request->title,
            'content' => $request->content,
            'icon' => $request->icon,
        ]);

        return back()->with('success', 'Card added');
    }

    // ✅ EDIT (GET DATA)
    public function editCard($id)
    {
        $card = HomeWhyCard::findOrFail($id);
        return response()->json($card);
    }

    // ✅ UPDATE
    public function updateCard(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'nullable',
        ]);

        $card = HomeWhyCard::findOrFail($id);

        $card->title = $request->title;
        $card->content = $request->content;
        $card->icon = $request->icon;
        $card->save();

        return back()->with('success', 'Card updated successfully');
    }

    public function deleteCard($id)
    {
        $HomeWhyCard = HomeWhyCard::findOrFail($id);
        
        $HomeWhyCard->delete();

        return response()->json([
            'message' => 'Card Deleted Successfully'
        ]);
    }
}
