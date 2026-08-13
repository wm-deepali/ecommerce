<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DynamicPage;

class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|unique:dynamic_pages',
            'heading' => 'required',
            'content' => 'required'
        ]);

        DynamicPage::create($request->all());

        return redirect()->route('admin.pages.index')->with('success', 'Page Created');
    }

    public function edit($id)
    {
        $page = DynamicPage::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = DynamicPage::findOrFail($id);

        $request->validate([
            'page_name' => 'required|unique:dynamic_pages,page_name,' . $id,
            'heading' => 'required',
            'content' => 'required'
        ]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        DynamicPage::destroy($id);
        return redirect()->back()->with('success','Deleted Successfully');
    }
}