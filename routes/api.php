<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\Shop\ShopController;
use App\Http\Controllers\API\Order\OrderController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\Location\AreaController;
use App\Http\Controllers\API\Location\CityController;
use App\Http\Controllers\API\Shop\ShopTypeController;
use App\Http\Controllers\API\Location\FloorController;
use App\Http\Controllers\API\Location\MarketController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\General\TutorialController;
use App\Http\Controllers\API\Interaction\LikeController;
use App\Http\Controllers\API\Interaction\ShareController;
use App\Http\Controllers\API\Product\Base\SizeController;
use App\Http\Controllers\API\Product\Base\UnitController;
use App\Http\Controllers\API\Product\FlashsaleController;
use App\Http\Controllers\API\Rating\ShopRatingController;
use App\Http\Controllers\API\Wishlist\WishlistController;
use App\Http\Controllers\API\Product\Base\ColorController;
use App\Http\Controllers\API\General\Brand\BrandController;
use App\Http\Controllers\API\Interaction\CommentController;
use App\Http\Controllers\API\Product\Base\WeightController;
use App\Http\Controllers\API\UserManagement\AuthController;
use App\Http\Controllers\API\General\Menu\AppMenuController;
use App\Http\Controllers\API\Product\FestivalSaleController;
use App\Http\Controllers\Api\UserManagement\VendorController;
use App\Http\Controllers\API\UserManagement\ProfileController;
use App\Http\Controllers\API\Delivery\DeliveryController;
use App\Http\Controllers\API\Interaction\InteractionController;
use App\Http\Controllers\API\General\Category\CategoryController;
use App\Http\Controllers\API\Interaction\InteractionTopicController;
use App\Http\Controllers\API\ShopingFriend\ShopingFriendController;
use App\Http\Controllers\API\ShopSubscribe\ShopingSubscribeController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);

Route::get('menus', [AppMenuController::class, 'index']);;
Route::get('areas', [AreaController::class, 'index']);
Route::get('areas-by-city/{id}', [AreaController::class, 'areaByCity']);
// Route::post('search-all-header', [SearchController::class, 'searchAllHeder']);
Route::get('searchallheader/{type}/{key}', [SearchController::class, 'searchAllHeder']);

Route::prefix('cities')->namespace('City')->group(function () {
    Route::get('', [CityController::class, 'index']);
    Route::get('{id}/markets', [CityController::class, 'cityMarkets']);
});

Route::prefix('markets')->namespace('Market')->group(function () {
    Route::get('', [MarketController::class, 'index']);
    Route::get('all-market-by-city/{id}', [MarketController::class, 'allMarketsByCity']);
    Route::get('top-market-by-city/{id}', [MarketController::class, 'topMarketsByCity']);
    Route::get('all-market-by-area/{id}', [MarketController::class, 'allMarketsByArea']);
    Route::get('top-market-by-area/{id}', [MarketController::class, 'topMarketsByArea']);
    Route::get('{id}', [MarketController::class, 'singleMarket']);
});

//Shop Subscribe
Route::get('subscribe-count-by-shop/{shopId}', [ShopingSubscribeController::class, 'countSubscribersByShopID']);

//Rating
Route::get('rate-count-by-shop/{shopId}', [ShopRatingController::class, 'countRatingByShopID']);

// User Interaction videos
    Route::get('videos', [InteractionController::class, 'videos']);
// User Interaction templates
    Route::get('templates', [InteractionController::class, 'templates']);
// User Interaction experiences
    Route::get('experiences', [InteractionController::class, 'experiences']);
// User Interaction memes
    Route::get('memes', [InteractionController::class, 'memes']);
// User Interaction stories
    Route::get('stories', [InteractionController::class, 'stories']);
// Show Single User Interaction
    Route::get('contribution/{id}', [InteractionController::class, 'showContribution']);

Route::get('floors', [FloorController::class, 'index']);

Route::get('base/categories', [CategoryController::class, 'baseCategories']);

// shop related
Route::prefix('shops')->namespace('Shop')->group(function () {
    Route::get('shop-types', [ShopTypeController::class, 'index']);
    Route::get('all-shops-by-market/{id}', [ShopController::class, 'shopByMarket']);
    Route::get('{id}', [ShopController::class, 'show']);
    Route::get('shops-by-market-by-floor/{id}', [ShopController::class, 'getShopCountByMarketFloor']);
    Route::post('search/shops-by-market', [ShopController::class, 'searchShopByMarket']);
    Route::get('shops-by-market-floor/{marketId}/{floorId}', [ShopController::class, 'shopByMarketFloor']);
    Route::post('visit', [ShopController::class, 'visitShop']);
    Route::get('active-visitor/{id}', [ShopController::class, 'activeVisitor']);
    Route::get('today-visitors/{id}', [ShopController::class, 'todayVisitors']);
});



