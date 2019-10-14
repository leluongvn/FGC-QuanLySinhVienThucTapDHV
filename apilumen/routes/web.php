<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
 - code api
 - yêu cầu các bạn sau mỗi dòng code phải có chú thích vào

-VD:
 - tạo để tài mới
 $router->get('detai',['uses'=>'detaiController@create']);
*/
$router->group(['prefix'=>'api'],function() use ($router){

    // code phần giáo viên
    $router->group(['prefix'=>'giaovien'],function() use ($router){
        // mại code

    });
    // code phần sinh viên
    $router->group(['prefix'=>'sinhvien'],function() use ($router){
        $router->get('get/all','SinhVien\SinhVienController@getAll');
        $router->get('get/{id}','SinhVien\SinhVienController@getSingle');
        $router->post('create','SinhVien\SinhVienController@create');
        $router->put('update/{id}','SinhVien\SinhVienController@update');
        $router->delete('delete/{id}','SinhVien\SinhVienController@delete');

    });

    //code phần doanh nghiệp
    $router->group(['prefix'=>'doanhnghiep'],function() use ($router){
        $router->get('show','DoanhNghiep\DoanhNghiepController@show');
        $router->get('show/{id}','DoanhNghiep\DoanhNghiepController@showOne');
        $router->post('/create','DoanhNghiep\DoanhNghiepController@create');
        $router->put('update/{id}','DoanhNghiep\DoanhNghiepController@update');
        $router->delete('delete/{id}','DoanhNghiep\DoanhNghiepController@delete');

    });

    // code phần đề tài
    $router->group(['prefix'=>'detai'],function() use ($router){
        // Bá code
        $router->get('show',['uses'=>'DeTai\DetaiController@show','as'=>'admin.topic.show'] );
        $router->get('showOne/{id:[0-9]+}',['uses'=>'DeTai\DetaiController@showOne','as'=>'admin.topic.showOne']);
        $router->post('create', ['uses'=>'DeTai\DeTaiController@create','as'=>'admin.topic.create']);
        $router->put('edit/{id:[0-9]+}', ['uses'=>'DeTai\DeTaiController@edit','as'=>'admin.topic.edit']);
        $router->delete('delete/{id: [0-9]+}', ['uses'=>'DeTai\DetaiController@destroy','as'=>'admin.topic.destroy']);
    });
});