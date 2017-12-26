<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route:: get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');

// 如果想让路由完全匹配，不然就不会走到下面这个：id的路由，不会执行getComplexOne，这时就需要修改config.php的配置文件，
// 将route_complete_match修改成true
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

// 路由分组
Route::group('api/:version/product', function () {
   Route::get('/by_category', 'api/:version.Product/getAllInCategory');
   Route::get('/recent', 'api/:version.Product/getRecent');
   //路由必须匹配是数字才会走这个路由，否则就会和recent冲突
   Route::get('/:id', 'api/:version.Product/getOne', [], ['id'=>'\d+']);

});

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

// 获取令牌用post，安全性稍微比get强一些
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');

Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');




























