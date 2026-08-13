<?php
// app/Http/Controllers/Admin/RedirectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        $query = Redirect::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('from_url', 'like', "%{$search}%")
                  ->orWhere('to_url', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $redirects = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => Redirect::count(),
            'active'   => Redirect::where('is_active', true)->count(),
            'inactive' => Redirect::where('is_active', false)->count(),
            '301'      => Redirect::where('type', '301')->count(),
            '302'      => Redirect::where('type', '302')->count(),
            '410'      => Redirect::where('type', '410')->count(),
            'hits'     => Redirect::sum('hits'),
        ];

        return view('admin.security.redirects', compact('redirects', 'stats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_url' => 'required|string|max:255',
            'to_url'   => 'nullable|string|max:255|required_unless:type,410',
            'type'     => 'required|in:301,302,410',
            'note'     => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $redirect = Redirect::create([
            'from_url'  => $request->from_url,
            'to_url'    => $request->type === '410' ? null : $request->to_url,
            'type'      => $request->type,
            'is_active' => true,
            'note'      => $request->note ?? 'Just added',
        ]);

        return response()->json(['success' => true, 'redirect' => $redirect]);
    }

    public function update(Request $request, Redirect $redirect)
    {
        $validator = Validator::make($request->all(), [
            'from_url' => 'required|string|max:255',
            'to_url'   => 'nullable|string|max:255|required_unless:type,410',
            'type'     => 'required|in:301,302,410',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $redirect->update([
            'from_url' => $request->from_url,
            'to_url'   => $request->type === '410' ? null : $request->to_url,
            'type'     => $request->type,
        ]);

        return response()->json(['success' => true, 'redirect' => $redirect]);
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return response()->json(['success' => true]);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        Redirect::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'deleted' => count($ids)]);
    }

    public function bulkToggle(Request $request)
    {
        $ids    = $request->input('ids', []);
        $action = $request->input('action'); // 'enable' | 'disable'

        Redirect::whereIn('id', $ids)->update(['is_active' => $action === 'enable']);

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Redirect $redirect)
    {
        $redirect->update(['is_active' => !$redirect->is_active]);
        return response()->json(['success' => true, 'is_active' => $redirect->is_active]);
    }

    public function exportCsv()
    {
        $redirects = Redirect::all();

        $csv = "from_url,to_url,type,status,hits\n";
        foreach ($redirects as $r) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s"' . "\n",
                $r->from_url,
                $r->to_url ?? '',
                $r->type,
                $r->is_active ? 'active' : 'inactive',
                $r->hits
            );
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="redirects.csv"',
        ]);
    }

    public function downloadTemplate()
    {
        $csv = "from_url,to_url,type\n/old-page,/new-page,301\n/temp-sale,/sale-2025,302\n/deleted-product,,410\n";

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="redirect-template.csv"',
        ]);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file   = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        $header    = fgetcsv($handle); // skip header row
        $imported  = 0;
        $skipped   = 0;
        $rowCount  = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;
            if ($rowCount > 1000) break; // max 1000 rows per import

            [$fromUrl, $toUrl, $type] = array_pad($row, 3, null);

            if (empty($fromUrl) || !in_array($type, ['301', '302', '410'])) {
                $skipped++;
                continue;
            }

            Redirect::create([
                'from_url'  => trim($fromUrl),
                'to_url'    => $type === '410' ? null : trim($toUrl ?? ''),
                'type'      => $type,
                'is_active' => true,
                'note'      => 'Bulk imported',
            ]);

            $imported++;
        }

        fclose($handle);

        return response()->json([
            'success'  => true,
            'imported' => $imported,
            'skipped'  => $skipped,
        ]);
    }
}