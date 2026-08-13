<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductReviewController extends Controller
{
    /* ════════════════════════════════════════════════════════
     *  INDEX  — listing with filters, stats, rating tabs
     * ════════════════════════════════════════════════════════ */

    public function index(Request $request): View
    {
        // ── Filters ──────────────────────────────────────────
        $search   = $request->input('search');
        $status   = $request->input('status');
        $rating   = $request->input('rating');
        $verified = $request->input('verified');
        $period   = $request->input('period');

        // ── Base query ────────────────────────────────────────
        $query = ProductReview::with([
                'product.images',
                'customer',
                'images',
            ])
            ->latest();

        // Search: product name, customer name, review title/body
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('product',  fn ($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhere('title',  'like', "%{$search}%")
                  ->orWhere('review', 'like', "%{$search}%");
            });
        }

        if ($status)   $query->where('status', $status);
        if ($rating)   $query->where('rating', (int) $rating);
        if ($verified !== null && $verified !== '') {
            $query->where('verified_purchase', (bool) $verified);
        }

        if ($period) {
            $query->when($period === 'today', fn ($q) => $q->whereDate('created_at', today()))
                  ->when($period === 'week',  fn ($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
                  ->when($period === 'month', fn ($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year));
        }

        $reviews = $query->paginate(15)->withQueryString();

        // ── Stats ─────────────────────────────────────────────
        $totalReviews = ProductReview::count();
        $avgRating    = round(ProductReview::approved()->avg('rating') ?? 0, 1);
        $pendingCount = ProductReview::pending()->count();
        $approvedCount= ProductReview::approved()->count();
        $rejectedCount= ProductReview::rejected()->count();

        // ── Rating distribution (for tabs) ────────────────────
        $ratingCounts = ProductReview::selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'avgRating',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'ratingCounts',
        ));
    }

    /* ════════════════════════════════════════════════════════
     *  SHOW  — JSON for the detail modal (AJAX)
     * ════════════════════════════════════════════════════════ */

    public function show(ProductReview $review): JsonResponse
    {
        $review->load(['product.images', 'customer', 'images']);

        return response()->json([
            'id'               => $review->id,
            'product_name'     => $review->product?->name,
            'product_sku'      => $review->product?->sku,
            'product_image'    => $review->product?->display_image,
            'customer_name'    => $review->customer?->name,
            'customer_email'   => $review->customer?->email,
            'rating'           => $review->rating,
            'title'            => $review->title,
            'review'           => $review->review,
            'status'           => $review->status,
            'pill_class'       => $review->pill_class,
            'status_label'     => $review->status_label,
            'verified_purchase'=> $review->verified_purchase,
            'featured'         => $review->featured,
            'created_at'       => $review->created_at->format('d M Y'),
            'images'           => $review->images->map(fn ($img) => [
                'id'  => $img->id,
                'url' => $img->url,
            ]),
        ]);
    }

    /* ════════════════════════════════════════════════════════
     *  APPROVE  — AJAX
     * ════════════════════════════════════════════════════════ */

    public function approve(ProductReview $review): JsonResponse
    {
        $review->update(['status' => 'approved']);

        return response()->json([
            'success'      => true,
            'status'       => 'approved',
            'pill_class'   => 'pill-approved',
            'status_label' => 'Approved',
        ]);
    }

    /* ════════════════════════════════════════════════════════
     *  REJECT  — AJAX
     * ════════════════════════════════════════════════════════ */

    public function reject(ProductReview $review): JsonResponse
    {
        $review->update(['status' => 'rejected']);

        return response()->json([
            'success'      => true,
            'status'       => 'rejected',
            'pill_class'   => 'pill-rejected',
            'status_label' => 'Rejected',
        ]);
    }

    /* ════════════════════════════════════════════════════════
     *  DESTROY  — AJAX
     * ════════════════════════════════════════════════════════ */

    public function destroy(ProductReview $review): JsonResponse
    {
        // Delete associated images from storage
        foreach ($review->images as $img) {
            \Storage::disk('public')->delete($img->image);
        }

        $review->delete();

        return response()->json(['success' => true]);
    }

    /* ════════════════════════════════════════════════════════
     *  EXPORT  — CSV download
     * ════════════════════════════════════════════════════════ */

    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $reviews = ProductReview::with(['product', 'customer'])
            ->latest()
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reviews-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($reviews) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID', 'Product', 'Customer', 'Rating', 'Title',
                'Review', 'Verified', 'Status', 'Date',
            ]);

            foreach ($reviews as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->product?->name,
                    $r->customer?->name,
                    $r->rating,
                    $r->title,
                    $r->review,
                    $r->verified_purchase ? 'Yes' : 'No',
                    $r->status,
                    $r->created_at->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}