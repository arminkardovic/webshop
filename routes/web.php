<?php
Route::get('/user/verify/{token}', 'Auth\RegisterController@activateUser');
Route::get('/user/resend/{email}', 'Auth\RegisterController@resendActivationMail');

Route::get('/', "IndexController@index");

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/product/{id}', "ProductController@index")->name("product.single");
Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::get('/profile', 'ProfileController@index')->name('home');
Route::post('/users/update-profile', 'ProfileController@updateProfile')->name('update-profile');
Route::get('/getCollapseCartHtml', 'CheckoutController@getCollapseCartHtml');
Route::get('/getCollapseInnerCartHtml', 'CheckoutController@getCollapseInnerCartHtml');
Route::get('/getCartTotal', 'CheckoutController@getCartTotal')->name('getCartTotal');
Route::post('/addToFavorites', 'ProductController@addToFavorites')->name('addToFavorites')->middleware('api');
Route::post('/removeFromFavorites', 'ProductController@removeFromFavorites')->name('removeFromFavorites')->middleware('api');
Route::post('/checkout', 'CheckoutController@previewWithCouponCode')->name('previewWithCouponCode');

Route::get('/{category}', "CategoryController@index");


Route::get('{category}/{page}', function ($category = null, $page = null) {
    echo "<h1>Category: $category</h1>";
    echo "<h1>$page: $page</h1>";
})->where('page', '0-9+');

Route::get('{category}/{subcategory}', function ($category = null, $subcategory = null) {
    echo "<h1>Category: $category</h1>";
    echo "<h1>SubCategory: $subcategory</h1>";
});

Route::get('{category}/{subcategory}/{article}', function ($category = null, $subcategory = null, $article = null) {
    echo "<h1>Category: $category</h1>";
    echo "<h1>SubCategory: $subcategory</h1>";
    echo "<h1>Article: $article</h1>";
});
Route::get('{category}/{subcategory}/{id}', function ($category = null, $subcategory = null, $id = null) {
    echo "<h1>Category: $category</h1>";
    echo "<h1>SubCategory: $subcategory</h1>";
    echo "<h1>ID: $id</h1>";
})->where('id', '0-9+');

//Route::get('/login/{social}', 'Auth\LoginController@socialLogin')->where('social', 'twitter|facebook|linkedin|google|github|bitbucket');
//Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'twitter|facebook|linkedin|google|github|bitbucket');


