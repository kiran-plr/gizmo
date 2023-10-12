<?php

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Auth::routes();

// Route::get('/mail', function () {
//     $shipment = Shipment::find(16);
//     $mailType = 'vendor';
//     return view('email.free-quote-mail', compact('shipment', 'mailType'));
// });



Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/autologin', 'Auth\LoginController@autoLogin');

    Route::match(['get', 'post'], '/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['role:admin']], function () {
        Route::get('/dashboard', 'DashboardController@index')->middleware('permission:dashboard_access')->name('dashboard');

        /* User Management */
        Route::get('/users', 'UserController@index')->name('user.index');
        Route::get('/user/login/{id}', 'UserController@userLogin')->name('user.login');
        Route::get('/user/logout/', 'UserController@userLogout')->name('user.logout');
        Route::get('/user/create/{id?}', 'UserController@createOrEdit')->name('user.createOrEdit');
        Route::post('/user/store/{id?}', 'UserController@store')->name('user.store');
        Route::delete('/user/{id}/destroy', 'UserController@destroy')->name('user.delete');

        /* Location Management */
        Route::get('/location', 'LocationController@index')->name('location.index');
        Route::get('/location/edit/{id?}/', 'LocationController@edit')->name('location.edit');
        Route::post('/location/store/{id?}', 'LocationController@store')->name('location.store');
        Route::get('/location/show/{id}', 'LocationController@show')->name('location.show');
        Route::post('/location/assign-user/{id?}', 'LocationController@assignUser')->name('location.assign-user');
        Route::get('/location/export', 'LocationController@export')->name('location.export');
        Route::post('/location/import', 'LocationController@import')->name('location.import');

        /* Product Management */
        Route::get('/product', 'ProductController@index')->name('product.index');
        Route::get('/product/create/{id?}', 'ProductController@create')->name('product.createOrEdit');
        Route::get('/product/show/{id}', 'ProductController@show')->name('product.show');
        Route::get('/product/export', 'ProductController@export')->name('product.export');
        Route::post('/product/import', 'ProductController@import')->name('product.import');

        /* Shipments */
        Route::get('/shipments', 'ShipmentController@index')->name('shipment.index');
        Route::get('/shipment/show/{id}', 'ShipmentController@show')->name('shipment.show');
        Route::get('/shipment/change-status', 'ShipmentController@changeStatus')->name('shipment.change-status');
        Route::post('shipments/{id}/cancel', 'ShipmentController@cancelShipment')->name('shipment.cancel');
        Route::get('shipments/export', 'ShipmentController@export')->name('shipment.export');
        Route::get('shipments/cancel-shipments', 'ShipmentController@cancelShipmentIndex')->name('shipment.cancelShipments');

        /* Payouts */
        Route::get('/payouts/{status}', 'PayoutController@index')->name('payout.index');
        Route::get('/payouts/{id}/checkout', 'PayoutController@processCheckout')->name('payout.checkout');
        Route::get('/payouts/show/{id}', 'PayoutController@show')->name('payout.show');
    });

    Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'namespace' => 'Vendor', 'middleware' => ['role:vendor']], function () {
        Route::get('/dashboard', 'DashboardController@index')->middleware('permission:dashboard_access')->name('dashboard');
        Route::get('/no-locations', 'DashboardController@noLocations')->name('no-locations');

        // Trade-Ins Management
        Route::get('trade-ins', 'ShipmentController@tradeIns')->name('shipment.trade-ins');
        Route::get('trade-ins/show/{id}/', 'ShipmentController@tradeInShow')->name('shipment.trade-ins.show');

        // Shipment Management
        Route::get('shipments', 'ShipmentController@index')->name('shipment.index');
        Route::get('shipments/show/{id}/', 'ShipmentController@show')->name('shipment.show');
        Route::get('shipments/download-label/{id}', 'ShipmentController@downloadLabel')->name('shipment.download.label');
        Route::post('shipments/group-shipments', 'ShipmentController@groupShipments')->name('shipment.group-shipments');
        Route::post('shipments/{id}/cancel', 'ShipmentController@cancelShipment')->name('shipment.cancel');


        Route::get('/location/change/{id}', 'DashboardController@changeLocation')->name('location.change');

        Route::get('/shipments/approve-process/{id}', 'ShipmentController@approveProcess')->name('shipment.approveProcess');

        Route::get('/shipment-create', 'ShipmentController@createShipment')->name('shipment.create');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', 'DashboardController@index')->middleware('permission:dashboard_access')->name('dashboard');

        //Change Password
        Route::get('/password/change', 'DashboardController@changePasswordIndex')->name('password.change.index');
        Route::post('/change-password', 'DashboardController@changePassword')->name('password.change');

        // Shipment Management
        Route::get('/shipments', 'ShipmentController@index')->name('shipment.index');
        Route::get('/shipments/show/{id}/', 'ShipmentController@show')->name('shipment.show');
    });


    Route::group(['namespace' => 'Frontend'], function () {
        Route::get('/sell-your-device', 'SellDeviceController@index')->name('sell-your-device');
        Route::get('/shipment-process', 'SellDeviceController@shippingInformation')->name('shipment-process');
        Route::get('/shipment-review', 'SellDeviceController@shipmentReview')->name('shipment-review');
        Route::post('/confirm-location', 'SellDeviceController@confirmLocation')->name('confirm-location');
        Route::get('/ship-my-item', 'SellDeviceController@shipMyItemIndex')->name('ship-my-item');
        Route::get('/print-my-label', 'SellDeviceController@printMyLabelIndex')->name('print-my-label.index');
        Route::get('/print-my-label/download', 'SellDeviceController@printMyLabel')->name('print-my-label');
        Route::get('/cart', 'SellDeviceController@cart')->name('cart');
    });

    /* Contact Us */
    Route::get('contact-us', 'ContactUsController@index')->name('contact-us');
    Route::post('contact-us/store', 'ContactUsController@store')->name('contact-us.store');
    Route::post('buy-a-device-inquiry/store', 'ContactUsController@storeInquiry')->name('buy-a-device.inquiry.store');

    /** Request a free quote & Have a qustions*/
    Route::post('corporate-recycling/form/submit', 'ContactUsController@submitQuoteForm')->name('corporate-recycling.submit');
    Route::get('corporate-recycling/thank-you', 'ContactUsController@thankYouPage')->name('corporate-recycling.thankyou');

    /* Track Shipment */
    Route::get('/track-shipment', 'FrontendController@trackShipmentForm')->name('track-shipment');

    /* Sell Iphone */
    Route::get('/sell-iphone', 'FrontendController@sellIphone')->name('sell-iphone');
});

Route::group(['namespace' => 'App\Http\Livewire\Frontend'], function () {
    Route::get('/locations', Locations::class)->name('locations');
});

/*CMS Page */
Route::get('/{slug}', 'App\Http\Controllers\FrontendController@cmsPages')->name('cms-page');

Route::get('shipment-list', function () {
    return view('frontend.shipment-list');
})->name('shipment-list');

Route::get('shipment-detail/{id?}', function () {
    return view('frontend.shipment-detail');
})->name('shipment-detail');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
