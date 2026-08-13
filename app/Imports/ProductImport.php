<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\Models\GiftingOccasion;
use App\Models\Customization;
use App\Models\ProductInclusion;
use App\Models\ProductImage;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['name'])) {
                continue;
            }

            // Brand
            $brandId = null;

            if (!empty($row['brand'])) {
                $brand = Brand::where(
                    'name',
                    trim($row['brand'])
                )->first();

                $brandId = $brand?->id;
            }

            // Product Create
            $product = Product::create([
                'name' => trim($row['name']),
                'slug' => Str::slug($row['name']),

                'brand_id' => $brandId,

                'sub_title' => $row['sub_title'] ?? null,
                'summary' => $row['summary'] ?? null,

                'video_url' => $row['video_url'] ?? null,

                'sku' => $row['sku'] ?? null,
                'product_code' => $row['product_code'] ?? null,

                'min_qty' => $row['min_qty'] ?? 1,
                'delivery_time' => $row['delivery_time'] ?? null,

                'quality' => !empty($row['quality']) ? 1 : 0,
                'pan_india' => !empty($row['pan_india']) ? 1 : 0,

                'mrp' => $row['mrp'] ?? 0,
                'discount' => $row['discount'] ?? 0,
                'discount_type' => $row['discount_type'] ?? 'amount',
                'price' => $row['price'] ?? 0,

                'featured' => !empty($row['featured']) ? 1 : 0,
                'new_arrival' => !empty($row['new_arrival']) ? 1 : 0,
                'sale' => !empty($row['sale']) ? 1 : 0,
                'best_seller' => !empty($row['best_seller']) ? 1 : 0,

                'ready_to_ship' => !empty($row['ready_to_ship']) ? 1 : 0,
                'bulk_available' => !empty($row['bulk_available']) ? 1 : 0,
                'gift_hamper' => !empty($row['gift_hamper']) ? 1 : 0,

                'is_premium' => !empty($row['is_premium']) ? 1 : 0,
                'is_engraving' => !empty($row['is_engraving']) ? 1 : 0,
                'is_personalized_engraving' => !empty($row['is_personalized_engraving']) ? 1 : 0,

                'show_on_website' => !empty($row['show_on_website']) ? 1 : 0,

                'details' => $row['details'] ?? null,
                'delivery_returns' => $row['delivery_returns'] ?? null,

                'meta_title' => $row['meta_title'] ?? null,
                'meta_description' => $row['meta_description'] ?? null,

                'cart' => !empty($row['cart']) ? 1 : 0,
                'whatsapp' => !empty($row['whatsapp']) ? 1 : 0,
                'call' => !empty($row['call']) ? 1 : 0,

                'status' => $row['status'] ?? 1,

                'sort_order' => $row['sort_order'] ?? 0,
                'added_by' => $row['added_by'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            | Excel Column:
            | categories
            | Example:
            | Corporate Gifts, Electronics
            */

            if (!empty($row['categories'])) {

                $categoryIds = [];

                $categories = explode(
                    ',',
                    $row['categories']
                );

                foreach ($categories as $catName) {

                    $category = Category::where(
                        'name',
                        trim($catName)
                    )->first();

                    if ($category) {
                        $categoryIds[] = $category->id;
                    }
                }

                $product->categories()->sync($categoryIds);
            }

            /*
            |--------------------------------------------------------------------------
            | Sub Categories
            |--------------------------------------------------------------------------
            | Excel Column:
            | sub_categories
            */

            if (!empty($row['sub_categories'])) {

                $subCategoryIds = [];

                $subCategories = explode(
                    ',',
                    $row['sub_categories']
                );

                foreach ($subCategories as $subName) {

                    $sub = Category::where(
                        'name',
                        trim($subName)
                    )->first();

                    if ($sub) {
                        $subCategoryIds[] = $sub->id;
                    }
                }

                $product->subcategories()->sync(
                    $subCategoryIds
                );
            }

            // OCCASIONS
            if (!empty($row['occasions'])) {

                $occasionIds = [];

                foreach (explode(',', $row['occasions']) as $occasionName) {

                    $occasion = GiftingOccasion::where(
                        'title',
                        trim($occasionName)
                    )->first();

                    if ($occasion) {
                        $occasionIds[] = $occasion->id;
                    }
                }

                $product->occasions()->sync($occasionIds);
            }

            if (!empty($row['customizations'])) {

                $customizationIds = [];

                foreach (explode(',', $row['customizations']) as $customizationName) {

                    $customization = Customization::where(
                        'name',
                        trim($customizationName)
                    )->first();

                    if ($customization) {
                        $customizationIds[] = $customization->id;
                    }
                }

                $product->customizations()->sync($customizationIds);
            }

            // CUSTOMIZATIONS
            if (!empty($row['customizations'])) {

                $customizationIds = [];

                foreach (explode(',', $row['customizations']) as $customizationName) {

                    $customization = Customization::where(
                        'name',
                        trim($customizationName)
                    )->first();

                    if ($customization) {
                        $customizationIds[] = $customization->id;
                    }
                }

                $product->customizations()->sync($customizationIds);
            }

            // INCLUSIONS
            if (!empty($row['inclusions'])) {

                foreach (explode(',', $row['inclusions']) as $inc) {

                    ProductInclusion::create([
                        'product_id' => $product->id,
                        'title' => trim($inc)
                    ]);
                }
            }

            if (!empty($row['image_name'])) {

                $imagePath = 'products/' . trim($row['image_name']);

                if (storage_path('app/public/' . $imagePath)) {

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                        'is_default' => 1
                    ]);
                }
            }
        }
    }
}