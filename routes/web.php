<?php

use App\Http\Controllers\Admin\{
    AdminSettingController,
    AnnouncementController,
    AttributeController,
    AttributeValueController,
    AwardController,
    BlogController,
    CategoryAttributeController,
    CategoryController,
    ClientController,
    CollectionController,
    ContactBranchController,
    ContactEnquiryController,
    CouponController,
    CustomerAddressController,
    CustomerController,
    CustomizationController,
    DashboardController,
    DynamicPageController,
    FaqController,
    GalleryImageController,
    GiftingOccasionController,
    HomeBrandSectionController,
    HomeBrandSectionImageController,
    HomeDealBannerController,
    HomeFeatureCardController,
    HomeHeroBannerController,
    HomeHeroSlideController,
    HomePageController,
    HomeSliderController,
    HomeTextSliderController,
    HomeWhyController,
    LogoutController,
    OrderController,
    OtherEnquiryController,
    PaymentController,
    ProductController,
    ProfileSettingController,
    ReturnReasonController,
    SeoController,
    StoredCartController,
    SupplierEnquiryController,
    TeamController,
    TestimonialController,
    VendorTypeController,
    OrderReturnController,
    RefundController,
    StockManagementController,
    StockAlertsController,
    SalesReportController,
    ProductReportController,
    CustomerReportController,
    EmailTemplateController,
    CouponEnquiryController,
    CustomerWishlistController,
    NotificationController,
    OrderReportController,
    CouponReportController,
    TaxReportController,
    SystemLogController,
    RedirectController

};

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Frontend\Auth\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\ProductReviewController;


