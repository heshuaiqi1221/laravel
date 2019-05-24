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

// Route::get('/', function () {
// 	// session(['uid'=>8]);
// 	// request()->session()->forget('uid');
//     return view('welcome',['name'=>"开能"]);
// });
// Route::view('/','welcome',['name'=>"开能"]);

//只允许get方式请求
// Route::get('/goods',function(){
//     return 123;
// });

//只允许post方式请求发送手动邮件
Route::get('/from',function(){
    return "<form action='/brand/email' method='post'>".csrf_field()."<input type=text name=email><button>提交</button></form>";
});
Route::post('/brand/email','admin\BrandController@sendemail');

//手动登录验证
Route::get('/from',function(){
    return "<form action='/brand/login' method='post'>".csrf_field()."<input type=text name=email><input type=password name=password><button>提交</button></form>";
});
Route::post('/brand/login','admin\BrandController@login');
//允许post和get请求
// Route::match(['get','post'],'/from_do',function(){
//     return request()->name;
// });
// Route::any('/from_do',function(){
//     return request()->name;
// });

//路由传参/多个参数
// Route::get('/goods/{d_id}/{id}',function($d_id,$id){
//     echo $d_id.'-'.$id;
// });

//路由传可选参数
// Route::get('/goods/{id?}',function($id=0){
//     echo $id;
//     return '开能';
// });

//路由的正则限制
Route::get('/goods/{id}',function($id){
    return $id;
})->where(['id'=>'\d+']);

//控制器响应路由
Route::get('/goods','Goods@index');


//品牌路由分组
//checklogin/auth.basic
//->middleware(['checklogin'])
Route::prefix('/brand')->group(function(){
	Route::get('add','admin\BrandController@create');
	Route::post('doadd','admin\BrandController@store');
	Route::any('show/{brand_id}','admin\BrandController@show');
	Route::get('lists','admin\BrandController@index');
	Route::get('del/{brand_id}','admin\BrandController@destroy');
	Route::get('edit/{brand_id}','admin\BrandController@edit');
});

//管理员路由分组
Route::prefix('/admin')->group(function(){
	Route::get('add','admin\AdminController@create');
	Route::post('doadd','admin\AdminController@store');
	Route::get('lists','admin\AdminController@index');
	Route::get('del/{admin_id}','admin\AdminController@destroy');
	Route::get('edit/{admin_id}','admin\AdminController@edit');
});

//分类路由分组
Route::prefix('/category')->group(function(){
	Route::get('add','admin\CategoryController@create');
	Route::post('doadd','admin\CategoryController@store');
	Route::get('lists','admin\CategoryController@index');
});

//文章路由分组
Route::prefix('/article')->group(function(){
	Route::get('add','admin\ArticleController@create');
	Route::post('doadd','admin\ArticleController@store');
	Route::get('lists','admin\ArticleController@index');
	Route::any('destroy','admin\ArticleController@destroy');
	Route::get('edit/{article_id}','admin\ArticleController@edit');
	Route::get('update/{article_id}','admin\ArticleController@update');
});
//move
Route::prefix('/move')->group(function(){
	Route::get('add','admin\MoveController@create');
	Route::post('add_do','admin\MoveController@store');
	Route::get('lists','admin\MoveController@index');
	Route::post('destroy','admin\MoveController@destroy');
	Route::get('edit/{move_id}','admin\MoveController@edit');
	Route::post('update/{move_id}','admin\MoveController@update');
	Route::post('checkName','admin\MoveController@checkName');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/','Index\IndexController@index');
//登录注册
Route::prefix('/index/login')->group(function(){
	Route::get('login','Index\LoginController@login');
	Route::post('loginDo','Index\LoginController@loginDo');
	Route::get('register','Index\LoginController@register');
	Route::post('sendCode','Index\LoginController@sendCode');
	Route::post('checkName','Index\LoginController@checkName');
	Route::post('checkYzm','Index\LoginController@checkYzm');
	Route::post('registerDo','Index\LoginController@registerDo');
});
//商品详情
Route::prefix('/index/goods')->group(function(){
	Route::get('proinfo/{goods_id}','Index\GoodsController@proinfo');
	Route::post('addcar','Index\GoodsController@addcar');
	Route::any('critical','Index\GoodsController@critical');
});
//购物车
Route::prefix('/index/car')->group(function(){
	Route::any('car','Index\CarController@car');
	Route::any('changeBuyNumber','Index\CarController@changeBuyNumber');
	Route::any('getSubTotal','Index\CarController@getSubTotal');
	Route::any('cartdel','Index\CarController@cartdel');
	Route::any('getCount','Index\CarController@getCount');
});
// 收货地址
Route::prefix('/index/address')->group(function(){
	Route::get('lists','index\AddressController@lists');
	Route::get('add','index\AddressController@add');
	// 获取区域
	Route::post('getArea','index\AddressController@getArea');
	Route::post('addressdo','index\AddressController@addressdo');
});
//确认结算
Route::prefix('/index/order')->group(function(){
	Route::any('lists','Index\OrderController@lists');
	//提交订单
	Route::any('submitOrder','Index\OrderController@submitOrder');
	//下单成功
	Route::get('successOrder','Index\OrderController@successOrder');
	//pcpay
	Route::get('pcpay', 'Index\OrderController@pcpay');
	Route::get('returnpay', 'Index\OrderController@returnpay');
	Route::post('notifypay', 'Index\OrderController@notifypay');
	//mobile pay
	Route::get('mobilepay', 'Index\OrderController@mobilepay');
	
});

