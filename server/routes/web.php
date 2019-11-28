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
$router->group(['prefix' => 'api'], function () use ($router) {

    // code phần người hướng dẫn
    $router->group(['prefix' => 'instructor'], function () use ($router) {
        $router->get('/', 'Instructor\InstructorController@getAll');
        $router->get('/{id}', 'Instructor\InstructorController@getOne');
        $router->post('/', 'Instructor\InstructorController@create');
        $router->put('/{id}', 'Instructor\InstructorController@update');
        $router->delete('/{id}', 'Instructor\InstructorController@delete');
    });
    // code phần giáo viên
    $router->group(['prefix' => 'teacher'], function () use ($router) {
        $router->get('/{subject:[0-9]+}', 'Teacher\UserController@showAllTeachers');
        $router->get('one/{id:[0-9]+}', 'Teacher\UserController@showOneTeachers');
        $router->post('/', 'Teacher\UserController@create');
        $router->put('/{id:[0-9]+}', 'Teacher\UserController@update');
        $router->delete('/{id:[0-9]+}', 'Teacher\UserController@delete');
    });

    // code phần môn học
    $router->group(['prefix' => 'subject'], function () use ($router) {
        $router->get('/', 'Subject\SubjectController@show');
        $router->get('/{id}', 'Subject\SubjectController@showOne');
        $router->post('/', 'Subject\SubjectController@create');
        $router->put('/{id}', 'Subject\SubjectController@edit');
        $router->delete('/{id}', 'Subject\SubjectController@destroy');
    });

    // code phần chức vụ
    $router->group(['prefix' => 'position'], function () use ($router) {
        $router->get('/{subject}/{id}', 'Position\PositionController@show');
        $router->get('/{id:[0-9]+}', 'Position\PositionController@showOne');
        $router->get('create/{subject}/{id}', 'Position\PositionController@getCreate');
        $router->post('/', 'Position\PositionController@create');
        $router->put('/{id}', 'Position\PositionController@edit');
        $router->delete('/{id}', 'Position\PositionController@destroy');

        //position type
        $router->get('type', 'Position\PositionTypeController@getAll');
    });


    // code phần doanh nghiệp/instructor
    $router->group(['prefix' => 'company'], function () use ($router) {
        $router->get('/', 'Company\UserController@show');
        $router->get('/{id}', 'Company\UserController@showOne');
        $router->post('/', 'Company\UserController@create');
        $router->put('{id}', 'Company\UserController@update');
        $router->delete('{id}', 'Company\UserController@delete');
    });
    // code phần đăng kí doanh nghiệp
    $router->group(['prefix' => 'companyreg'], function () use ($router) {
        $router->get('/{id}', 'Company\CompanyRegController@show');
        $router->get('create/{id}', 'Company\CompanyRegController@getCompany');
        $router->get('one/{id}', 'Company\CompanyRegController@showOne');
        $router->post('/', 'Company\CompanyRegController@create');
        $router->put('/{id}', 'Company\CompanyRegController@update');
        $router->delete('/{id}', 'Company\CompanyRegController@delete');
        $router->get('/search/company/reg', 'Company\CompanyRegController@search');
    });

    //đăng ký sinh viên
    $router->group(['prefix' => 'student'], function () use ($router) {
        $router->get('/', [
            'middleware' => 'isStudent',
            'uses'       => 'Student\UserController@getAll'
        ]);
        $router->get('/{id}', [
            'middleware' => 'isTrainningAssistant',
            'uses'       => 'Student\UserController@getSingle'
        ]);
        $router->post('/', 'Student\UserController@create');
        $router->put('{id}', 'Student\UserController@update');
        $router->delete('{id}', 'Student\UserController@delete');

        // sinh vien dang ky thuc tap lọc qua internship_time
        $router->get('reg/{id}', 'Student\StudentController@getAll');
        $router->get('reg-one/{id}', 'Student\StudentController@getOne');
        $router->post('reg', 'Student\StudentController@create');
        $router->put('reg/{id}', 'Student\StudentController@update');
        $router->delete('reg/{id}', 'Student\StudentController@delete');
    });

    // code phần đề tài
    $router->group(['prefix' => 'topic'], function () use ($router) {
        // Bá code
        $router->get('/{type:[0-9]+}', ['uses' => 'Topic\TopicController@show', 'as' => 'admin.topic.show']);
        $router->get('one/{id:[0-9]+}', ['uses' => 'Topic\TopicController@showOne', 'as' => 'admin.topic.showOne']);
        $router->post('/', ['uses' => 'Topic\TopicController@create', 'as' => 'admin.topic.create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Topic\TopicController@edit', 'as' => 'admin.topic.edit']);
        $router->delete('/{id: [0-9]+}', ['uses' => 'Topic\TopicController@destroy', 'as' => 'admin.topic.destroy']);
    });

    //code phần loại thực tập
    $router->group(['prefix' => 'internship_type'], function () use ($router) {
        $router->get('/', ['uses' => 'Internship\Internship_TypeController@show', 'as' => 'admin.internship_type.show']);
        $router->get('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TypeController@showOne', 'as' => 'admin.internship_type.showOne']);
        $router->post('/', ['uses' => 'Internship\Internship_TypeController@create', 'as' => 'admin.internship_type.create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TypeController@edit', 'as' => 'admin.internship_type.edit']);
        $router->delete('/{id: [0-9]+}', ['uses' => 'Internship\Internship_TypeController@destroy', 'as' => 'admin.internship_type.destroy']);
    });
    //    thời gian thực tập
    $router->group(['prefix' => 'internship_time'], function () use ($router) {
        $router->get('/{id}', ['uses' => 'Internship\Internship_TimeController@show']);
        $router->get('one/{id:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@showOne']);
        $router->post('/', ['uses' => 'Internship\Internship_TimeController@create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@edit']);
        $router->delete('/{type:[0-9]+}/{time:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@destroy']);
    });

    //  Xác thực User 
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/login', ['uses' => 'Auth\AuthController@login']);
    });
});
