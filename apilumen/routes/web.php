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

    // code phần người hướng dẫn
    $router->group(['prefix'=>'instructor'],function() use ($router){
        $router->get('get', 'Instructor\InstructorController@showAllInstructor');
        $router->get('get/{id}', 'Instructor\InstructorController@showOneInstructor');
        $router->post('create', 'Instructor\InstructorController@create');
        $router->put('update/{id}', 'Instructor\InstructorController@update');
        $router->delete('delete/{id}', 'Instructor\InstructorController@delete');

    });

    
    // code phần giáo viên
    $router->group(['prefix'=>'teacher'],function() use ($router){
        $router->get('get', 'Teacher\TeacherController@showAllTeachers');
        $router->get('get/{id}', 'Teacher\TeacherController@showOneTeachers');
        $router->post('create', 'Teacher\TeacherController@create');
        $router->put('update/{id}', 'Teacher\TeacherController@update');
        $router->delete('delete/{id}', 'Teacher\TeacherController@delete');

    });


    // code phần sinh viên
    $router->group(['prefix'=>'student'],function() use ($router){
        $router->get('get/all','Student\StudentController@getAll');
        $router->get('get/{id}','Student\StudentController@getSingle');
        $router->post('create','Student\StudentController@create');
        $router->put('update/{id}','Student\StudentController@update');
        $router->delete('delete/{id}','Student\StudentController@delete');

    });

    //code phần doanh nghiệp
    $router->group(['prefix'=>'company'],function() use ($router){
        $router->get('show','Company\CompanyController@show');
        $router->get('show/{id}','Company\CompanyController@showOne');
        $router->post('/create','Company\CompanyController@create');
        $router->put('update/{id}','Company\CompanyController@update');
        $router->delete('delete/{id}','Company\CompanyController@delete');

    });

    // code phần đề tài
    $router->group(['prefix'=>'topic'],function() use ($router){
        // Bá code
        $router->get('show',['uses'=>'Topic\TopicController@show','as'=>'admin.topic.show'] );
        $router->get('showOne/{id:[0-9]+}',['uses'=>'Topic\TopicController@showOne','as'=>'admin.topic.showOne']);
        $router->post('create', ['uses'=>'Topic\TopicController@create','as'=>'admin.topic.create']);
        $router->put('edit/{id:[0-9]+}', ['uses'=>'Topic\TopicController@edit','as'=>'admin.topic.edit']);
        $router->delete('delete/{id: [0-9]+}', ['uses'=>'Topic\TopicController@destroy','as'=>'admin.topic.destroy']);
    });
});