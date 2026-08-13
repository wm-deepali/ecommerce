<?php

use App\Models\SeoPage;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Category;
use App\Models\DynamicPage;
use App\Models\GiftingOccasion;
use App\Models\AttributeValue;

function getSeo()
{
    $route = optional(request()->route())->getName();

    switch ($route) {

        // Collection Page
        case 'collections.listing':
            return Collection::where(
                'slug',
                request()->route('slug')
            )->first();

        // Attribute Page
        case 'attribute.listing':
            return AttributeValue::where(
                'slug',
                request()->route('valueSlug')
            )->first();

        // Blog Detail
        case 'blog.details':
            return Blog::where(
                'slug',
                request()->route('slug')
            )->first();

        // Product Listing Page (Category/Subcategory)
        case 'products.listing':
            return Category::where(
                'slug',
                request()->route('slug')
            )->first();

        // Product Detail Page
        case 'product.details':
            return Product::where(
                'slug',
                request()->route('slug')
            )->first();

        // Occasion Detail Page
        case 'occasions.listing':
            return GiftingOccasion::where(
                'slug',
                request()->route('slug')
            )->first();

        // Dynamic Page
        case 'dynamic.page':
            $slug = request()->route('slug');
            return DynamicPage::get()
            ->first(function ($p) use ($slug) {
                return Str::slug($p->page_name) === $slug;
            });


        default:

            $map = [
                'home' => 'home',
                'categories' => 'categories',
                'occasions' => 'occasions',
                'cart' => 'cart',
                'checkout' => 'checkout',
                'about-us' => 'about',
                'why-us' => 'why_choose_us',
                'contact-us' => 'contact',
                'bulk-enquiry' => 'bulk_enquiry',
                'blogs' => 'blog',
                'faqs' => 'faq',
            ];

            $key = $map[$route] ?? 'home';

            return SeoPage::where('page_key', $key)->first();
    }
}