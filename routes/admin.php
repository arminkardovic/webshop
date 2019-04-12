<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 19:29
 */

// Admin Interface

Route::post('attribute-sets/list-attribute-combinations', ['as' => 'getAttrCombinationsBySetId', 'uses' => 'AttributeSetCrudController@ajaxGetAttributesCombinations']);
Route::post('products/create-prices-table', ['as' => 'getCreateProductPricesTable', 'uses' => 'ProductCrudController@getCreateProductPricesTable']);
Route::post('products/update-prices-table', ['as' => 'getUpdateProductPricesTable', 'uses' => 'ProductCrudController@getUpdateProductPricesTable']);

CRUD::resource('categories', 'CategoryCrudController');
CRUD::resource('currencies', 'CurrencyCrudController');
CRUD::resource('carriers', 'CarrierCrudController');
CRUD::resource('attributes', 'AttributeCrudController');
CRUD::resource('attributes-sets', 'AttributeSetCrudController');
CRUD::resource('products', 'ProductCrudController');
CRUD::resource('taxes', 'TaxCrudController');
CRUD::resource('orders', 'OrderCrudController');
CRUD::resource('order-statuses', 'OrderStatusCrudController');
CRUD::resource('clients', 'ClientCrudController');
CRUD::resource('users', 'UserCrudController');
CRUD::resource('cart-rules', 'CartRuleCrudController');
CRUD::resource('specific-prices', 'SpecificPriceCrudController');
CRUD::resource('notification-templates', 'NotificationTemplateCrudController');
CRUD::resource('gift-cards', 'GiftCardCrudController');

// Clone Products
Route::post('products/clone', ['as' => 'clone.product', 'uses' => 'ProductCrudController@cloneProduct']);
// Update Order Status
Route::post('orders/update-status', ['as' => 'updateOrderStatus', 'uses' => 'OrderCrudController@updateStatus']);


