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
 //tạo để tài mới
 $router->get('detai',['uses'=>'detaiController@create']);
*/
$router->group(['prefex'=>'api'],function() use ($router){

    // code phần giáo viên
    $router->group(['prefix'=>'giaovien'],function() use ($router){
        // mại code

    });
    // code phần sinh viên
    $router->group(['prefix'=>'sinhvien'],function() use ($router){
        // huy code

    });

    //code phần doanh nghiệp
    $router->group(['prefix'=>'doanhnghiep'],function() use ($router){
        //Đạt code

    });

    // code phần đề tài
    $router->group(['prefix'=>'detai'],function() use ($router){
        // Bá code
        
    });
});