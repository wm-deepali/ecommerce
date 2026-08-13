<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoPage;

class SeoController extends Controller
{
    public function index()
    {
        $pages = SeoPage::orderBy('id')->get();
        return view('admin.seo.index', compact('pages'));
    }

    public function update(Request $request, $id)
    {
        $page = SeoPage::findOrFail($id);

        $page->update([
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'scripts' => $request->scripts,
        ]);

        return back()->with('success', 'SEO Updated Successfully');
    }
}