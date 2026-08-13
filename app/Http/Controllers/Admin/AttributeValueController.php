<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')
            ->latest()
            ->paginate(20);

        return view('admin.attribute-values.index', compact('attributeValues'));
    }

    public function create()
    {
        $attributes = Attribute::where('has_values', 1)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.attribute-values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);

        $rules = [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ];

        if ($attribute->type === 'color_swatch') {
            $rules['hex_code'] = 'required|max:20';
        }

        $request->validate($rules);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('attribute-values', 'public');
        }

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => trim($request->value),
            'image' => $image,
            'hex_code' => $attribute->type === 'color_swatch'
                ? $request->hex_code
                : null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('admin.attribute-values.index')
            ->with('success', 'Attribute value created successfully.');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::where('has_values', 1)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.attribute-values.edit',
            compact('attributeValue', 'attributes')
        );
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);

        $rules = [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ];

        if ($attribute->type === 'color_swatch') {
            $rules['hex_code'] = 'required|max:20';
        }

        $request->validate($rules);

        $image = $attributeValue->image;

        if ($request->hasFile('image')) {

            if ($attributeValue->image && Storage::disk('public')->exists($attributeValue->image)) {
                Storage::disk('public')->delete($attributeValue->image);
            }

            $image = $request->file('image')
                ->store('attribute-values', 'public');
        }

        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value' => trim($request->value),
            'image' => $image,
            'hex_code' => $attribute->type === 'color_swatch'
                ? $request->hex_code
                : null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('admin.attribute-values.index')
            ->with('success', 'Attribute value updated successfully.');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        if (
            $attributeValue->image &&
            Storage::disk('public')->exists($attributeValue->image)
        ) {

            Storage::disk('public')->delete($attributeValue->image);
        }

        $attributeValue->delete();

        return response()->json([
            'status' => true,
            'message' => 'Attribute value deleted successfully.',
        ]);
    }
}