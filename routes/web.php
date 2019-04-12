<?php

Route::get('/', "IndexController@index");


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
