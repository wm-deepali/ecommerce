<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{

    public function index()
    {
        $faqs = Faq::latest()->get();

        return view('admin.faqs.index',compact('faqs'));
    }


    public function create()
    {
        return view('admin.faqs.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'question'=>'required',
            'answer'=>'required'
        ]);

        Faq::create([

            'question'=>$request->question,

            'answer'=>$request->answer,

            'show_home'=>$request->show_home ? 1:0,

            'status'=>$request->status ? 1:0

        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success','FAQ Added Successfully');

    }


    public function edit($id)
    {
        $faq = Faq::findOrFail($id);

        return view('admin.faqs.edit',compact('faq'));
    }


    public function update(Request $request,$id)
    {

        $faq = Faq::findOrFail($id);

        $faq->update([

            'question'=>$request->question,

            'answer'=>$request->answer,

            'show_home'=>$request->show_home ? 1:0,

            'status'=>$request->status ? 1:0

        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success','FAQ Updated Successfully');

    }


    public function destroy($id)
    {

        Faq::findOrFail($id)->delete();

        return response()->json([
            'message'=>'FAQ Deleted Successfully'
        ]);

    }

}