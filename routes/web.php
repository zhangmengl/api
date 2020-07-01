<?php

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
    return view('welcome');
});


Route::prefix('api')->group(function () {
    Route::get('/test/info','Api\TestController@info');//接口测试
    Route::get('/test/receive','Api\TestController@receive');//接收数据
    Route::post('/test/receivePost','Api\TestController@receivePost');//接收数据  post
    Route::post('/test/decrypt','Api\TestController@decrypt');//对称加密 --解密
    Route::get('/test/rsaDecrypt','Api\TestController@rsaDecrypt');//非对称加密
    Route::get('/test/verify1','Api\TestController@verify1');//非对称加密  --签名
});