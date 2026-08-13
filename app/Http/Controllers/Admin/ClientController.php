<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('clients', 'public');
        }

        Client::create([
            'name' => $request->name,
            'logo' => $logo,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success','Client Created');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $logo = $client->logo;

        if ($request->hasFile('logo')) {

            // delete old image
            if ($client->logo && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }

            // store new
            $logo = $request->file('logo')->store('clients', 'public');
        }

        $client->update([
            'name' => $request->name,
            'logo' => $logo,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success','Client Updated');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id)->delete();

        // delete image from storage
        if ($client->logo && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return response()->json(['message'=>'Deleted']);
    }
}