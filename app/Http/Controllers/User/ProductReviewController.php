<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductReviewController extends Controller
{

    /**
     * Store review
     */

    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'nullable|exists:product_reviews,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string|max:2000',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $customer = Auth::guard('customer')->user();

        $orderItem = OrderItem::with('order', 'product')
            ->findOrFail($request->order_item_id);

        // Security
        abort_unless(
            $orderItem->order->customer_id == $customer->id,
            403
        );

        abort_unless(
            strtolower($orderItem->order->status) === 'delivered',
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Edit Existing Review
        |--------------------------------------------------------------------------
        */
        if ($request->filled('review_id')) {

            $review = ProductReview::where('id', $request->review_id)
                ->where('customer_id', $customer->id)
                ->firstOrFail();

            $review->update([
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'status' => 'pending', // optional re-approval
            ]);

            // Upload new images
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $path = $image->store('reviews', 'public');

                    $review->images()->create([
                        'image' => $path
                    ]);
                }
            }

            return back()->with(
                'success',
                'Review updated successfully.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create New Review
        |--------------------------------------------------------------------------
        */

        if ($orderItem->review()->exists()) {
            return back()->with(
                'error',
                'You have already reviewed this product.'
            );
        }

        $review = ProductReview::create([
            'product_id' => $orderItem->product_id,
            'customer_id' => $customer->id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'review' => $request->review,
            'verified_purchase' => true,
            'featured' => false,
            'status' => 'pending',
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('reviews', 'public');

                $review->images()->create([
                    'image' => $path
                ]);
            }
        }

        return back()->with(
            'success',
            'Thank you! Your review has been submitted.'
        );
    }


    public function destroy(ProductReview $review)
    {
        abort_unless(
            $review->customer_id == auth('customer')->id(),
            403
        );

        // delete images
        foreach ($review->images as $image) {

            if (
                $image->image &&
                Storage::disk('public')->exists($image->image)
            ) {
                Storage::disk('public')->delete($image->image);
            }

            $image->delete();
        }

        $review->delete();

        return back()->with(
            'success',
            'Review deleted successfully.'
        );
    }

}