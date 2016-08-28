<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
| Define the routes for your Frontend pages here
|
*/

/*Route::get('/', [
    'as' => 'home', 'uses' => 'FrontendController@home'
]);*/

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Route group for Backend prefixed with "admin".
| To Enable Authentication just remove the comment from Admin Middleware
|
*/
    Route::get('/', [
        'as' => 'admin.dashboard', 'uses' => 'AuthController@login'
    ]);

Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin'
], function () {

    //Main Dashboard

    Route::get('/', [
        'as' => 'admin.dashboard', 'uses' => 'DashboardController@index'
    ]);

    Route::get('/search', [
        'as' => 'admin.customers.search',  'uses' => 'CustomerController@search'
    ]);

    Route::get('/customers',  [
        'as' => 'admin.customers.index', 'uses' => 'CustomerController@index'
    ]);

    Route::get('/customer/create',  [
        'as' => 'admin.customer.create', 'uses' => 'CustomerController@create'
    ]);

    Route::post('/customer/save',  [
        'as' => 'admin.customer.save', 'uses' => 'CustomerController@save'
    ]);

    Route::get('/customer/details/{id}',  [
        'as' => 'admin.customer.show', 'uses' => 'CustomerController@show'
    ])->where(['id' => '[0-9]+']);

    Route::get('/customer/edit/{id}',  [
        'as' => 'admin.customer.edit', 'uses' => 'CustomerController@edit'
    ])->where(['id' => '[0-9]+']);

    Route::post('/customer/update/{id}',  [
        'as' => 'admin.customer.update', 'uses' => 'CustomerController@update'
    ])->where(['id' => '[0-9]+']);

    Route::get('/bookings',  [
        'as' => 'admin.bookings.index', 'uses' => 'BookingController@index'
    ]);

    Route::post('/booking/status',  [
        'as' => 'admin.booking.status', 'uses' => 'BookingController@updateStatus'
    ]);

    /* Listing page of order, order positions and order passengers*/
    Route::get('/booking/{id}',  [
        'as' => 'adminBookingShow', 'uses' => 'BookingController@show'
    ])->where(['id' => '[0-9]+']);

    /* Download invoice*/
    Route::get('/booking/invoice/download/{id}',  [
        'as' => 'adminInvoiceDownload', 'uses' => 'BookingController@downloadInvoice'
    ])->where(['id' => '[0-9]+']);

    /* Order position update form */
    Route::get('/booking/position/{id}',  [
        'as' => 'adminBookingPositionUpdateForm', 'uses' => 'BookingController@positionUpdateForm'
    ])->where(['id' => '[0-9]+']);

    /* Order position update */
    Route::post('/booking/position/update/{id}',  [
        'as' => 'adminBookingPositionUpdate', 'uses' => 'BookingController@positionUpdate'
    ])->where(['id' => '[0-9]+']);

    /* Order position create form */
    Route::get('/booking/position/create/{id}',  [
        'as' => 'adminBookingPositionCreateForm', 'uses' => 'BookingController@positionCreateForm'
    ])->where(['id' => '[0-9]+']);

    /* Order position save*/
    Route::post('/booking/position/save/{id}',  [
        'as' => 'adminBookingPositionSave', 'uses' => 'BookingController@positionSave'
    ])->where(['id' => '[0-9]+']);

    /* Order Incoming Invoice Save*/
    Route::post('/incoming/invoice/save',  [
        'as' => 'adminIncomingInvoiceSave', 'uses' => 'BookingController@saveIncomingInvoice'
    ]);

    /* Order position meta save*/
    Route::post('/position/meta/save/{id}',  [
        'as' => 'adminPositionMetaSave', 'uses' => 'BookingController@savePositionMeta'
    ])->where(['id' => '[0-9]+']);

    /* Order position meta update*/
    Route::post('/position/meta/update/{id}',  [
        'as' => 'adminPositionMetaUpdate', 'uses' => 'BookingController@updatePositionMeta'
    ])->where(['id' => '[0-9]+']);

    /*Memberships List*/
    Route::get('/memberships',  [
        'as' => 'adminMembershipList', 'uses' => 'MembershipController@index'
    ]);

    /*Memberships save*/
    Route::post('/membership/save/{customer_id}',  [
        'as' => 'adminMembershipSave', 'uses' => 'MembershipController@save'
    ])->where(['customer_id' => '[0-9]+']);

    /*Memberships renewal*/
    Route::post('/membership/renewal',  [
        'as' => 'adminMembershipRenew', 'uses' => 'MembershipController@renewMemberships'
    ]);

    /*Membership cancellation*/
    Route::post('/membership/cancel/{id}',  [
        'as' => 'adminMembershipCancel', 'uses' => 'MembershipController@cancelMembership'
    ])->where(['id' => '[0-9]+']);

    /*Customer create order*/
    Route::post('/customer/neworder/{customer_id}',  [
        'as' => 'adminCreateOrder', 'uses' => 'CustomerController@createOrder'
    ])->where(['customer_id' => '[0-9]+']);

    /*Customer order invoice*/
    Route::post('/customer/order/invoice/{order_id}',  [
        'as' => 'adminCustomerOrderInvoice', 'uses' => 'BookingController@sendInvoice'
    ])->where(['order_id' => '[0-9]+']);


    /*
    |--------------------------------------------------------------------------
    | Person List
    |--------------------------------------------------------------------------
    | Listing school and hotels, generating PDF
    */

    /*Person List school*/
    Route::get('/personlist/school',  [
        'as' => 'personlistSchool', 'uses' => 'SchoolController@index'
    ]);

    /*PDF generator for school*/
    Route::post('/personlist/school/pdf',  [
        'as' => 'schoolPdfGenerate', 'uses' => 'SchoolController@download'
    ]);

    /*Person List hotel*/
    Route::get('/personlist/hotel',  [
        'as' => 'personlistHotel', 'uses' => 'HotelController@index'
    ]);

    /*PDF generator for hotel*/
    Route::post('/personlist/hotel/pdf',  [
        'as' => 'hotelPdfGenerate', 'uses' => 'HotelController@download'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    | Listing booking and profit analyze
    */

    /*Line graph for Booking analyze*/
    Route::get('/statistics/booking',  [
        'as' => 'statisticsBooking', 'uses' => 'BookinganalyzeController@index'
    ]);

    /*Line graph for Booking analyze between dates*/
    Route::post('/statistics/booking/show',  [
        'as' => 'statisticsBookingShow', 'uses' => 'BookinganalyzeController@show'
    ]);

    /*Line graph for Profit analyze*/
    Route::get('/statistics/profit',  [
        'as' => 'statisticsProfit', 'uses' => 'ProfitanalyzeController@index'
    ]);

    /*Line graph for profit analyze between dated*/
    Route::post('/statistics/profit/show',  [
        'as' => 'statisticsProfitShow', 'uses' => 'ProfitanalyzeController@show'
    ]);

    //Settings
    Route::group(['prefix' => 'settings'], function () {

        Route::get('/', [
            'as' => 'admin.settings.index', 'uses' => 'SettingsController@index'
        ]);

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'SettingsController@postSocial'
        ]);

    });


});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
| Guest routes cannot be accessed if the user is already logged in.
| He will be redirected to '/" if he's logged in.
|
*/

Route::group(['middleware' => 'guest'], function () {

    Route::get('login', [
        'as' => 'login', 'uses' => 'AuthController@login'
    ]);

    Route::get('register', [
        'as' => 'register', 'uses' => 'AuthController@register'
    ]);

    Route::post('login', [
        'as' => 'login.post', 'uses' => 'AuthController@postLogin'
    ]);

});

Route::get('/test_bday', 'CronjobController@sendBirthdayGreetings');
Route::get('/test_noti', 'BookingController@sendCourseNotifiation');
Route::get('/test_reminder', 'CronjobController@sendPaymentReminder');
Route::get('/test_welcome', 'CronjobController@sendWelcomeBackMail');

Route::get('logout', [
    'as' => 'logout', 'uses' => 'AuthController@logout'
]);
/* For testing email template */
/*Route::get('/testmail', function(){
    Mail::send('admin.emails.testEmail', ['subject' => 'Testing Email Template'], function ($message) {
        $message->from('server@regensburg-it.de', 'FCGCRM');
        $message->to(env('APP_EMAIL'))->subject('Testing Email Template');
    });
});*/