Route::any('products-by-shop/{shop_id}', [ProductController::class, 'productsByShop']);
Route::any('products-by-shop/category/{shop_id}/{cate_id}', [ProductController::class, 'productsByShopByCategory']);
Route::post('search/products', [ProductController::class, 'searchProducts']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('products/similar-product/{shopId}', [ProductController::class, 'similarProduct']);

Route::get('/flash-sale', [FlashsaleController::class, 'index']);
Route::get('/festival-sale', [FestivalSaleController::class, 'index']);

Route::prefix('topics')->namespace('Topic')->group(function () {
    Route::get('', [InteractionTopicController::class, 'index']);
    Route::get('/category/{category_id}', [InteractionTopicController::class, 'getAllByCategoryID']);
});

//For Authenticated User
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [AuthController::class, 'getAuthUser']);
    Route::post('user-info-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/security', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('check-delivery-account', [ProfileController::class, 'check'])->name('profile.check');
    Route::get('staffs/{id}', [VendorController::class, 'index']);
    Route::post('staff-create', [VendorController::class, 'store']);
    Route::get('staff/{id}', [VendorController::class, 'show']);
    Route::post('staff/update/{id}', [VendorController::class, 'update']);
    Route::get('staff/{id}', [VendorController::class, 'destroy']);
    Route::post('search/shop/member', [VendorController::class, 'searchMember']);



    Route::get('get-orders/{id}', [DeliveryController::class, 'getOrders'])->name('delivery.getOrders');
    Route::get('collect-order/{id}', [DeliveryController::class, 'collectOrders'])->name('delivery.collectOrders');


    //Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('product-notification', [NotificationController::class, 'productNotificationByID'])->name('notification.new-product-notification');
        Route::post('/read', [NotificationController::class, 'readNotification'])->name('notification.read');
    });

    //Rating
    Route::post('shop-rating', [ShopRatingController::class, 'sentShopRating']);

    //Shoping Friend
    Route::get('friends-list', [ShopingFriendController::class, 'index']);
    Route::get('unfriend/{id}', [ShopingFriendController::class, 'unfriend']);
    Route::get('find-friends-list', [ShopingFriendController::class, 'findFriends']);
    Route::get('send-request/{id}', [ShopingFriendController::class, 'sendRequest']);
    Route::get('request-friends-list', [ShopingFriendController::class, 'requestFriends']);
    Route::get('accept-request/{id}', [ShopingFriendController::class, 'acceptRequest']);
    Route::get('delete-request/{id}', [ShopingFriendController::class, 'deleteRequest']);
    Route::post('friend-request', [ShopingFriendController::class, 'sentShopingFriendRequest']);
    Route::post('invite-request', [ShopingFriendController::class, 'sentShopingFriendInvitation']);
    Route::get('search/shoping-friend/{keyword}', [ShopingFriendController::class, 'shopingFriendSearch']);

    //Shop Subscribe
    Route::get('subscribe-list', [ShopingSubscribeController::class, 'index']);
    Route::post('subscribe-request', [ShopingSubscribeController::class, 'sentShopSubscribeRequest']);
    Route::post('rename-nickname', [ShopingSubscribeController::class, 'renameNickname']);
    Route::get('subscribe-check-by-shop-customer/{shopId}', [ShopingSubscribeController::class, 'checkByShop']);
    Route::get('notify-subscribers/{shopId}',[ShopingSubscribeController::class,'notifySubscribers']);
    Route::get('unsubscribe/{id}',[ShopingSubscribeController::class,'unsubscribe']);
    Route::get('search-subscribe-shop/{key}',[ShopingSubscribeController::class,'searchSubscribe']);
    // Recently visited shop
    Route::get('recently-visit-shop-list', [ShopController::class, 'recentlyVisit']);
    Route::get('frequently-visit-shop-list', [ShopController::class, 'frequentlyVisit']);

    //Shop wish list
    Route::get('wishlist-request/{id}', [WishlistController::class, 'sentWishlistRequest']);
    Route::get('wishlist-check-by-product/{productId}', [WishlistController::class, 'checkWishList']);
    Route::get('wishlists', [WishlistController::class, 'index']);
    Route::get('wishlist/{id}', [WishlistController::class, 'destroy']);

    // My contributions
    Route::get('my-contributions', [InteractionController::class, 'myContributions']);

    // my shop related
    Route::prefix('my-shops')->namespace('Shop')->group(function () {
        Route::get('', [ShopController::class, 'index']);
        Route::post('', [ShopController::class, 'store']);
        Route::get('{id}/edit', [ShopController::class, 'edit']);
        Route::get('self', [ShopController::class, 'myShops']);
        Route::get('{id}', [ShopController::class, 'myShop']);
        Route::post('update/{id}', [ShopController::class, 'update']);
        Route::get('delete/{id}', [ShopController::class, 'destroy']);
        Route::get('pending/{id}', [ShopController::class, 'checkApproveShop']);
        Route::get('media-image/{id}', [ShopController::class, 'removeShopMedia']);
    });

    // general topic
    Route::prefix('brands')->namespace('Brand')->group(function () {
        Route::get('', [BrandController::class, 'index']);
        Route::post('create', [BrandController::class, 'store']);
    });

    // product related
    Route::get('colors', [ColorController::class, 'index']);
    Route::get('sizes', [SizeController::class, 'index']);
    Route::get('weights', [WeightController::class, 'index']);
    Route::get('units', [UnitController::class, 'index']);

    //Product
    Route::prefix('products')->namespace('Product')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        Route::get('self/{id}', [ProductController::class, 'selfProduct']);
        Route::post('/add', [ProductController::class, 'store']);
        Route::get('{id}/edit', [ProductController::class, 'edit']);
        Route::post('update/{id}', [ProductController::class, 'update']);
        Route::get('delete/{id}', [ProductController::class, 'destroy']);
        Route::get('similar-by-product/{productId}/{shopId}', [ProductController::class, 'similarProductByProduct']);
        Route::get('remove-image-gallery/{id}', [ProductController::class, 'productImageGalleryRemove']);
        Route::post('add-to-flash', [FlashsaleController::class, 'addToFlashSale']);
        Route::post('add-to-festival', [FestivalSaleController::class, 'addToFestivalSale']);
    });

    // product tutorial

    Route::get('product-tutorial', [TutorialController::class, 'index']);

    // product-rating part

    Route::post('product-rating', [ProductController::class, 'storeProductRating']);
    Route::get('product-rating-review/{productId}', [ProductController::class, 'getRatingAndReview']);

    Route::prefix('categories')->namespace('Category')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('base', [CategoryController::class, 'baseCategories']);
        Route::post('create', [CategoryController::class, 'store']);
    });

    // oder related
    Route::prefix('orders')->namespace('Order')->group(function () {
        Route::get('', [OrderController::class, 'index']);
        Route::get('last-order', [OrderController::class, 'lastOrder']);
        Route::get('shipping-address', [OrderController::class, 'shippingAddress']);
        Route::get('self', [OrderController::class, 'selfOrder']);
        Route::get('self/{status}', [OrderController::class, 'selfOrderBystatus']);
        Route::get('{id}', [OrderController::class, 'show']);
        Route::get('shop/{id}', [OrderController::class, 'ordersByShop']);
        Route::get('shop/{id}/sales-report', [OrderController::class, 'salesReport']);

        Route::get('status-update/{status}/{id}', [OrderController::class, 'statusUpdate']);
        Route::post('/storeOrder', [OrderController::class, 'store']);
    });

    // Route::prefix('templates')->namespace('Template')->group(function () {
    //     Route::get('', [InteractionController::class, 'templates']);
    //     // Route::post('/create', [InteractionController::class, 'storeTemplate']);
    // });

    Route::prefix('videos')->namespace('Video')->group(function () {
        // Route::post('/create', [InteractionController::class, 'storeVideo']);
        Route::post('/{id}/update', [InteractionController::class, 'updateVideo']);
    });

    Route::prefix('interaction')->namespace('interaction')->group(function () {
        Route::post('/store', [InteractionController::class, 'store']);
        Route::post('/{id}/update', [InteractionController::class, 'update']);
    });

    Route::prefix('comments')->namespace('Comment')->group(function () {
        Route::get('', [CommentController::class, 'index']);
        Route::get('/{interaction_id}', [CommentController::class, 'show']);
        Route::post('/create', [CommentController::class, 'store']);
        Route::post('/{id}/update', [CommentController::class, 'update']);
        Route::get('/delete/{id}', [CommentController::class, 'destroy']);
    });

    Route::prefix('like')->namespace('Like')->group(function () {
        Route::get('/{interaction_id}', [LikeController::class, 'getLikes']);
        Route::post('/create', [LikeController::class, 'store']);
        Route::get('/delete/{id}', [LikeController::class, 'destroy']);
    });

    Route::prefix('shares')->namespace('Share')->group(function () {
        Route::get('/{interaction_id}', [ShareController::class, 'getShares']);
        Route::post('/create', [ShareController::class, 'store']);
    });
});
