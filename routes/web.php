<?php

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
    return view('welcome');
});

// 小程序接口
Route::get('/login','UserController@login');

// 获取完整的菜单列表
Route::get('/menus', 'MenuController@menu_list');

// 根据菜单类别获取菜品
Route::get('/getDishes/{id}', 'MenuController@menu_dishes');

// 生成订单
Route::get('/createOrder/{userId}', 'MenuController@create_order');

Route::get('/getIndent', 'MenuController@getIndent');

Route::get('/getDetailIndent', 'MenuController@getDetailIndent');

Route::get('/getDishDetail', 'MenuController@getDishDetail');

// 页面
Route::get('/index', 'IndexController@index');
