<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->paginate(20);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $types = [
            'button',
            'dropdown',
            'image',
            'color_swatch',
            'radio',
        ];

        return view('admin.attributes.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:button,dropdown,image,color_swatch,radio',
            'has_values' => 'required|boolean',
            'status' => 'required|boolean',
            'show_in_navbar' => 'required|boolean',
        ]);

        Attribute::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
            'has_values' => $request->has_values,
            'status' => $request->status,
            'show_in_navbar' => $request->show_in_navbar,
        ]);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        $types = [
            'button',
            'dropdown',
            'image',
            'color_swatch',
            'radio',
        ];

        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:button,dropdown,image,color_swatch,radio',
            'has_values' => 'required|boolean',
            'status' => 'required|boolean',
            'show_in_navbar' => 'required|boolean',
        ]);

        $attribute->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
            'has_values' => $request->has_values,
            'status' => $request->status,
            'show_in_navbar' => $request->show_in_navbar,
        ]);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }
}