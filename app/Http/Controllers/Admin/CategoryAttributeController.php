<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    public function index()
    {
        $categoryAttributes = CategoryAttribute::with([
            'category',
            'attribute'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'admin.category-attributes.index',
            compact('categoryAttributes')
        );
    }

    public function create()
    {
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        $attributes = Attribute::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.category-attributes.create',
            compact(
                'categories',
                'attributes'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'attribute_id'     => 'required|exists:attributes,id',

            'is_required'      => 'required|boolean',
            'is_selectable'    => 'required|boolean',
            'used_for_variant' => 'required|boolean',

            // Checkboxes — simply absent from the request when unchecked
            'price_dependent'  => 'nullable|boolean',
            'image_dependent'  => 'nullable|boolean',
            'stock_dependent'  => 'nullable|boolean',
            'sku_dependent'    => 'nullable|boolean',

            'show_in_filter'   => 'required|boolean',
            'show_on_listing'  => 'required|boolean',

            'sort_order'       => 'nullable|integer',
            'status'           => 'required|boolean',
        ]);

        $exists = CategoryAttribute::where(
            'category_id',
            $request->category_id
        )
        ->where(
            'attribute_id',
            $request->attribute_id
        )
        ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Mapping already exists.'
                );
        }

        $isVariant = $request->boolean('used_for_variant');

        CategoryAttribute::create([

            'category_id'      => $request->category_id,

            'attribute_id'     => $request->attribute_id,

            'is_required'      => $request->is_required,

            'is_selectable'    => $request->is_selectable,
            
            'used_for_variant' => $isVariant,
            'price_dependent'  => $isVariant && $request->boolean('price_dependent'),
            'image_dependent'  => $isVariant && $request->boolean('image_dependent'),
            'stock_dependent'  => $isVariant && $request->boolean('stock_dependent'),
            'sku_dependent'    => $isVariant && $request->boolean('sku_dependent'),

            'show_in_filter'   => $request->show_in_filter,

            'show_on_listing'  => $request->show_on_listing,

            'sort_order'       => $request->sort_order ?? 0,

            'status'           => $request->status,

        ]);

        return redirect()
            ->route('admin.category-attributes.index')
            ->with(
                'success',
                'Category Attribute created successfully.'
            );
    }

    public function edit(CategoryAttribute $categoryAttribute)
    {
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        $attributes = Attribute::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.category-attributes.edit',
            compact(
                'categoryAttribute',
                'categories',
                'attributes'
            )
        );
    }

    public function update(
        Request $request,
        CategoryAttribute $categoryAttribute
    ) {

        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'attribute_id'     => 'required|exists:attributes,id',

            'is_required'      => 'required|boolean',
            'is_selectable'    => 'required|boolean',
            'used_for_variant' => 'required|boolean',
            'price_dependent'  => 'nullable|boolean',
            'image_dependent'  => 'nullable|boolean',
            'stock_dependent'  => 'nullable|boolean',
            'sku_dependent'    => 'nullable|boolean',

            'show_in_filter'   => 'required|boolean',
            'show_on_listing'  => 'required|boolean',

            'sort_order'       => 'nullable|integer',
            'status'           => 'required|boolean',
        ]);

        $exists = CategoryAttribute::where(
            'category_id',
            $request->category_id
        )
        ->where(
            'attribute_id',
            $request->attribute_id
        )
        ->where(
            'id',
            '!=',
            $categoryAttribute->id
        )
        ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Mapping already exists.'
                );
        }

        // ✅ A non-selectable attribute cannot drive price/image/stock/sku
        $isVariant = $request->boolean('used_for_variant');

        $categoryAttribute->update([

            'category_id'      => $request->category_id,

            'attribute_id'     => $request->attribute_id,

            'is_required'      => $request->is_required,

            'is_selectable'    => $request->is_selectable,
            
            'used_for_variant' => $isVariant,
            'price_dependent'  => $isVariant && $request->boolean('price_dependent'),
            'image_dependent'  => $isVariant && $request->boolean('image_dependent'),
            'stock_dependent'  => $isVariant && $request->boolean('stock_dependent'),
            'sku_dependent'    => $isVariant && $request->boolean('sku_dependent'),

            'show_in_filter'   => $request->show_in_filter,

            'show_on_listing'  => $request->show_on_listing,

            'sort_order'       => $request->sort_order ?? 0,

            'status'           => $request->status,

        ]);

        return redirect()
            ->route('admin.category-attributes.index')
            ->with(
                'success',
                'Category Attribute updated successfully.'
            );
    }

    public function destroy(CategoryAttribute $categoryAttribute)
    {
        $categoryAttribute->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Deleted successfully.'
        ]);
    }
}