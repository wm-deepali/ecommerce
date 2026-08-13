<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Collection::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $collections = $query
            ->orderBy('sort_order')
            ->paginate(10);

        return view(
            'admin.collections.index',
            compact('collections')
        );
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        Collection::create([
            'name' => $request->name,
            'slug' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'code' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('admin.collections.index')
            ->with(
                'success',
                'Collection created successfully.'
            );
    }

    public function edit($id)
    {
        $collection = Collection::findOrFail($id);

        return view(
            'admin.collections.edit',
            compact('collection')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $collection = Collection::findOrFail($id);

        $collection->update([
            'name' => $request->name,

            'slug' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'code' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('admin.collections.index')
            ->with(
                'success',
                'Collection updated successfully.'
            );
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);

        $collection->delete();

        return response()->json([
            'message' => 'Collection deleted successfully.'
        ]);
    }
}