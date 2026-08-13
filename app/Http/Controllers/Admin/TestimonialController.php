<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use App\Traits\CompressesImages;

class TestimonialController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();


        if ($request->hasFile('photo')) {
            // Small circular/avatar-style testimonial photo
            $data['photo'] = $this->compressAndStore(
                $request->file('photo'),
                'testimonials',
                500,
                80
            );
        }

        // REEL FILE
        if ($request->hasFile('reel_file')) {
            $reel = $request->file('reel_file')->store('testimonials', 'public');
            $data['reel_file'] = $reel;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial Added');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->all();

        // PHOTO
        if ($request->hasFile('photo')) {
            if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = $this->compressAndStore(
                $request->file('photo'),
                'testimonials',
                500,
                80
            );
        }

        // REEL FILE
        if ($request->hasFile('reel_file')) {
            if ($testimonial->reel_file && Storage::disk('public')->exists($testimonial->reel_file)) {
                Storage::disk('public')->delete($testimonial->reel_file);
            }
            $reel = $request->file('reel_file')->store('testimonials', 'public');
            $data['reel_file'] = $reel;
        }


        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // delete image from storage
        if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        if ($testimonial->reel_file && Storage::disk('public')->exists($testimonial->reel_file)) {
            Storage::disk('public')->delete($testimonial->reel_file);
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}