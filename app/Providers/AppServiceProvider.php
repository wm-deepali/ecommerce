<?php

namespace App\Providers;

use App\Models\Wishlist;
use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use Illuminate\Support\Facades\View;
use App\Models\DynamicPage;
use App\Models\Announcement;
use App\Models\Collection;
use App\Models\GiftingOccasion;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\GoogleSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {

 if (auth('customer')->check()) {

                  $cart = Cart::with([
                'items.product.images',
                'items'
            ])
                ->where('user_id', auth('customer')->id())
                ->first();

        } else {
  $sessionId = session()->getId();
             $cart = Cart::with([
                'items.product.images',
                'items'
            ])
                ->where('session_id', $sessionId)
                ->first();
        }
      

            $count = $cart ? $cart->items->count() : 0;

            $announcements = Announcement::where('status', 1)
                ->latest()
                ->get();

            $collections = Collection::where('status', 1)
                ->orderBy('sort_order')
                ->get();

            $headerOccasions = GiftingOccasion::where('status', 1)
                ->get();

            $menuCategories = Category::whereNull('parent_id')
                ->where('status', 1)
                ->orderBy('sort_order')
                ->get();

            $headerAttributes = Attribute::with('values')
                ->where('show_in_navbar', 1)
                ->where('status', 1)
                ->get();

            $navbarCategories = Category::with([
                'children' => function ($q) {
                    $q->where('status', 1)
                        ->where('show_in_navbar', 1)
                        ->orderBy('sort_order');
                }
            ])
                ->whereNull('parent_id')
                ->where('status', 1)
                ->where('show_in_navbar', 1)
                ->orderBy('sort_order')
                ->get();

            $general = \App\Models\Setting::first();

              $wishlistIds = Wishlist::current()
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->pluck('product_id')
            ->toArray();
            
             $googleSetting = GoogleSetting::current(); // 👈 new
             
            $view->with(
                [
                    'globalCartCount' => $count,
                    'miniCart' => $cart,
                    'announcements' => $announcements,
                    'headerCollections' => $collections,
                    'headerOccasions' => $headerOccasions,
                    'menuCategories' => $menuCategories,
                    'headerAttributes' => $headerAttributes,
                    'navbarCategories' => $navbarCategories,
                    'general' => $general,
                    'wishlistIds' => $wishlistIds,
                     'googleSetting' => $googleSetting, // 👈 new
                ]
            );
        });


        View::composer('*', function ($view) {

            $pages = DynamicPage::where('status', 1)->get();

            $view->with('footerPages', $pages);
        });

        View::composer('*', function ($view) {

            $popularCategories = \App\Models\Category::where('status', 1)
                ->where('is_popular', 1)
                ->whereNull('parent_id')
                ->take(4)->get();

            $view->with(
                'popularCategories',
                $popularCategories
            );

        });


        View::composer('*', function ($view) {

            $wishlistCount = \App\Models\Wishlist::where(
                'session_id',
                session()->getId()
            )->count();
            $view->with(
                'wishlistCount',
                $wishlistCount
            );
        });

        View::composer('*', function ($view) {

            $recentProducts = \App\Models\Product::latest()
                ->where('status', 1)
                ->take(4)
                ->get();


            $view->with(
                'recentProducts',
                $recentProducts
            );

        });

    }
}
