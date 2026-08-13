<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\GiftingOccasion;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\ProductAddon;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\ProductVariantImage;
use App\Models\Collection;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ProductController extends Controller
{
    /**
     * The four independent variant "types". Each is generated from a
     * different subset of category attributes (whichever attributes have
     * the matching *_dependent flag turned on), and stored as its own
     * set of ProductVariant rows tagged with this type.
     */
    protected const VARIANT_TYPES = ['price', 'image', 'stock', 'sku'];

    /**
     * ✅ Compress & store an uploaded image as WebP — generates BOTH a
     * full-size version (for detail/gallery views) and a thumb version
     * (for grid cards / listing pages), so listing pages don't have to
     * download the full 1200px image just to shrink it via CSS.
     *
     * Returns ['full' => path, 'thumb' => path] — both already stored
     * on the public disk.
     *
     * The largest real-world display is the product detail gallery
     * (main image column), so 1200px covers that with a retina buffer.
     * The thumb (400px) covers grid cards / listing thumbnails.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1200,
        int $thumbWidth = 400,
        int $quality = 80
    ): array {
        $manager = ImageManager::usingDriver(Driver::class);

        $uuid = Str::uuid();
        $folder = trim($folder, '/');

        // ---- Full size ----
        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encodedFull = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $fullFilename = $uuid . '.webp';
        $fullPath = $folder . '/' . $fullFilename;

        Storage::disk('public')->put($fullPath, (string) $encodedFull);

        // ---- Thumb size (decode fresh so we don't compound scaling on
        // the already-downscaled $image instance) ----
        $thumbImage = $manager->decode($file);

        if ($thumbImage->width() > $thumbWidth) {
            $thumbImage->scale(width: $thumbWidth);
        }

        $encodedThumb = $thumbImage->encodeUsingFormat(Format::WEBP, quality: $quality);

        $thumbFilename = $uuid . '_thumb.webp';
        $thumbPath = $folder . '/' . $thumbFilename;

        Storage::disk('public')->put($thumbPath, (string) $encodedThumb);

        return [
            'full' => $fullPath,
            'thumb' => $thumbPath,
        ];
    }

    public function index(Request $request)
    {
        $query = Product::with('images');

        // Categories dropdown
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // Subcategories dropdown
        $subCategories = collect();

        if ($request->filled('category_id')) {
            $subCategories = Category::where('parent_id', $request->category_id)
                ->orderBy('name')
                ->get();
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sub Category Filter
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = [
            'id',
            'name',
            'price',
            'status'
        ];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query
            ->paginate(10)
            ->appends($request->all());

        return view('admin.products.index', compact(
            'products',
            'categories',
            'subCategories'
        ));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $occasions = GiftingOccasion::where('status', 1)->get();

        $collections = Collection::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'occasions',
            'collections'
        ));

    }

    public function subcategories(Category $category)
    {
        return response()->json(

            Category::where('parent_id', $category->id)
                ->where('status', 1)
                ->orderBy('name')
                ->get([
                    'id',
                    'name'
                ])

        );
    }

    public function categoryAttributes(Category $category)
    {
        $attributes = CategoryAttribute::with([
            'attribute.values'
        ])
            ->where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json($attributes);
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'mrp' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percentage',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_qty' => 'nullable|integer|min:1',
            'sku' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048',

            // ✅ new: videos + addon options
            'videos.*' => 'nullable|mimes:mp4,webm,mov,avi|max:20480',
            'addons.*.detail' => 'nullable|string|max:255',
            'addons.*.price' => 'nullable|numeric|min:0',

            // ✅ new: multiple images per image-type variant
            'variants_image.*.images.*' => 'nullable|image|max:2048',
        ]);


        DB::beginTransaction();

        try {

            $product = Product::create([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'name' => $request->name,
                'slug' => $request->slug
                    ? $this->generateUniqueSlug($request->slug)
                    : $this->generateUniqueSlug($request->name),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'delivery_returns' => $request->delivery_returns,
                'fabric_care' => $request->fabric_care,

                // ✅ new Content-tab fields
                'shipping_delivery' => $request->shipping_delivery,
                'exchange_policy' => $request->exchange_policy,
                'customization_assistance' => $request->customization_assistance,

                // ✅ blank MRP/Discount/Price never get inserted as '' into decimal columns
                'mrp' => $request->mrp !== null && $request->mrp !== '' ? $request->mrp : 0,
                'discount_type' => $request->discount_type ?: 'amount',
                'discount' => $request->discount !== null && $request->discount !== '' ? $request->discount : 0,
                'price' => $request->price !== null && $request->price !== '' ? $request->price : ($request->mrp ?: 0),

                'sku' => $request->sku,
                'stock' => $request->stock !== null && $request->stock !== '' ? $request->stock : 0,
                'min_qty' => $request->min_qty !== null && $request->min_qty !== '' ? $request->min_qty : 1,
                'product_code' => $request->product_code,
                'delivery_time' => $request->delivery_time,

                'quality' => $request->has('quality'),
                'pan_india' => $request->has('pan_india'),

                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,

                'status' => $request->status,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $index => $image) {

                    $paths = $this->compressAndStore(
                        $image,
                        'products'
                    );

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $paths['full'],
                        'thumb' => $paths['thumb'],
                        'is_default' => $request->default_image == $index ? 1 : 0,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Product Videos
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('videos')) {

                foreach ($request->file('videos') as $video) {

                    $path = $video->store(
                        'product-videos',
                        'public'
                    );

                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $path,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Addon Options
            |--------------------------------------------------------------------------
            */

            if ($request->filled('addons')) {

                foreach ($request->addons as $addon) {

                    if (empty($addon['detail'])) {
                        continue;
                    }

                    ProductAddon::create([
                        'product_id' => $product->id,
                        'detail' => $addon['detail'],
                        'price' => $addon['price'] !== null && $addon['price'] !== '' ? $addon['price'] : 0,
                    ]);
                }
            }


            if ($request->filled('suggestions')) {
                foreach ($request->suggestions as $keyword) {
                    $keyword = trim($keyword);
                    if ($keyword !== '') {
                        $product->keywords()->create(['keyword' => $keyword]);
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Product Attributes
            |--------------------------------------------------------------------------
            */

            if ($request->filled('attribute_values')) {

                foreach ($request->attribute_values as $attributeId => $values) {

                    foreach ($values as $valueId) {

                        ProductAttributeValue::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Variants — one independent combination set per type
            |--------------------------------------------------------------------------
            | The form submits up to 4 separate arrays: variants_price,
            | variants_image, variants_stock, variants_sku. Each is a plain
            | numeric array of combinations for that type only (built in the
            | browser from whichever attributes carry that *_dependent flag).
            */

            foreach (self::VARIANT_TYPES as $type) {
                $this->createVariantsForType($request, $product, $type);
            }

            /*
            |--------------------------------------------------------------------------
            | Occasions
            |--------------------------------------------------------------------------
            */

            if ($request->filled('occasions')) {

                $product->occasions()->sync(
                    $request->occasions
                );
            }

            if ($request->filled('collections')) {

                $product->collections()->sync(
                    $request->collections
                );

            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with(
                    'success',
                    'Product created successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            dd(
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function edit(Product $product)
    {
        $product->load([

            'images',
            'videos',
            'addons',

            'attributeValues.attribute',
            'attributeValues.value',

            'variants.values.attributeValue',
            'variants.images',

            'occasions',

        ]);

        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $subcategories = Category::where(
            'parent_id',
            $product->category_id
        )
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $occasions = GiftingOccasion::where('status', 1)->get();
        $attributes = CategoryAttribute::with([
            'attribute.values'
        ])
            ->where('category_id', $product->category_id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $selectedAttributeValues = $product
            ->attributeValues
            ->pluck('attribute_value_id')
            ->toArray();

        $selectedOccasions = $product
            ->occasions
            ->pluck('id')
            ->toArray();

        // ✅ Existing variants grouped by type, so the edit form can
        // rebuild each of the (up to) 4 independent tables separately.
        $existingVariantsByType = [];

        foreach (self::VARIANT_TYPES as $type) {

            $existingVariantsByType[$type] = $product->variants
                ->where('type', $type)
                ->map(function ($variant) {

                    return [

                        'id' => $variant->id,

                        'sku' => $variant->sku,

                        'mrp' => $variant->mrp,

                        'discount_type' => $variant->discount_type,

                        'discount' => $variant->discount,

                        'price' => $variant->price,

                        'stock' => $variant->stock,

                        'image' => $variant->image,

                        // ✅ so the edit form can pre-check "Not offered" and grey out
                        // the row on initial render, not just after a manual toggle
                        'is_available' => (bool) $variant->is_available,

                        'images' => $variant->images->map(function ($img) {
                            return [
                                'id' => $img->id,
                                'image' => $img->image,
                                'thumb' => $img->thumb,
                                'is_default' => $img->is_default,
                            ];
                        })->values(),

                        'variant_name' => $variant->values
                            ->map(function ($v) {
                                return $v->attributeValue->value;
                            })
                            ->implode(' / '),

                        'attribute_value_ids' => $variant->values
                            ->pluck('attribute_value_id')
                            ->toArray(),

                    ];

                })
                ->values();
        }

        $collections = Collection::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $existingKeywords = $product->keywords->pluck('keyword')->toArray();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'attributes',
                'selectedAttributeValues',
                'selectedOccasions',
                'occasions',
                'existingVariantsByType',
                'collections',
                'existingKeywords'
            )
        );
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'mrp' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percentage',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_qty' => 'nullable|integer|min:1',
            'sku' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048',

            // ✅ new: videos + addon options
            'videos.*' => 'nullable|mimes:mp4,webm,mov,avi|max:20480',
            'addons.*.detail' => 'nullable|string|max:255',
            'addons.*.price' => 'nullable|numeric|min:0',

            // ✅ new: multiple images per image-type variant + per-image delete
            'variants_image.*.images.*' => 'nullable|image|max:2048',
            'delete_variant_images.*' => 'nullable|integer',
        ]);
        DB::beginTransaction();

        try {

            $product->update([

                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,

                'name' => $request->name,
                'slug' => $this->resolveSlugOnUpdate($product, $request->slug, $request->name),

                'short_description' => $request->short_description,
                'description' => $request->description,
                'delivery_returns' => $request->delivery_returns,
                'fabric_care' => $request->fabric_care,

                // ✅ new Content-tab fields
                'shipping_delivery' => $request->shipping_delivery,
                'exchange_policy' => $request->exchange_policy,
                'customization_assistance' => $request->customization_assistance,

                // ✅ blank MRP/Discount/Price never get written as '' into decimal columns
                'mrp' => $request->mrp !== null && $request->mrp !== '' ? $request->mrp : 0,
                'discount_type' => $request->discount_type ?: 'amount',
                'discount' => $request->discount !== null && $request->discount !== '' ? $request->discount : 0,
                'price' => $request->price !== null && $request->price !== '' ? $request->price : ($request->mrp ?: 0),

                'sku' => $request->sku,
                'stock' => $request->stock !== null && $request->stock !== '' ? $request->stock : 0,
                'min_qty' => $request->min_qty !== null && $request->min_qty !== '' ? $request->min_qty : 1,
                'product_code' => $request->product_code,
                'delivery_time' => $request->delivery_time,

                'quality' => $request->has('quality'),
                'pan_india' => $request->has('pan_india'),

                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,

                'status' => $request->status,
            ]);


            // ✅ ADD NEW IMAGES (OLD DELETE NAHI KAR RAHE - SAFE APPROACH)
            $defaultType = $request->default_type;

            // RESET ALL DEFAULTS
            $product->images()->update(['is_default' => 0]);

            // ✅ EXISTING DEFAULT
            if ($defaultType && str_starts_with($defaultType, 'old_')) {

                $id = str_replace('old_', '', $defaultType);

                ProductImage::where('id', $id)
                    ->where('product_id', $product->id)
                    ->update(['is_default' => 1]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $img) {

                    $paths = $this->compressAndStore(
                        $img,
                        'products'
                    );

                    $isDefault = 0;

                    if ($defaultType === "new_" . $index) {
                        $isDefault = 1;
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $paths['full'],
                        'thumb' => $paths['thumb'],
                        'is_default' => $isDefault
                    ]);
                }
            }

            // DELETE SELECTED IMAGES
            if ($request->delete_images) {
                foreach ($request->delete_images as $imgId) {

                    $img = ProductImage::find($imgId);

                    if ($img) {
                        if (Storage::disk('public')->exists($img->image)) {
                            Storage::disk('public')->delete($img->image);
                        }
                        if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                            Storage::disk('public')->delete($img->thumb);
                        }
                        $img->delete();
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Product Videos (ADD NEW, KEEP OLD — same safe approach as images)
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {

                    $path = $video->store('product-videos', 'public');

                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $path,
                    ]);
                }
            }

            // DELETE SELECTED VIDEOS
            if ($request->delete_videos) {
                foreach ($request->delete_videos as $videoId) {

                    $vid = ProductVideo::find($videoId);

                    if ($vid) {
                        if (Storage::disk('public')->exists($vid->video)) {
                            Storage::disk('public')->delete($vid->video);
                        }
                        $vid->delete();
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Delete individually-removed variant images
            |--------------------------------------------------------------------------
            | Distinct from full variant deletion (handled in syncVariantsForType) —
            | this is for when the admin removes ONE image from a variant that
            | still keeps its other images / stays selected.
            */

            if ($request->filled('delete_variant_images')) {
                foreach ($request->delete_variant_images as $imgId) {

                    $img = ProductVariantImage::find($imgId);

                    if ($img) {
                        if (Storage::disk('public')->exists($img->image)) {
                            Storage::disk('public')->delete($img->image);
                        }
                        if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                            Storage::disk('public')->delete($img->thumb);
                        }
                        $img->delete();
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Addon Options (SYNC — replace the full set each save, since rows
            | have no stable identity of their own beyond detail/price)
            |--------------------------------------------------------------------------
            */

            $product->addons()->delete();

            if ($request->filled('addons')) {

                foreach ($request->addons as $addon) {

                    if (empty($addon['detail'])) {
                        continue;
                    }

                    ProductAddon::create([
                        'product_id' => $product->id,
                        'detail' => $addon['detail'],
                        'price' => $addon['price'] !== null && $addon['price'] !== '' ? $addon['price'] : 0,
                    ]);
                }
            }

            $product->keywords()->delete();

            if ($request->filled('suggestions')) {
                foreach ($request->suggestions as $keyword) {
                    $keyword = trim($keyword);
                    if ($keyword !== '') {
                        $product->keywords()->create(['keyword' => $keyword]);
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Product Attributes (SYNC)
            |--------------------------------------------------------------------------
            */

            $currentAttributes = ProductAttributeValue::where(
                'product_id',
                $product->id
            )->get();

            $currentKeys = $currentAttributes
                ->map(function ($row) {
                    return $row->attribute_id . '-' . $row->attribute_value_id;
                })
                ->toArray();

            $newKeys = [];

            foreach ($request->attribute_values ?? [] as $attributeId => $values) {

                foreach ($values as $valueId) {

                    $newKeys[] = $attributeId . '-' . $valueId;

                    ProductAttributeValue::firstOrCreate([
                        'product_id' => $product->id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $valueId,
                    ]);
                }
            }

            foreach ($currentAttributes as $row) {

                $key = $row->attribute_id . '-' . $row->attribute_value_id;

                if (!in_array($key, $newKeys)) {

                    $row->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Variants — sync each type independently
            |--------------------------------------------------------------------------
            */

            foreach (self::VARIANT_TYPES as $type) {
                $this->syncVariantsForType($request, $product, $type);
            }

            /*
            |--------------------------------------------------------------------------
            | Occasions
            |--------------------------------------------------------------------------
            */

            $product->occasions()->sync(
                $request->occasions ?? []
            );

            $product->collections()->sync(
                $request->collections ?? []
            );

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with(
                    'success',
                    'Product updated successfully.'
                );

        } catch (\Exception $e) {


            DB::rollBack();

            dd(
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Variant helpers (type-aware)
    |--------------------------------------------------------------------------
    | The request carries up to 4 arrays: variants_price, variants_image,
    | variants_stock, variants_sku — each a plain (non-associative) list of
    | combinations belonging ONLY to that dependency type. Every combination
    | entry looks like:
    |   [ 'id' => (existing variant id, edit only), 'values' => [attrValueId, ...], ...type-specific fields ]
    */

    protected function inputKeyForType(string $type): string
    {
        return 'variants_' . $type;
    }

    protected function fillVariantFieldsForType(ProductVariant $variant, string $type, array $data, Request $request, int $index): void
    {
        // ✅ applies to every type — checked "Not offered" in the form means
        // is_available = false; unchecked (or absent) means true. This is what
        // the storefront's stock-matching query filters on.
        $variant->is_available = !isset($data['excluded']);

        switch ($type) {

            case ProductVariant::TYPE_PRICE:
                $variant->fill([
                    'mrp' => $data['mrp'] ?? 0,
                    'discount_type' => $data['discount_type'] ?? 'amount',
                    'discount' => $data['discount'] ?? 0,
                    'price' => $data['price'] ?? 0,
                ]);
                break;

            case ProductVariant::TYPE_STOCK:
                $variant->fill([
                    'stock' => $data['stock'] ?? 0,
                ]);
                break;

            case ProductVariant::TYPE_SKU:
                $variant->fill([
                    'sku' => $data['sku'] ?? null,
                ]);
                break;

            case ProductVariant::TYPE_IMAGE:
                // Multiple images per variant are handled AFTER save() in
                // createVariantsForType() / syncVariantsForType(), since
                // ProductVariantImage rows need a real variant_id to attach to.
                break;
        }
    }

    /**
     * Stores newly-uploaded images for an image-type variant. Existing
     * ProductVariantImage rows are left untouched (same "add new, keep old"
     * pattern used for product-level images/videos) unless the admin
     * explicitly marks one for deletion via delete_variant_images[].
     */
    protected function storeVariantImages(Request $request, ProductVariant $variant, int $index): void
    {
        $files = $request->file("variants_image.$index.images") ?? [];

        if (!is_array($files)) {
            $files = [$files];
        }

        $hasExisting = $variant->images()->exists();

        foreach ($files as $i => $file) {

            if (!$file instanceof UploadedFile) {
                continue;
            }

            $paths = $this->compressAndStore(
                $file,
                'product-variants'
            );

            ProductVariantImage::create([
                'variant_id' => $variant->id,
                'image' => $paths['full'],
                'thumb' => $paths['thumb'],
                // First image becomes default only if this variant had none before.
                'is_default' => (!$hasExisting && $i === 0) ? 1 : 0,
            ]);
        }

        // Keep the legacy single `image` column in sync as "the default
        // image for this variant" — some older frontend code may still
        // read $variant->image directly.
        $default = $variant->images()->where('is_default', 1)->first()
            ?? $variant->images()->first();

        if ($default) {
            $variant->image = $default->image;
            $variant->save();
        }
    }

    /**
     * Create-only path (used by store()) — no existing rows to reconcile.
     */
    protected function createVariantsForType(Request $request, Product $product, string $type): void
    {
        $inputKey = $this->inputKeyForType($type);

        if (!$request->filled($inputKey)) {
            return;
        }

        foreach ($request->$inputKey as $index => $data) {

            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->type = $type;

            $this->fillVariantFieldsForType($variant, $type, $data, $request, $index);

            $variant->save();

            foreach ($data['values'] ?? [] as $valueId) {
                ProductVariantValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
            }

            if ($type === ProductVariant::TYPE_IMAGE) {
                $this->storeVariantImages($request, $variant, $index);
            }
        }
    }

    /**
     * Create/update/delete path (used by update()) — reconciles submitted
     * combinations for this type against what already exists in the DB,
     * scoped to this type only so other types are left untouched.
     */
    protected function syncVariantsForType(Request $request, Product $product, string $type): void
    {
        $inputKey = $this->inputKeyForType($type);

        $existingIds = [];

        foreach ($request->$inputKey ?? [] as $index => $data) {

            if (!empty($data['id'])) {

                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('type', $type)
                    ->where('id', $data['id'])
                    ->first();

                if (!$variant) {
                    continue;
                }

                $existingIds[] = $variant->id;

            } else {

                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->type = $type;
            }

            $this->fillVariantFieldsForType($variant, $type, $data, $request, $index);

            $variant->save();

            if ($type === ProductVariant::TYPE_IMAGE) {
                $this->storeVariantImages($request, $variant, $index);
            }

            if (empty($data['id'])) {

                $existingIds[] = $variant->id;

                foreach ($data['values'] ?? [] as $valueId) {
                    ProductVariantValue::create([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $valueId,
                    ]);
                }

            } else {

                // Re-sync value pivots for existing combinations in case
                // the admin regenerated the table with different values.
                ProductVariantValue::where('variant_id', $variant->id)->delete();

                foreach ($data['values'] ?? [] as $valueId) {
                    ProductVariantValue::create([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $valueId,
                    ]);
                }
            }
        }

        // Delete variants of this type that were removed on the form.
        $toDelete = ProductVariant::where('product_id', $product->id)
            ->where('type', $type);

        if (!empty($existingIds)) {
            $toDelete->whereNotIn('id', $existingIds);
        }

        $toDelete = $toDelete->get();

        foreach ($toDelete as $variant) {

            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }

            // ✅ delete all of this variant's images too
            foreach ($variant->images as $img) {
                if (Storage::disk('public')->exists($img->image)) {
                    Storage::disk('public')->delete($img->image);
                }
                if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                    Storage::disk('public')->delete($img->thumb);
                }
                $img->delete();
            }

            ProductVariantValue::where('variant_id', $variant->id)->delete();

            $variant->delete();
        }
    }


    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, function ($q) use ($ignoreId) {
                    $q->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function resolveSlugOnUpdate(Product $product, ?string $requestedSlug, string $name): string
    {
        $source = $requestedSlug ?: $name;
        $candidateSlug = Str::slug($source);

        // If the slug would be the same as what's already saved, don't touch it.
        if ($candidateSlug === $product->slug) {
            return $product->slug;
        }

        // Only regenerate + check uniqueness if it actually changed.
        return $this->generateUniqueSlug($source, $product->id);
    }

    public function suggestionKeywords(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return response()->json([]);
        }

        $keywords = \App\Models\ProductKeyword::where('keyword', 'like', "%{$query}%")
            ->distinct()
            ->orderBy('keyword')
            ->limit(15)
            ->pluck('keyword');

        return response()->json($keywords);
    }

}