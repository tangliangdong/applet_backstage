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
Route::get('/app/login','AppController@login');

// 获取完整的菜单列表
Route::get('/app/menus', 'AppController@menu_list');



// 生成订单
Route::get('/app/createOrder/{userId}', 'AppController@create_order');

Route::get('/app/getIndent', 'AppController@getIndent');

Route::get('/app/getDetailIndent', 'AppController@getDetailIndent');

Route::get('/app/getDishDetail', 'AppController@getDishDetail');


// 后台管理页面
Route::get('/index', 'IndexController@index');

Route::get('/menu', 'MenuController@menu');

Route::get('/indent', 'IndentController@indent');

Route::get('/user/usermanage', 'UserController@usermanage');

// 获取所有菜的种类
Route::post('/menu/menu_type', 'MenuController@menu_type');
// 根据菜单类别获取菜品
Route::post('/menu/getDishes', 'MenuController@menu_dishes');

// 根据菜的id来获取彩品
Route::post('/menu/getDish', 'MenuController@getDish');
Route::post('/menu/getMenu', 'MenuController@getMenu');

Route::post('/menu/edit', 'MenuController@edit');
Route::post('/menu/menu_edit', 'MenuController@menu_edit');

// 根据status获取订单列表
Route::post('/indent/getIndentByStatus', 'IndentController@getIndentByStatus');

// 根据订单获取 点的菜
Route::post('/indent/getDishByIndent', 'IndentController@getDishByIndent');

Route::post('/indent/handle', 'IndentController@handle');

Route::post('/indent/complete', 'IndentController@complete');


