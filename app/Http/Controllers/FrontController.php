<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactBranch;
use App\Models\ContactEnquiry;
use App\Models\Faq;
use App\Models\GiftingOccasion;
use App\Models\HomeSlider;
use App\Models\HomeTextSlider;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Testimonial;
use App\Models\Team;
use App\Models\GeneralEnquiry;
use App\Models\SupplierEnquiry;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use App\Models\HomeBrandSection;
use App\Models\GalleryImage;
use App\Models\HomeDealBanner;
use App\Models\HomeHeroSlide;
use App\Models\HomeHeroBanner;
use App\Models\HomeWhy;
use App\Models\HomeWhyCard;
use App\Models\HomeFeatureCard;
use App\Models\Collection;
use App\Models\Setting;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CategoryAttribute;
use App\Models\CouponEnquiry;
use App\Models\DynamicPage;
use App\Traits\LogsApiCalls;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    use LogsApiCalls;

    public function home(Request $request)
    {

        $sliders = HomeSlider::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $textSliders = HomeTextSlider::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $featureCards = HomeFeatureCard::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $popularCategories = Category::withCount('children')
            ->whereNull('parent_id')
            ->where('is_popular', 1)
            ->where('status', 1)
            ->take(10)
            ->orderBy('sort_order', 'asc')
            ->get();

        $occasions = GiftingOccasion::where('status', 1)
            ->latest()
            ->get();

        $saleProducts = Product::with(['images'])
            ->where('discount', '>', 0)   // ✅ sirf wahi products jinka discount set hai
            ->visible()
            ->latest()
            ->take(4)
            ->get();

        $newArrivalProducts = Product::whereHas('collections', function ($query) {
            $query->where('code', 'new_arrival');
        })
            ->visible()
            ->latest()
            ->take(4)
            ->get();

        $bestSellers = Product::whereHas('collections', function ($q) {
            $q->where('code', 'best_seller');
        })
            ->visible()
            ->latest()
            ->take(4)
            ->get();

        $premiumCollections = Product::whereHas('collections', function ($q) {
            $q->where('code', 'premium_collection');
        })
            ->visible()
            ->latest()
            ->take(4)
            ->get();

        $exclusiveCollections = Product::whereHas('collections', function ($q) {
            $q->where('code', 'exclusive_collection');
        })
            ->visible()
            ->latest()
            ->take(8)
            ->get();


        $featuredCategories = Category::where('status', 1)
            ->where('is_featured', 1)
            ->take(5)
            ->get()
            ->map(function ($category) {

                // This category could itself be a parent OR a subcategory.
                // Collect: itself + its children (if any) — covers both cases.
                $childIds = $category->children()->pluck('id');
                $allIds = $childIds->push($category->id);

                // Match products where EITHER column points to any of these IDs
                $products = Product::where(function ($q) use ($allIds) {
                    $q->whereIn('category_id', $allIds)
                        ->orWhereIn('subcategory_id', $allIds);
                })
                    ->visible()
                    ->with('images')
                    ->latest()
                    ->take(6) // blade only shows first 6 anyway
                    ->get();

                $prices = $products->pluck('price')->filter();

                $category->setRelation('products', $products); // ✅ overrides the products() relation with our matched set
                $category->min_price = $prices->min();
                $category->max_price = $prices->max();

                return $category;
            });


        $galleryColumn1 = GalleryImage::where('status', 1)
            ->where('column_no', 1)
            ->orderBy('sort_order')
            ->get();

        $galleryColumn2 = GalleryImage::where('status', 1)
            ->where('column_no', 2)
            ->orderBy('sort_order')
            ->get();

        $galleryColumn3 = GalleryImage::where('status', 1)
            ->where('column_no', 3)
            ->orderBy('sort_order')
            ->get();

        $brandSection = HomeBrandSection::with([
            'images' => function ($q) {
                $q->where('status', 1)
                    ->orderBy('sort_order');
            }
        ])
            ->where('status', 1)
            ->first();

        $dealBanners = HomeDealBanner::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $heroSlides = HomeHeroSlide::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $heroBanners = HomeHeroBanner::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $reels = Testimonial::where('status', 1)
            ->where(function ($q) {
                $q->whereNotNull('reel_file')
                    ->orWhereNotNull('reel_url');
            })
            ->latest()
            ->get();

        $testimonials = Testimonial::where('status', 1)
            ->where('type', 'Text')
            ->latest()
            ->get();

        $why = HomeWhy::first();

        $whyCards = HomeWhyCard::orderBy('id')->get();

        $wishlistIds = Wishlist::current()
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->pluck('product_id')
            ->toArray();


        return view('front-pages.home', compact(
            'sliders',
            'textSliders',
            'featureCards',
            'popularCategories',
            'occasions',
            'galleryColumn1',
            'galleryColumn2',
            'galleryColumn3',
            'brandSection',
            'heroSlides',
            'heroBanners',
            'reels',
            'testimonials',
            'dealBanners',
            'saleProducts',
            'newArrivalProducts',
            'bestSellers',
            'premiumCollections',
            'featuredCategories',
            'exclusiveCollections',
            'why',
            'whyCards',
            'wishlistIds'
        ));
    }

       public function searchSuggestions(Request $request)
    {
        $query = trim($request->q);

        if (!$query) {
            return response()->json([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Matching Keywords (admin-entered "Enter Suggestions" tags)
        |--------------------------------------------------------------------------
        | Distinct keyword strings whose text matches the query — shown as
        | tappable suggestion chips. Selecting one re-searches using that
        | exact keyword.
        */
        $keywords = \App\Models\ProductKeyword::where('keyword', 'like', "%{$query}%")
            ->distinct()
            ->orderBy('keyword')
            ->take(8)
            ->pluck('keyword');

        /*
        |--------------------------------------------------------------------------
        | Products — matched either by name OR by an attached keyword tag
        |--------------------------------------------------------------------------
        */
        $products = Product::with('images')
            ->visible()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhereHas('keywords', function ($kq) use ($query) {
                        $kq->where('keyword', 'LIKE', "%{$query}%");
                    });
            })
            ->distinct()
            ->take(6)
            ->get([
                'id',
                'name',
                'slug',
                'price',
                'mrp',
                'discount',
                'discount_type',
            ])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->display_image, // accessor
                    'price' => $product->price,
                    'mrp' => $product->mrp,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                ];
            });

        // Parent Categories
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->where('name', 'LIKE', "%{$query}%")
            ->take(5)
            ->get([
                'id',
                'name',
                'slug',
                'image'
            ]);

        // Sub Categories
        $subCategories = Category::with('parent')
            ->whereNotNull('parent_id')
            ->where('status', 1)
            ->where('name', 'LIKE', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'image' => $item->image,
                    'parent_slug' => $item->parent?->slug,
                ];
            });

        return response()->json([
            'keywords' => $keywords,
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subCategories,
        ]);
    }

    public function categories(Request $request)
    {
        $categories = Category::with([
            'children' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('front-pages.categories', compact('categories'));
    }

    private function scopeByContext($query, string $type, $model)
    {
        switch ($type) {

            case 'category':
                $subIds = $model->children()->pluck('id');
                $query->where(function ($q) use ($model, $subIds) {
                    $q->where('category_id', $model->id)
                        ->orWhereIn('subcategory_id', $subIds);
                });
                break;

            case 'collection':
                $query->whereHas('collections', function ($q) use ($model) {
                    $q->where('collections.id', $model->id);
                });
                break;

            case 'occasion':
                $query->whereHas('occasions', function ($q) use ($model) {
                    $q->where('gifting_occasions.id', $model->id);
                });
                break;


            case 'attribute':
                $query->whereHas('attributeValues', function ($q) use ($model) {
                    $q->where('attribute_value_id', $model->id);
                });
                break;
        }

        return $query;
    }

      public function searchResults(Request $request)
    {
        $query = trim($request->q ?? '');

        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])
            ->visible();

        if ($query !== '') {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('short_description', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%")
                    ->orWhereHas('keywords', function ($kq) use ($query) {
                        $kq->where('keyword', 'LIKE', "%{$query}%");
                    });
            });
        }

        $products = $products->latest()->paginate(12);

        return view('front-pages.products', [
            'category' => null,
            'subcategories' => collect(),
            'categories' => $categories,
            'products' => $products,
            'collections' => $collections,
            'occasions' => $occasions,
            'contextType' => 'search',
            'contextModel' => null,
            'pageTitle' => $query !== '' ? 'Search results for "' . $query . '"' : 'Search results',
            'searchQuery' => $query,
        ]);
    }
    
    public function productListing(Request $request, $slug)
    {
        $category = Category::with(['children', 'categoryAttributes.attribute.values'])
            ->where('slug', $slug)->where('status', 1)->firstOrFail();

        $subcategories = $category->children()->withCount('subCategoryProducts')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        // Check if a subcategory is selected via ?subcategory=slug
        $selectedSubcategory = null;
        if ($request->filled('subcategory')) {
            $selectedSubcategory = $subcategories->firstWhere('slug', $request->subcategory);
        }

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])->visible();

        if ($selectedSubcategory) {
            // Direct subcategory_id match — scopeByContext's 'category' branch
            // checks category_id / subcategory_id-of-children, which is wrong
            // for a leaf subcategory (it has no children of its own).
            $products->where('subcategory_id', $selectedSubcategory->id);
        } else {
            $this->scopeByContext($products, 'category', $category);
        }

        $products = $products->latest()->paginate(12);

        return view('front-pages.products', compact('category', 'subcategories', 'products', 'collections', 'occasions') + [
            'contextType' => 'category',
            'contextModel' => $selectedSubcategory ?: $category,
            'categories' => collect(), // not needed on category page
            'pageTitle' => $selectedSubcategory ? $selectedSubcategory->name : $category->name,
        ]);
    }

    public function collectionListing(Request $request, $slug)
    {
        $collection = Collection::where('slug', $slug)->where('status', 1)->firstOrFail();

        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])->visible();
        $this->scopeByContext($products, 'collection', $collection);
        $products = $products->latest()->paginate(12);

        return view('front-pages.products', [
            'category' => null,
            'subcategories' => collect(),
            'categories' => $categories,
            'products' => $products,
            'collections' => $collections,
            'occasions' => $occasions,
            'contextType' => 'collection',
            'contextModel' => $collection,
            'pageTitle' => $collection->name,
        ]);
    }

    public function occasionListing(Request $request, $slug)
    {
        $occasion = GiftingOccasion::where('slug', $slug)->where('status', 1)->firstOrFail();

        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])->visible();
        $this->scopeByContext($products, 'occasion', $occasion);
        $products = $products->latest()->paginate(12);

        return view('front-pages.products', [
            'category' => null,
            'subcategories' => collect(),
            'categories' => $categories,
            'products' => $products,
            'collections' => $collections,
            'occasions' => $occasions,
            'contextType' => 'occasion',
            'contextModel' => $occasion,
            'pageTitle' => $occasion->title,
        ]);
    }


    public function priceRangeListing(Request $request, $slug)
    {
        $band = collect(config('price_ranges'))->firstWhere('slug', $slug);
        abort_unless($band, 404);

        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])->visible();

        if (!is_null($band['min']))
            $products->where('price', '>=', $band['min']);
        if (!is_null($band['max']))
            $products->where('price', '<=', $band['max']);

        $products = $products->latest()->paginate(12);

        return view('front-pages.products', [
            'category' => null,
            'subcategories' => collect(),
            'categories' => $categories,
            'products' => $products,
            'collections' => $collections,
            'occasions' => $occasions,
            'contextType' => 'price',
            'contextModel' => null,
            'pageTitle' => $band['label'],
            'priceBand' => $band,
        ]);
    }

    public function attributeListing(Request $request, $attributeSlug, $valueSlug)
    {
        $attribute = Attribute::where('slug', $attributeSlug)->firstOrFail();
        $value = AttributeValue::where('attribute_id', $attribute->id)
            ->where('slug', $valueSlug)->firstOrFail();

        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $collections = Collection::where('status', 1)->orderBy('sort_order')->get();
        $occasions = GiftingOccasion::where('status', 1)->get();

        $products = Product::with(['images', 'category', 'subcategory', 'collections', 'occasions'])->visible();
        $this->scopeByContext($products, 'attribute', $value);
        $products = $products->latest()->paginate(12);

        return view('front-pages.products', [
            'category' => null,
            'subcategories' => collect(),
            'categories' => $categories,
            'products' => $products,
            'collections' => $collections,
            'occasions' => $occasions,
            'contextType' => 'attribute',
            'contextModel' => $value,
            'pageTitle' => $attribute->name . ': ' . $value->value,
        ]);
    }

    public function filterProducts(Request $request)
    {
        $products = Product::with([
            'images',
            'category',
            'subcategory',
            'collections',
            'occasions',
            'attributeValues'
        ])->visible();

        // Lock to whatever the page represents
        if ($request->context_type === 'price') {

            // Price-band pages have no Eloquent model to resolve, so the
            // band's min/max are sent up directly from the blade instead
            // of going through scopeByContext().
            if ($request->filled('context_price_min')) {
                $products->where('price', '>=', $request->context_price_min);
            }

            if ($request->filled('context_price_max')) {
                $products->where('price', '<=', $request->context_price_max);
            }

        } elseif ($request->filled('context_type') && $request->filled('context_id')) {

            $model = match ($request->context_type) {
                'category' => Category::find($request->context_id),
                'collection' => Collection::find($request->context_id),
                'occasion' => GiftingOccasion::find($request->context_id),
                'attribute' => AttributeValue::find($request->context_id),
                default => null,
            };

            if ($model) {
                $this->scopeByContext($products, $request->context_type, $model);
            }
        }

        // Used to narrow by category on collection/occasion/attribute/price pages
        if (!empty($request->category_id)) {
            $category = Category::find($request->category_id);
            if ($category) {
                $subIds = $category->children()->pluck('id');
                $products->where(function ($q) use ($category, $subIds) {
                    $q->where('category_id', $category->id)->orWhereIn('subcategory_id', $subIds);
                });
            }
        }

        if (!empty($request->subcategory_id)) {
            $products->where('subcategory_id', $request->subcategory_id);
        }

        if (!empty($request->collections)) {
            $products->whereHas('collections', fn($q) => $q->whereIn('collections.id', $request->collections));
        }

        if (!empty($request->occasions)) {
            $products->whereHas('occasions', fn($q) => $q->whereIn('gifting_occasions.id', $request->occasions));
        }

        if (!empty($request->attribute_values)) {
            $products->whereHas('attributeValues', fn($q) => $q->whereIn('attribute_value_id', $request->attribute_values));
        }

        if (!empty($request->search)) {
            $search = trim($request->search);
            $products->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Generic min/max sliders (only present on non-price pages; on the
        // price page the band bounds above already do the work).
        if (!empty($request->min_price))
            $products->where('price', '>=', $request->min_price);
        if (!empty($request->max_price))
            $products->where('price', '<=', $request->max_price);

        switch ($request->sort_by) {
            case 'price-low':
                $products->orderBy('price', 'asc');
                break;
            case 'price-high':
                $products->orderBy('price', 'desc');
                break;
            case 'oldest':
                $products->oldest();
                break;
            default:
                $products->latest();
                break;
        }

        $products = $products->paginate(12);

        return response()->json([
            'html' => view('front-pages.partials.product-grid', compact('products'))->render(),
            'pagination' => $products->links()->render(),
            'count' => $products->total(),
        ]);
    }

    public function productDetail($slug)
    {
        $product = Product::with([
            'images',
            'category',
            'subcategory',
            'occasions',
            'collections',

            'attributeValues.attribute',
            'attributeValues.value',

            'variants' => function ($q) {
                $q->with([
                    'values.attributeValue.attribute',
                    'images'
                ]);
            },
        ])
            ->where('slug', $slug)
            ->visible()
            ->firstOrFail();

        $newArrivals = Product::with([
            'images',
            'category',
            'subcategory',
            'collections',
            'attributeValues.attribute',
            'attributeValues.value',
        ])
            ->visible()
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        $relatedProducts = Product::with([
            'images',
            'category',
            'subcategory',
            'collections',
            'attributeValues.attribute',
            'attributeValues.value',
        ])
            ->visible()
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {

                $query->where('category_id', $product->category_id);

                if ($product->subcategory_id) {
                    $query->orWhere(
                        'subcategory_id',
                        $product->subcategory_id
                    );
                }
            })
            ->take(4)
            ->get();

        // ── Category-level dependency flags (price/image/stock/sku) ──────────
        // Variant attribute-values only exist per attribute, but whether an
        // attribute *drives* price/image/stock/sku is defined per category
        // via CategoryAttribute, so we need to look it up once and key it
        // by attribute_id for fast lookups below.
        $categoryAttributes = CategoryAttribute::where('category_id', $product->category_id)
            ->get()
            ->keyBy('attribute_id');

        $dependencyFields = ['price', 'image', 'stock', 'sku'];

        $variantAttributes = [];

        foreach ($product->variants as $variant) {

            foreach ($variant->values as $value) {

                $attribute = $value->attributeValue->attribute;
                $attributeId = $attribute->id;
                $attributeValue = $value->attributeValue;

                $categoryAttribute = $categoryAttributes->get($attributeId);

                $variantAttributes[$attributeId]['name'] = $attribute->name;
                $variantAttributes[$attributeId]['type'] = $attribute->type ?? 'button';
                $variantAttributes[$attributeId]['is_selectable'] = $categoryAttribute?->is_selectable ?? true;
                $variantAttributes[$attributeId]['has_variant'] = true;

                $variantAttributes[$attributeId]['values'][$attributeValue->id] = [
                    'value' => $attributeValue->value,
                    'hex_code' => $attributeValue->hex_code,
                    'image' => $attributeValue->image,
                    'slug' => $attributeValue->slug,
                ];

                // First variant wins as the "default" — used when the attribute
                // isn't customer-selectable, so we still have something to
                // pre-select and display.
                if (!isset($variantAttributes[$attributeId]['default_value_id'])) {
                    $variantAttributes[$attributeId]['default_value_id'] = $attributeValue->id;
                }

                foreach ($dependencyFields as $field) {
                    $variantAttributes[$attributeId][$field . '_dependent'] =
                        $categoryAttribute?->{$field . '_dependent'} ?? false;
                }
            }
        }

        // ── Merge in attributes that have NO product variants but still need to
        // participate in the same info/selectable UI, driven by the same
        // CategoryAttribute config (is_selectable/type). These never carry
        // price/image/stock/sku dependency since there's no variant to match
        // against — selecting a value here is purely visual/informational
        // (active state only, no functional effect).
        $nonVariantGrouped = $product->attributeValues
            ->filter(fn($item) => $item->attribute
                && $item->value
                && !isset($variantAttributes[$item->attribute_id]))
            ->groupBy('attribute_id');

        foreach ($nonVariantGrouped as $attributeId => $items) {

            $attribute = $items->first()->attribute;
            $categoryAttribute = $categoryAttributes->get($attributeId);

            $values = [];
            foreach ($items as $item) {
                $values[$item->value->id] = [
                    'value' => $item->value->value,
                    'hex_code' => $item->value->hex_code ?? null,
                    'image' => $item->value->image ?? null,
                    'slug' => $item->value->slug ?? null,
                ];
            }

            $variantAttributes[$attributeId] = [
                'name' => $attribute->name,
                'type' => $attribute->type ?? 'button',
                'is_selectable' => $categoryAttribute?->is_selectable ?? false,
                'has_variant' => false,
                'values' => $values,
                'default_value_id' => $items->first()->value->id,
                'price_dependent' => false,
                'image_dependent' => false,
                'stock_dependent' => false,
                'sku_dependent' => false,
            ];
        }


        // ⬇️ YAHAN ADD KARO
        foreach ($variantAttributes as $attributeId => &$attr) {
            if (isset($attr['values'])) {
                ksort($attr['values']);
            }
        }
        unset($attr);
        // ── variantsByType — the shape the product-detail JS actually reads ──
        // For each dependency type, find which attribute ids are flagged for
        // it in this category, reduce every variant of THAT type down to just
        // those attribute-values, and dedupe. That reduced value-set is what
        // the front-end matches against the currently-selected badges.
        $variantsByType = [];

        foreach ($dependencyFields as $type) {

            $relevantAttributeIds = $categoryAttributes
                ->filter(fn($ca) => $ca->{$type . '_dependent'})
                ->pluck('attribute_id')
                ->values()
                ->toArray();

            if (empty($relevantAttributeIds)) {
                $variantsByType[$type] = [];
                continue;
            }

            $seenCombinations = [];
            $bucket = [];

            // FIX: only look at variant rows that actually belong to this type
// (price/image/stock/sku are separate rows in the same table), AND
// exclude combinations the admin marked "Not offered" — those should
// never reach the frontend matcher, so a missing match correctly
// triggers the diagonal "unavailable" line instead of "Sold Out".
            foreach ($product->variants->where('type', $type)->where('is_available', true) as $variant) {

                $relevantValueIds = $variant->values
                    ->filter(
                        fn($v) => in_array(
                            $v->attributeValue->attribute_id,
                            $relevantAttributeIds
                        )
                    )
                    ->pluck('attribute_value_id')
                    ->sort()
                    ->values()
                    ->toArray();

                if (empty($relevantValueIds)) {
                    continue;
                }

                $key = implode('-', $relevantValueIds);

                if (isset($seenCombinations[$key])) {
                    continue;
                }
                $seenCombinations[$key] = true;

                $bucket[] = [
                    'id' => $variant->id,
                    'values' => $relevantValueIds,
                    'price' => $variant->price,
                    'mrp' => $variant->mrp,
                    'stock' => $variant->stock,
                    'image' => $variant->image,
                    'images' => $variant->images
                        ->sortByDesc('is_default')
                        ->map(fn($img) => [
                            'image' => $img->image,
                            'thumb' => $img->thumb ?? $img->image,
                        ])
                        ->values()
                        ->toArray(),
                    'sku' => $variant->sku,
                ];
            }

            $variantsByType[$type] = $bucket;

        }
        $reviews = $product->approvedReviews()
            ->with(['customer', 'images'])
            ->latest()
            ->paginate(5);

        $avgRating = round($product->approvedReviews()->avg('rating') ?? 0, 1);
        $reviewsCount = $product->approvedReviews()->count();

        $setting = Setting::first();

        $activeCoupons = \App\Models\Coupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->orderByDesc('discount_value')
            ->get(['code', 'discount_type', 'discount_value', 'minimum_order_amount', 'maximum_discount', 'minimum_order_quantity']);

 // Pixel/GA view_item event — rendered as an inline script tag on the product-detail view
        $viewItemScript = \App\Services\Tracking\PixelTracker::viewItemScript($product);
        
        return view('front-pages.product-detail', compact(
            'product',
            'newArrivals',
            'relatedProducts',
            'variantAttributes',
            'variantsByType',
            'reviews',
            'avgRating',
            'reviewsCount',
            'setting',
            'viewItemScript' // 👈 new
        ));
    }

    public function quickView($id)
    {
        $product = Product::with([
            'images',
            'category',
            'subcategory',
            'variants.values.attributeValue.attribute',
        ])
            ->visible()
            ->findOrFail($id);

        $variantAttributes = [];

        foreach ($product->variants as $variant) {
            foreach ($variant->values as $value) {
                $attributeName = $value->attributeValue->attribute->name;
                $attributeId = $value->attributeValue->attribute->id;

                $variantAttributes[$attributeId]['name'] = $attributeName;
                $variantAttributes[$attributeId]['values'][$value->attributeValue->id] = $value->attributeValue->value;
            }
        }

        $variantsJson = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'mrp' => $variant->mrp,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'image' => $variant->image,
                'values' => $variant->values->pluck('attribute_value_id')->values()->toArray(),
            ];
        });

        $images = $product->images->map(fn($image) => asset('storage/' . $image->image))->values();

        if ($images->isEmpty()) {
            $images = collect([$product->display_image]);
        }

        $avgRating = round($product->approvedReviews()->avg('rating') ?? 0, 1);
        $reviewsCount = $product->approvedReviews()->count();

        return response()->json([
            'status' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->subcategory->name ?? $product->category->name,
                'price' => $product->price,
                'mrp' => $product->mrp,
                'min_qty' => $product->min_qty,
                'stock' => $product->stock,
                'url' => route('product.details', $product->slug),
                'images' => $images,
            ],
            'avgRating' => $avgRating,
            'reviewsCount' => $reviewsCount,
            'variantAttributes' => $variantAttributes,
            'variants' => $variantsJson,
        ]);
    }

    public function thankYou($id)
    {
        return view(
            'front-pages.thank-you'
        );
    }

    public function faqs(Request $request)
    {
        $faqs = Faq::where('status', 1)->get();

        return view('front-pages.faqs', compact('faqs'));
    }

    public function blogs(Request $request)
    {
        $blogs = Blog::where('status', 1)
            ->latest()
            ->paginate(6);

        return view('front-pages.blogs', compact('blogs'));
    }

    public function blogDetails(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $latestBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        $searchResults = collect();

        if ($request->filled('search')) {

            $searchResults = Blog::where('status', 1)
                ->where(function ($q) use ($request) {

                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('short_description', 'like', '%' . $request->search . '%')
                        ->orWhere('content', 'like', '%' . $request->search . '%');

                })
                ->latest()
                ->take(10)
                ->get();

        }

        return view(
            'front-pages.blog-details',
            compact(
                'blog',
                'latestBlogs',
                'searchResults'
            )
        );
    }

    public function contactUs()
    {
        $branches = ContactBranch::where('status', 1)->get();

        return view('front-pages.contact-us', compact('branches'));
    }

    public function dynamicPage($slug)
    {
        // match slug with page_name
        $page = DynamicPage::where('status', 1)
            ->get()
            ->first(function ($p) use ($slug) {
                return Str::slug($p->page_name) === $slug;
            });

        if (!$page) {
            abort(404);
        }

        return view(
            'front-pages.dynamic-page'
            ,
            compact('page')
        );
    }

    public function whyUs(Request $request)
    {
        $brands = Brand::where('status', 1)->get();
        return view('front-pages.why-us', compact('brands'));
    }



    public function gallery(Request $request)
    {
        return view('front-pages.gallery');
    }



    public function bulkEnquiry(Request $request)
    {
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();

        return view('front-pages.bulk-enquiry', compact('categories'));
    }

    public function aboutUs(Request $request)
    {
        $teams = Team::where('status', 1)
            ->latest()
            ->get();

        return view('front-pages.about', compact('teams'));
    }



    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],

            'mobile' => [
                'required',
                'digits:10',
                'regex:/^[6-9]\d{9}$/'
            ],

            'company' => [
                'nullable',
                'string',
                'max:100'
            ],

            'inquiry_type' => [
                'required',
                'string'
            ],

            'message' => [
                'required',
                'string',
                'min:10',
                'max:1000'
            ],

            'g-recaptcha-response' => [
                'required'
            ]

        ], [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'name.regex' => 'Name should contain only letters and spaces.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',

            'mobile.required' => 'Mobile number is required.',
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'mobile.regex' => 'Please enter a valid Indian mobile number.',

            'company.max' => 'Company name cannot exceed 100 characters.',

            'inquiry_type.required' => 'Please select an inquiry type.',

            'message.required' => 'Message cannot be empty.',
            'message.min' => 'Message must contain at least 10 characters.',
            'message.max' => 'Message cannot exceed 1000 characters.',

            'g-recaptcha-response.required' => 'Please verify captcha.',
        ]);

        // Verify reCAPTCHA
        $recaptchaStartTime = microtime(true);

        $captchaResponse = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        $this->logApiCall([
            'method' => 'POST',
            'endpoint' => 'https://www.google.com/recaptcha/api/siteverify',
            'service' => 'reCAPTCHA',
            'status_code' => $captchaResponse->status(),
            'response_time_ms' => (int) round((microtime(true) - $recaptchaStartTime) * 1000),
            'request_payload' => [
                // secret key intentionally excluded from the log
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ],
            'response_payload' => $captchaResponse->json(),
        ]);

        if (!($captchaResponse->json()['success'] ?? false)) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'Captcha verification failed. Please try again.'
                ])
                ->withInput();
        }

        // Save enquiry
        ContactEnquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'inquiry_type' => $request->inquiry_type,
            'message' => $request->message,
        ]);

                return back()
            ->with('success', 'Enquiry sent successfully!')
            ->with('fire_lead_event', 'Contact Us Form'); // 👈 new
    }


    public function submitGeneralEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|regex:/^[6-9]\d{9}$/',
            'g-recaptcha-response' => 'required',
        ], [
            'name.required' => 'Please enter your name',
            'company.required' => 'Company name is required',
            'email.email' => 'Enter valid email address',
            'phone.regex' => 'Enter valid 10-digit mobile number',
            'g-recaptcha-response.required' => 'Please verify captcha',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'generalForm') // ✅ IMPORTANT
                ->withInput();
        }

        // CAPTCHA
        $recaptchaStartTime = microtime(true);

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]
        );

        $this->logApiCall([
            'method' => 'POST',
            'endpoint' => 'https://www.google.com/recaptcha/api/siteverify',
            'service' => 'reCAPTCHA',
            'status_code' => $response->status(),
            'response_time_ms' => (int) round((microtime(true) - $recaptchaStartTime) * 1000),
            'request_payload' => [
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ],
            'response_payload' => $response->json(),
        ]);

        if (!($response->json()['success'] ?? false)) {
            return back()
                ->withErrors(['captcha' => 'Captcha verification failed'], 'generalForm')
                ->withInput();
        }

        GeneralEnquiry::create([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'source' => $request->source,
        ]);

        return back()
            ->with('success_general', 'Enquiry submitted successfully!')
            ->with('fire_lead_event', 'General Enquiry Form'); // 👈 new
    }


    public function submitSupplierEnquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'company' => 'required|string|min:2|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'nullable|integer|min:1',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'catalogue' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'g-recaptcha-response' => 'required',
        ], [
            'name.required' => 'Please enter your name',
            'company.required' => 'Company name is required',
            'email.email' => 'Enter valid email address',
            'phone.regex' => 'Enter valid 10-digit mobile number',
            'category_id.required' => 'Please select category',
            'catalogue.mimes' => 'File must be PDF, DOC, JPG or PNG',
            'catalogue.max' => 'File must be under 2MB',
            'g-recaptcha-response.required' => 'Please verify captcha',
        ]);

        // CAPTCHA
        $recaptchaStartTime = microtime(true);

        $captcha = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
            ]
        );

        $this->logApiCall([
            'method' => 'POST',
            'endpoint' => 'https://www.google.com/recaptcha/api/siteverify',
            'service' => 'reCAPTCHA',
            'status_code' => $captcha->status(),
            'response_time_ms' => (int) round((microtime(true) - $recaptchaStartTime) * 1000),
            'request_payload' => [
                'response' => $request->input('g-recaptcha-response'),
            ],
            'response_payload' => $captcha->json(),
        ]);

        if (!$captcha->json('success')) {

            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'Captcha failed'
                ])
                ->withInput();
        }

        // FILE UPLOAD
        $filePath = null;

        if ($request->hasFile('catalogue')) {

            $filePath = $request->file('catalogue')
                ->store('catalogues', 'public');
        }

        SupplierEnquiry::create([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'category_id' => $request->category_id,

            // NEW FORM FIELDS
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,

            // EXISTING
            'description' => $request->description,
            'city' => $request->city,

            'catalogue' => $filePath,
        ]);

               return back()
            ->with('success', 'Bulk enquiry submitted successfully!')
            ->with('fire_lead_event', 'Bulk Enquiry Form'); // 👈 new
    }

    public function occasions(Request $request)
    {
        $occasions = GiftingOccasion::where('status', 1)
            ->latest()
            ->get();

        return view('front-pages.occasions', compact('occasions'));
    }


    public function couponEnquiryStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        CouponEnquiry::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code ?? '+91',
            'whatsapp_optin' => $request->boolean('whatsapp_optin'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thanks! Your 10% off code request has been received.',
        ]);
    }

}