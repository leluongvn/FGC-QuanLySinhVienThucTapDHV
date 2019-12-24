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
    // gửi mail

    $router->post('/sendmail', 'Mail\MailController@sendMail');


    // code phần người hướng dẫn
    $router->group(['prefix' => 'instructor'], function () use ($router) {
        $router->get('/{id}/{time}', ['middleware' => 'auth', 'uses' => 'Instructor\InstructorController@getAll']);
        $router->get('/{id}', 'Instructor\InstructorController@getOne');
        $router->post('/', 'Instructor\InstructorController@create');
        $router->put('/{id}', 'Instructor\InstructorController@update');
        $router->delete('/{id}', 'Instructor\InstructorController@delete');

    });


    // code phần giáo viên
    $router->group(['prefix' => 'teacher'], function () use ($router) {
        $router->get('/{subject}', ['middleware' => 'auth', 'uses' => 'Teacher\UserController@showAllTeachers']);
        $router->get('/', ['middleware' => 'auth', 'uses' => 'Teacher\UserController@getTeachers']);
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


    // code phần doanh nghiệp
    $router->group(['prefix' => 'company'], function () use ($router) {
        $router->get('/', 'Company\UserController@show');
        $router->get('/{id}', 'Company\UserController@showOne');
        $router->post('/', 'Company\UserController@create');
        $router->put('{id}', 'Company\UserController@update');
        $router->delete('{id}', 'Company\UserController@delete');

        // đăng kí doanh nghiệp theo internship_time
        $router->get('/reg/list/{id:[0-9]+}', 'Company\CompanyRegController@getAll');
        $router->get('/reg/{id:[0-9]+}', 'Company\CompanyRegController@getReg');
        $router->post('/reg', 'Company\CompanyRegController@create');
        $router->put('/reg/{id}', 'Company\CompanyRegController@update');
        $router->delete('/reg/{id}', 'Company\CompanyRegController@delete');
    });
    // code phần đăng kí doanh nghiệp
    $router->group(['prefix' => 'internship_company'], function () use ($router) {
        $router->get('/{id}', 'Internship\Internship_CompanyController@show');
        $router->get('create/{id}', 'Internship\Internship_CompanyController@getCompany');
        $router->get('one/{id}', 'Internship\Internship_CompanyController@showOne');
        $router->post('/', 'Internship\Internship_CompanyController@create');
        $router->put('/{id}', 'Internship\Internship_CompanyController@update');
        $router->delete('/{id}', 'Internship\Internship_CompanyController@delete');
        $router->get('/search/company/reg', 'Internship\Internship_CompanyController@search');
    });
    //đăng ký sinh viên
    $router->group(['prefix' => 'student'], function () use ($router) {
        $router->get('/', ['uses' => 'Student\UserController@getAll']);
        $router->get('/{id}', 'Student\UserController@getSingle');
        $router->post('/', 'Student\UserController@create');
        $router->put('{id}', 'Student\UserController@update');
        $router->delete('{id}', 'Student\UserController@delete');

        // sinh vien dang ky thuc tap lọc qua internship_time
        $router->get('reg/{time}/{subject}', 'Student\StudentController@getAll');
        $router->get('not-instructor/{time}/{subject}', 'Student\StudentController@getNotInstructor');
        $router->get('reg-one/{id}', 'Student\StudentController@getOne');
        $router->get('not-reg/{id}', 'Student\UserController@getNotReg');
        $router->post('reg', 'Student\StudentController@create');
        $router->put('reg/{id}', 'Student\StudentController@update');
        $router->delete('reg/{id}', 'Student\StudentController@delete');
    });

    // code phần đề tài
    $router->group(['prefix' => 'topic'], function () use ($router) {
        // Bá code
        $router->get('/{type:[0-9]+}', ['uses' => 'Topic\TopicController@show']);
        $router->get('one/{id:[0-9]+}', ['uses' => 'Topic\TopicController@showOne']);
        $router->get('download/{id:[0-9]+}', ['uses' => 'Topic\TopicController@download']);
        $router->post('/', ['uses' => 'Topic\TopicController@create']);
        $router->post('/{id:[0-9]+}', ['uses' => 'Topic\TopicController@file']);
        $router->put('status/{id:[0-9]+}', ['uses' => 'Topic\TopicController@status']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Topic\TopicController@edit']);
        $router->delete('/{id: [0-9]+}', ['uses' => 'Topic\TopicController@destroy']);

        // Đăng ký thực tập
        $router->get('reg/{reg:[0-9]+}/{time:[0-9]+}',['uses' => 'Topic\RegController@show']);
    });

    //code phần loại thực tập
    $router->group(['prefix' => 'internship_type'], function () use ($router) {
        $router->get('/', ['uses' => 'Internship\Internship_TypeController@show', 'as' => 'admin.internship_type.show']);
        $router->get('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TypeController@showOne', 'as' => 'admin.internship_type.showOne']);
        $router->post('/', ['uses' => 'Internship\Internship_TypeController@create', 'as' => 'admin.internship_type.create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TypeController@edit', 'as' => 'admin.internship_type.edit']);
        $router->delete('/{id: [0-9]+}', ['uses' => 'Internship\Internship_TypeController@destroy', 'as' => 'admin.internship_type.destroy']);
    });

    //thời gian thực tập
    $router->group(['prefix' => 'internship_time'], function () use ($router) {
        $router->get('/{id}', ['uses' => 'Internship\Internship_TimeController@show']);
        $router->get('/', ['middleware' => 'auth', 'uses' => 'Internship\Internship_TimeController@getTime']);
        $router->get('one/{id:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@showOne']);
        $router->post('/', ['uses' => 'Internship\Internship_TimeController@create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@edit']);
        $router->delete('/{type:[0-9]+}/{time:[0-9]+}', ['uses' => 'Internship\Internship_TimeController@destroy']);
    });

    //Đề tài thực tập
    $router->group(['prefix' => 'internship_topic'], function () use ($router) {
        $router->get('/{id}', ['middleware' => 'auth', 'uses' => 'Internship\Internship_TopicController@show']);
        $router->get('getCreate/{id}', ['uses' => 'Internship\Internship_TopicController@getTopic']);
        $router->post('/', ['uses' => 'Internship\Internship_TopicController@create']);
        $router->put('/{id:[0-9]+}', ['uses' => 'Internship\Internship_TopicController@edit']);
        $router->delete('/{id}', ['uses' => 'Internship\Internship_TopicController@destroy']);
    });

    //Đề tài thực tập
    $router->group(['prefix' => 'internship_point'], function () use ($router) {
        $router->get('/{id:[0-9]+}', ['uses' => 'Internship\Internship_PointController@show']);
    });

    //  Xác thực User
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/login', ['uses' => 'Auth\AuthController@login']);
    });

});