Route::middleware('maintenance.mode')->group(function () {


    Route::controller(FrontController::class)->group(function () {

        Route::get('/', 'home')->name('home');
        Route::get('/search-suggestions', 'searchSuggestions')->name('search.suggestions');
        Route::get('/occasions', 'occasions')->name('occasions');
        Route::get('/categories', 'categories')->name('categories');

         Route::get('/search', 'searchResults')->name('search');
         
        // Category-based listing (unchanged)
        Route::get('/products/{slug}', 'productListing')->name('products.listing');

        // Collection-based listing (new)
        Route::get('/collections/{slug}', 'collectionListing')->name('collections.listing');

        // Occasion-based listing (new, same pattern)
        Route::get('/occasions/{slug}', 'occasionListing')->name('occasions.listing');

        Route::get('/price/{slug}', 'priceRangeListing')->name('price.listing');

        // Attribute-value based listing (new) e.g. /attribute/fabric/cotton
        Route::get('/attribute/{attributeSlug}/{valueSlug}', 'attributeListing')->name('attribute.listing');

        // One shared AJAX endpoint used by all four pages above
        Route::post('/products/filter', 'filterProducts')->name('products.filter');


        Route::get('/product/{slug}', 'productDetail')->name('product.details');
        Route::get('/product/quick-view/{id}', 'quickView')->name('product.quickview');

        Route::get('/about-us', 'aboutUs')->name('about-us');
        Route::get('/blogs', 'blogs')->name('blogs');
        Route::get('/blog/{slug}', 'blogDetails')->name('blog.details');
        Route::get('/bulk-enquiry', 'bulkEnquiry')->name('bulk-enquiry');
        Route::get('/contact-us', 'contactUs')->name('contact-us');
        Route::get('/faqs', 'faqs')->name('faqs');
        Route::get('/page/{slug}', 'dynamicPage')->name('dynamic.page');
        Route::get('/thank-you/{id}', 'thankYou')->name('thank-you');
        Route::get('/why-us', 'whyUs')->name('why-us');

        Route::post('/contact-submit', 'submitContact')->name('contact.submit');
        Route::post('/supplier-enquiry-submit', 'submitSupplierEnquiry')->name('supplier.enquiry.submit');
        Route::post('/general-enquiry', 'submitGeneralEnquiry')->name('general.enquiry');
        Route::post('/coupon-enquiry', 'couponEnquiryStore')->name('coupon-enquiry.store');

        Route::prefix('wishlist')->name('wishlist.')->group(function () {

            Route::get('/', [WishlistController::class, 'index'])->name('index')->middleware('customer');
            Route::post('/add', [WishlistController::class, 'add'])->name('add');
            Route::delete('/{product}', [WishlistController::class, 'remove'])->name('remove');
            Route::post('/{product}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('moveToCart');

        });

        // cart routes
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'cart'])->name('cart');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
        Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply.coupon');
        Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove.coupon');

        Route::middleware('customer')->group(function () {

            Route::get('/checkout', [CheckoutController::class, 'checkout'])
                ->name('checkout');

            Route::post('/address/store', [CheckoutController::class, 'storeAddress'])->name('address.store');

            Route::post('/checkout/change-default-address', [CheckoutController::class, 'changeDefaultAddress'])
                ->name('checkout.change-default-address');

            Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
                ->name('checkout.place-order');

            Route::post('/payment/razorpay/success', [CheckoutController::class, 'razorpaySuccess'])
                ->name('checkout.razorpay.success');

            Route::get('/order-success/{order}', [CheckoutController::class, 'orderSuccess'])
                ->name('order.success');

        });


    });

    Route::get('/colour-chart', function () {
        return view('front-pages.colour-chart');
    })->name('colour.chart');

    Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])
        ->name('google.login');

    Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback']);

    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/register', [CustomerAuthController::class, 'registerForm'])->name('register');
        Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.store');
        Route::get('/login', [CustomerAuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.store');

        Route::middleware('customer')->group(function () {

            Route::view('/dashboard', 'user.dashboard')->name('dashboard.index');
            Route::get('orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{order}', [App\Http\Controllers\User\OrderController::class, 'show'])->name('orders.show');
            Route::get('orders/{order}/invoice', [App\Http\Controllers\User\OrderController::class, 'invoice'])->name('orders.invoice');
            Route::post('orders/return', [App\Http\Controllers\User\OrderController::class, 'submitReturn'])->name('orders.return');
            Route::get('orders/{order}/reorder', [App\Http\Controllers\User\OrderController::class, 'reorder'])->name('orders.reorder');

            // Addresses
            Route::get('addresses', [App\Http\Controllers\User\AddressController::class, 'index'])->name('address.index');
            Route::post('addresses', [App\Http\Controllers\User\AddressController::class, 'store'])->name('address.store');
            Route::get('addresses/{address}/edit', [App\Http\Controllers\User\AddressController::class, 'edit'])->name('address.edit');
            Route::put('addresses/{address}', [App\Http\Controllers\User\AddressController::class, 'update'])->name('address.update');
            Route::delete('addresses/{address}', [App\Http\Controllers\User\AddressController::class, 'destroy'])->name('address.destroy');
            Route::patch('addresses/{address}/default', [App\Http\Controllers\User\AddressController::class, 'setDefault'])->name('address.default');
            Route::get('addresses/cities', [App\Http\Controllers\User\AddressController::class, 'cities'])->name('address.cities');

            Route::get('/account-details', [AccountController::class, 'index'])->name('account.details');
            Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
            Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('password.update');
            Route::delete('/account', [AccountController::class, 'deleteAccount'])->name('account.delete');

            Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications');
            Route::post('/notifications/read-all', [App\Http\Controllers\User\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
            Route::post('/notifications/{notification}/read', [App\Http\Controllers\User\NotificationController::class, 'markRead'])->name('notifications.read');

            Route::post('/reviews/store', [ProductReviewController::class, 'store'])->name('reviews.store');
            Route::delete('/reviews/{review}', [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

            Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

        });

    });


});



// Admin Routes list
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/get-cities', [AdminSettingController::class, 'getCities'])->name('get-cities');



Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'admin.timeout'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/profile-setting', ProfileSettingController::class);
        Route::post('/resetpassword', [ProfileSettingController::class, 'resetPassword'])->name('reset.password');

        // category routes
        Route::get('categories/import', [CategoryController::class, 'import'])->name('categories.import');
        Route::post('categories/import', [CategoryController::class, 'importStore'])->name('categories.import.store');
        Route::get('categories/import/sample', [CategoryController::class, 'downloadSample'])->name('categories.import.sample');
        Route::post('categories/upload-images', [CategoryController::class, 'uploadImagesZip'])->name('categories.images.upload');
        Route::get('categories/import/parent-reference', [CategoryController::class, 'downloadParentCategoryReference'])->name('categories.parent.reference');
        Route::resource('categories', CategoryController::class);

        // occasion routes
        Route::get('gifting-occasions/import', [GiftingOccasionController::class, 'import'])->name('gifting-occasions.import');
        Route::post('gifting-occasions/import', [GiftingOccasionController::class, 'importStore'])->name('gifting-occasions.import.store');
        Route::get('gifting-occasions/import/sample', [GiftingOccasionController::class, 'downloadSample'])->name('gifting-occasions.import.sample');
        Route::post('gifting-occasions/upload-images', [GiftingOccasionController::class, 'uploadImagesZip'])->name('gifting-occasions.images.upload');
        Route::resource('gifting-occasions', GiftingOccasionController::class);

        // product routes
        Route::get('/products/suggestion-keywords', [ProductController::class, 'suggestionKeywords'])->name('products.suggestion-keywords');
        Route::view('/products/media-library', 'admin.products.media-library')->name('products.media-library');
        Route::get('products/subcategories/{category}', [ProductController::class, 'subcategories'])->name('products.subcategories');
        Route::get('products/category-attributes/{category}', [ProductController::class, 'categoryAttributes'])->name('products.category-attributes');
        Route::post('/products/upload-images-zip', [ProductController::class, 'uploadImagesZip'])->name('products.images.upload');
        Route::get('/products/import', [ProductController::class, 'import'])->name('products.import');
        Route::post('/products/import', [ProductController::class, 'importStore'])->name('products.import.store');
        Route::get('products/import/sample', [ProductController::class, 'downloadSample'])->name('products.import.sample');
        Route::get('products/reference/categories', [ProductController::class, 'downloadCategoryReference'])->name('products.reference.categories');
        Route::get('products/reference/subcategories', [ProductController::class, 'downloadSubCategoryReference'])->name('products.reference.subcategories');
        Route::get('products/reference/brands', [ProductController::class, 'downloadBrandReference'])->name('products.reference.brands');
        Route::get('products/reference/occasions', [ProductController::class, 'downloadOccasionReference'])->name('products.reference.occasions');
        Route::get('products/reference/customizations', [ProductController::class, 'downloadCustomizationReference'])->name('products.reference.customizations');
        Route::resource('products', ProductController::class)->names('products');

        Route::resource('customizations', CustomizationController::class);

        Route::resource('pages', DynamicPageController::class)->names('pages');

        Route::resource('faqs', FaqController::class)->names('faqs');

        Route::resource('blogs', BlogController::class)->names('blogs');


        Route::resource('clients', ClientController::class)->names('clients');

        Route::resource('testimonials', TestimonialController::class)->names('testimonials');

        Route::resource('contact-branches', ContactBranchController::class);

        Route::get('contact-enquiries/export', [ContactEnquiryController::class, 'export'])->name('contact-enquiries.export');
        Route::delete('contact-enquiries/bulk-delete', [ContactEnquiryController::class, 'bulkDelete'])->name('contact-enquiries.bulk-delete');
        Route::resource('contact-enquiries', ContactEnquiryController::class);

        Route::get('other-enquiries/export', [OtherEnquiryController::class, 'export'])->name('other-enquiries.export');
        Route::delete('other-enquiries/bulk-delete', [OtherEnquiryController::class, 'bulkDelete'])->name('other-enquiries.bulk-delete');
        Route::resource('other-enquiries', OtherEnquiryController::class);

        Route::get('supplier-enquiries/export', [SupplierEnquiryController::class, 'export'])->name('supplier-enquiries.export');
        Route::delete('supplier-enquiries/bulk-delete', [SupplierEnquiryController::class, 'bulkDelete'])->name('supplier-enquiries.bulk-delete');
        Route::resource('supplier-enquiries', SupplierEnquiryController::class);

        Route::resource('coupon-enquiries', CouponEnquiryController::class);
        Route::delete('coupon-enquiries/bulk-delete', [CouponEnquiryController::class, 'bulkDelete'])->name('coupon-enquiries.bulk-delete');
        Route::get('coupon-enquiries-export', [CouponEnquiryController::class, 'export'])->name('coupon-enquiries.export');

        Route::resource('awards', AwardController::class);

        Route::resource('teams', TeamController::class);

        Route::resource('vendor-types', VendorTypeController::class);

        Route::get('/logout', [LogoutController::class, 'logout']);


        // ✅ MAIN DASHBOARD
        Route::get('/home-page', [HomePageController::class, 'index'])
            ->name('home-page.index');

        Route::prefix('home/sliders')->name('home.sliders.')->group(function () {

            Route::get('/', [HomeSliderController::class, 'index'])->name('index');

            Route::get('/create', [HomeSliderController::class, 'create'])->name('create');

            Route::post('/store', [HomeSliderController::class, 'store'])->name('store');

            Route::get('/edit/{id}', [HomeSliderController::class, 'edit'])->name('edit');

            Route::put('/update/{id}', [HomeSliderController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [HomeSliderController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('home/text-sliders')->name('home.text-sliders.')->group(function () {

            Route::get('/', [HomeTextSliderController::class, 'index'])->name('index');

            Route::get('/create', [HomeTextSliderController::class, 'create'])->name('create');

            Route::post('/store', [HomeTextSliderController::class, 'store'])->name('store');

            Route::get('/edit/{id}', [HomeTextSliderController::class, 'edit'])->name('edit');

            Route::put('/update/{id}', [HomeTextSliderController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [HomeTextSliderController::class, 'destroy'])->name('destroy');
        });

        Route::resource('gallery-images', GalleryImageController::class)->names('gallery-images');

        Route::get('home/brand-section', [HomeBrandSectionController::class, 'edit'])->name('home.brand-section.edit');
        Route::post('home/brand-section', [HomeBrandSectionController::class, 'update'])->name('home.brand-section.update');
        Route::resource('home-brand-section-images', HomeBrandSectionImageController::class);

        Route::resource('home-deal-banners', HomeDealBannerController::class)->names('home-deal-banners');
        Route::delete('home-deal-banners/delete/{id}', [HomeDealBannerController::class, 'destroy'])->name('home-deal-banners.delete');

        Route::resource('home-hero-slides', HomeHeroSlideController::class)->names('home-hero-slides');
        Route::resource('home-hero-banners', HomeHeroBannerController::class)->names('home-hero-banners');




        // ================= WHY SECTION =================
        Route::get('/home-why', [HomeWhyController::class, 'index'])
            ->name('home.why.index');

        Route::post('/home-why/update', [HomeWhyController::class, 'updateSection'])
            ->name('home.why.update');

        Route::post('/home-why/card/store', [HomeWhyController::class, 'storeCard'])
            ->name('home.why.card.store');

        Route::get('/home-why/card/{id}', [HomeWhyController::class, 'editCard'])
            ->name('home.why.card.edit');

        Route::post('/home-why/card/{id}', [HomeWhyController::class, 'updateCard'])
            ->name('home.why.card.update');

        Route::delete('/home-why/card/{id}', [HomeWhyController::class, 'deleteCard'])
            ->name('home.why.card.delete');

        Route::resource('home-feature-cards', HomeFeatureCardController::class);


        Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('/seo/{id}', [SeoController::class, 'update'])->name('seo.update');

        Route::resource('collections', CollectionController::class);

        Route::resource('attributes', AttributeController::class);
        Route::resource('attribute-values', AttributeValueController::class);

        Route::resource('category-attributes', CategoryAttributeController::class);

        Route::resource('announcements', AnnouncementController::class);

        Route::post('coupons/{coupon}/share', [CouponController::class, 'share'])->name('coupons.share');
        Route::resource('coupons', CouponController::class);

        // Admin Settings routes
        Route::view('/admin-setting/whatsapp', 'admin.admin-setting.whatsapp')->name('admin-setting.whatsapp');
        Route::view('/admin-setting/sms-api', 'admin.admin-setting.sms-api')->name('admin-setting.sms-api');
        Route::view('/admin-setting/google-setting', 'admin.admin-setting.google-setting')->name('admin-setting.google-setting');
        Route::view('/admin-setting/delivery-setting', 'admin.admin-setting.delivery-setting')->name('admin-setting.delivery-setting');
        Route::view('/security/security-settings', 'admin.security.security-settings')->name('security.security-settings');



 Route::prefix('redirect-settings')->name('redirect-settings.')->group(function () {
        Route::get('/', [RedirectController::class, 'index'])->name('index');
        Route::post('/', [RedirectController::class, 'store'])->name('store');
        Route::put('/{redirect}', [RedirectController::class, 'update'])->name('update');
        Route::delete('/{redirect}', [RedirectController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [RedirectController::class, 'bulkDestroy'])->name('bulk-delete');
        Route::post('/bulk-toggle', [RedirectController::class, 'bulkToggle'])->name('bulk-toggle');
        Route::post('/{redirect}/toggle', [RedirectController::class, 'toggleStatus'])->name('toggle');
        Route::get('/export', [RedirectController::class, 'exportCsv'])->name('export');
        Route::get('/template', [RedirectController::class, 'downloadTemplate'])->name('template');
        Route::post('/import', [RedirectController::class, 'importCsv'])->name('import');
    });
    
        Route::get('/admin-setting', [AdminSettingController::class, 'index'])->name('admin-setting.index');
        Route::post('/invoice-settings', [AdminSettingController::class, 'invoiceSettingStore'])->name('invoice-settings.store');
        Route::post('/smtp-settings/store', [AdminSettingController::class, 'smtpSettingStore'])->name('smtp-settings.store');
        Route::post('/payment-settings/store', [AdminSettingController::class, 'paymentSettingStore'])->name('payment-settings.store');
        Route::post('/settings/general', [AdminSettingController::class, 'generalSettingStore'])->name('settings.general.store');
        Route::post('/settings/courier/store', [AdminSettingController::class, 'courierStore'])->name('couriers.store');
        Route::delete('/settings/courier/{courier}', [AdminSettingController::class, 'courierDelete'])->name('couriers.delete');
        Route::post('admin-setting/google-setting', [AdminSettingController::class, 'googleSettingStore'])->name('admin-setting.google-setting');

Route::get('/security/system-logs', [SystemLogController::class, 'index'])->name('security.system-logs');

        Route::get('/settings/email-templates', [EmailTemplateController::class, 'index'])->name('settings.email-templates.index');
        Route::post('settings/email-templates/test', [EmailTemplateController::class, 'sendTest'])->name('settings.email-templates.test');
        Route::post('settings/email-templates/{eventKey}', [EmailTemplateController::class, 'save'])->name('settings.email-templates.save');

        // Orders routes
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
         Route::get('orders/print-labels', [OrderController::class, 'printLabels'])->name('orders.print-labels');
        Route::post('orders/print-labels/preview', [OrderController::class, 'previewLabels'])->name('orders.preview-labels');
        Route::post('orders/print-labels/generate', [OrderController::class, 'generateLabels'])->name('orders.generate-labels');
        Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('orders/{order}/invoice/download', [OrderController::class, 'invoiceDownload'])->name('orders.invoice.download');

        // Payments routes
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');

        // Customer Address Book
        Route::get('customers/addresses', [CustomerAddressController::class, 'index'])->name('customers.addresses.index');
        Route::delete('customers/addresses/{address}', [CustomerAddressController::class, 'destroy'])->name('customers.addresses.destroy');
        Route::get('customers/addresses/export', [CustomerAddressController::class, 'export'])->name('customers.addresses.export');

        // Customers routes
   Route::get('customers/customer-wishlist', [CustomerWishlistController::class, 'index'])->name('customers.customer-wishlist');
       Route::get('customers/{customer}/wishlist-detail', [CustomerWishlistController::class, 'show'])
    ->name('customers.customer-wishlist-detail');
    Route::delete('customers/{customer}/wishlist/clear', [CustomerWishlistController::class, 'clearWishlist'])
    ->name('customers.wishlist.clear');
    Route::delete('/wishlist/{wishlistId}', [\App\Http\Controllers\Admin\CustomerWishlistController::class, 'removeItem']);
    
    
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');

        Route::get('stored-carts', [StoredCartController::class, 'index'])->name('stored-carts.index');
        Route::delete('stored-carts/{cart}', [StoredCartController::class, 'destroy'])->name('stored-carts.destroy');
        Route::get('stored-carts/export', [StoredCartController::class, 'export'])->name('stored-carts.export');



        Route::resource('return-reasons', ReturnReasonController::class)->names('return-reasons');


        Route::get('order-returns', [OrderReturnController::class, 'index'])->name('order-returns.index');
        Route::get('order-returns/export', [OrderReturnController::class, 'export'])->name('order-returns.export');
        Route::get('order-returns/{orderReturn}', [OrderReturnController::class, 'show'])->name('order-returns.show');
        Route::patch('order-returns/{orderReturn}/approve', [OrderReturnController::class, 'approve'])->name('order-returns.approve');
        Route::patch('order-returns/{orderReturn}/reject', [OrderReturnController::class, 'reject'])->name('order-returns.reject');
        Route::post('order-returns/{orderReturn}/refund', [OrderReturnController::class, 'refund'])->name('order-returns.refund');

        Route::get('refunds', [RefundController::class, 'index'])->name('refunds.index');
        Route::get('refunds/export', [RefundController::class, 'export'])->name('refunds.export');


        Route::get('stock', [StockManagementController::class, 'index'])->name('stock.index');
        Route::get('stock/export', [StockManagementController::class, 'export'])->name('stock.export');
        Route::post('stock/bulk-update', [StockManagementController::class, 'bulkUpdate'])->name('stock.bulk-update');
        Route::post('stock/add-entry', [StockManagementController::class, 'addStockEntry'])->name('stock.add-entry');
        Route::post('stock/{product}/update', [StockManagementController::class, 'updateStock'])->name('stock.update');
        Route::post('stock/{product}/restock', [StockManagementController::class, 'restock'])->name('stock.restock');
        Route::get('stock/{product}/history', [StockManagementController::class, 'history'])->name('stock.history');
        Route::get('stock/bulk-update/template', [StockManagementController::class, 'downloadTemplate'])->name('stock.bulk-update.template');
        Route::post('stock/variant/{variant}/update', [StockManagementController::class, 'updateVariantStock'])->name('stock.variant.update');
        Route::post('stock/variant/{variant}/restock', [StockManagementController::class, 'restockVariant'])->name('stock.variant.restock');
        Route::get('stock/variant/{variant}/history', [StockManagementController::class, 'historyVariant'])->name('stock.variant.history');

        Route::get('stock/alerts', [StockAlertsController::class, 'index'])->name('stock.alerts');
        Route::post('stock/alerts/{product}/restock', [StockAlertsController::class, 'restock'])->name('stock.alerts.restock');
        Route::post('stock/alerts/settings/thresholds', [StockAlertsController::class, 'updateThresholds'])->name('stock.alerts.thresholds');
        Route::post('stock/alerts/settings/notifications', [StockAlertsController::class, 'updateNotifications'])->name('stock.alerts.notifications');
        Route::get('stock/alerts/export', [StockAlertsController::class, 'export'])->name('stock.alerts.export');
        Route::post('stock/alerts/restock-all-critical', [StockAlertsController::class, 'restockAllCritical'])->name('stock.alerts.restock.all');
        Route::post('stock/alerts/variant/{variant}/restock', [StockAlertsController::class, 'restockVariant'])->name('stock.alerts.variant.restock');



        // Listing page

        Route::get('/reviews', [App\Http\Controllers\Admin\ProductReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/{review}', [App\Http\Controllers\Admin\ProductReviewController::class, 'show'])->name('reviews.show');
        Route::patch('/reviews/{review}/approve', [App\Http\Controllers\Admin\ProductReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('/reviews/{review}/reject', [App\Http\Controllers\Admin\ProductReviewController::class, 'reject'])->name('reviews.reject');
        Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ProductReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/reviews/export/csv', [App\Http\Controllers\Admin\ProductReviewController::class, 'export'])->name('reviews.export');


        Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');
        Route::get('/reports/sales/export', [SalesReportController::class, 'export'])->name('reports.sales.export');

        Route::get('/reports/products', [ProductReportController::class, 'index'])->name('reports.products');
        Route::get('reports/products/export/csv', [ProductReportController::class, 'exportCsv'])->name('reports.products.export.csv');
        Route::get('reports/products/export/pdf', [ProductReportController::class, 'exportPdf'])->name('reports.products.export.pdf');

        Route::get('reports/customers', [CustomerReportController::class, 'index'])->name('reports.customers');
        Route::get('reports/customers/export/excel', [CustomerReportController::class, 'exportExcel'])->name('reports.customers.export.excel');
        Route::get('reports/customers/export/pdf', [CustomerReportController::class, 'exportPdf'])->name('reports.customers.export.pdf');
        
        Route::get('/reports/order-reports', [OrderReportController::class, 'index'])->name('reports.order-reports');
        Route::get('/reports/order-reports/export-excel', [OrderReportController::class, 'exportExcel'])->name('reports.order-reports.export-excel');
Route::get('/reports/order-reports/export-pdf', [OrderReportController::class, 'exportPdf'])->name('reports.order-reports.export-pdf');
        
      
Route::get('/reports/coupon-reports', [CouponReportController::class, 'index'])->name('reports.coupon-reports');
Route::get('/reports/coupon-reports/export', [CouponReportController::class, 'export'])->name('reports.coupon-reports.export');

       // routes/web.php (inside your admin group)
Route::get('/reports/tax-reports', [TaxReportController::class, 'index'])->name('reports.tax-reports');
Route::get('/reports/tax-reports/export-csv', [TaxReportController::class, 'exportCsv'])->name('reports.tax-reports.export-csv');
        
     
        Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
    Route::delete('/clear-read', [NotificationController::class, 'clearRead'])->name('clear-read');
    Route::post('/{notification}/read', [NotificationController::class, 'markRead'])->name('read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
});

        Route::view('/templates-setting', 'admin.admin-settings.template-setting')->name('templates.template-setting');

        Route::prefix('roles-and-permission')->group(function () {

            // Roles Category
            Route::view('/roles-category', 'admin.roles-and-permission.roles-category.index')->name('roles-category.index');
            Route::view('/roles-category/create', 'admin.roles-and-permission.roles-category.create')->name('roles-category.create');
            Route::view('/roles-category/edit', 'admin.roles-and-permission.roles-category.edit')->name('roles-category.edit');

            // Permission and Settings
            Route::view('/permission-and-settings', 'admin.roles-and-permission.permission-and-settings.index')->name('permission-settings.index');
            Route::view('/permission-and-settings/create', 'admin.roles-and-permission.permission-and-settings.create')->name('permission-settings.create');
            Route::view('/permission-and-settings/edit', 'admin.roles-and-permission.permission-and-settings.edit')->name('permission-settings.edit');

            // Team
            Route::view('/team', 'admin.roles-and-permission.team.index')->name('team.index');
            Route::view('/team/create', 'admin.roles-and-permission.team.create')->name('team.create');
            Route::view('/team/edit', 'admin.roles-and-permission.team.edit')->name('team.edit');
            Route::view('/team/customise-permission', 'admin.roles-and-permission.team.customise-permission')->name('team.customise-permission');
            Route::view('/team/activity-logs', 'admin.roles-and-permission.team.activity-logs')->name('team.activity-logs');
            Route::view('/team/login', 'admin.roles-and-permission.team.login')->name('team.login');
            Route::view('/team/login-summary', 'admin.roles-and-permission.team.login-summary')->name('team.login-summary');
            Route::view('/team/login-history', 'admin.roles-and-permission.team.login-history')->name('team.login-history');


        });

    });
});



// ══════════════════════════════════════════════════
// FALLBACK ROUTE — must be the very last route registered.
// Only runs when NOTHING above matched (i.e. a genuine 404).
// Checks the redirects table before giving up with a real 404/410.
// ══════════════════════════════════════════════════
Route::fallback(function () {
    $path = '/' . ltrim(request()->path(), '/');

    $redirect = \App\Models\Redirect::active()->where('from_url', $path)->first();

    if ($redirect) {
        $redirect->increment('hits');

        if ($redirect->type === '410') {
            abort(410);
        }

        return redirect($redirect->to_url, (int) $redirect->type);
    }

    abort(404);
});
