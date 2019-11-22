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

        // CRUD Sinh viên
        $router->get('/','Student\StudentController@getAll');
        $router->get('/{id}','Student\StudentController@getSingle');
        $router->post('/','Student\StudentController@create');
        $router->put('/{id}','Student\StudentController@update');
        $router->delete('/{id}','Student\StudentController@delete');
        
        // them sinh vien dang ky thuc tap
        $router->post('/create-register','Student\StudentRegisterController@create');
        
    });

    // code phần leader
    $router->group(['prefix'=>'leader'],function() use ($router){
         // CRUD leader
         $router->get('/','Leader\LeaderController@getAll');
         $router->get('/{id}','Leader\LeaderController@getSingle');
         $router->post('/','Leader\LeaderController@create');
         $router->put('/{id}','Leader\LeaderController@update');
         $router->delete('/{id}','Leader\LeaderController@delete');
    });

    //code phần doanh nghiệp
    $router->group(['prefix'=>'company'],function() use ($router){
        $router->get('/', ['uses' => 'Company\CompanyController@show']);
        $router->get('/{id}', ['uses' => 'Company\CompanyController@showOne']);
        $router->post('/', ['uses' => 'Company\CompanyController@create']);
        $router->put('/{id}',['uses' => 'Company\CompanyController@update']);
        $router->delete('/{id}',['uses' => 'Company\CompanyController@delete']);

    });

    // code phần đề tài
    $router->group(['prefix'=>'topic'],function() use ($router){
        // Bá code
        $router->get('/',['uses'=>'Topic\TopicController@show','as'=>'admin.topic.show'] );
        $router->get('/{id:[0-9]+}',['uses'=>'Topic\TopicController@showOne','as'=>'admin.topic.showOne']);
        $router->post('/', ['uses'=>'Topic\TopicController@create','as'=>'admin.topic.create']);
        $router->put('/{id:[0-9]+}', ['uses'=>'Topic\TopicController@edit','as'=>'admin.topic.edit']);
        $router->delete('/{id: [0-9]+}', ['uses'=>'Topic\TopicController@destroy','as'=>'admin.topic.destroy']);
    });
    //code phần viện
    $router->group(['prefix'=>'academy'], function () use ($router){
        $router->get('/',['uses'=>'Academy\AcademyController@show','as'=>'admin.academy.show']);
        $router->get('/{id:[0-9]+}',['uses'=>'Academy\AcademyController@showOne','as'=>'admin.academy.showOne']);
        $router->post('/',['uses'=>'Academy\AcademyController@create','as'=>'admin.acdemy.create']);
        $router->put('/{id:[0-9]+}', ['uses'=>'Academy\AcademyController@edit','as'=>'admin.academy.edit']);
        $router->delete('/{id: [0-9]+}', ['uses'=>'Academy\AcademyController@destroy','as'=>'admin.academy.destroy']);
    });
    //code phần khoa
    $router->group(['prefix'=>'specialized'], function () use ($router){
        $router->get('/',['uses'=>'Specialized\SpecializedController@show','as'=>'admin.specialized.show']);
        $router->get('/{id:[0-9]+}',['uses'=>'Specialized\SpecializedController@showOne','as'=>'admin.specialized.showOne']);
        $router->post('/',['uses'=>'Specialized\SpecializedController@create','as'=>'admin.specialized.create']);
        $router->put('/{id:[0-9]+}', ['uses'=>'Specialized\SpecializedController@edit','as'=>'admin.specialized.edit']);
        $router->delete('/{id: [0-9]+}', ['uses'=>'Specialized\SpecializedController@destroy','as'=>'admin.specialized.destroy']);
    });
    //code phần khóa học
    $router->group(['prefix'=>'course'], function () use ($router){
        $router->get('/',['uses'=>'Course\CourseController@show','as'=>'admin.course.show']);
        $router->get('/{id:[0-9]+}',['uses'=>'Course\CourseController@showOne','as'=>'admin.course.showOne']);
        $router->post('/',['uses'=>'Course\CourseController@create','as'=>'admin.course.create']);
        $router->put('/{id:[0-9]+}', ['uses'=>'Course\CourseController@edit','as'=>'admin.course.edit']);
        $router->delete('/{id: [0-9]+}', ['uses'=>'Course\CourseController@destroy','as'=>'admin.course.destroy']);
    });
    //code phần loại thực tập
    $router->group(['prefix'=>'internship_type'], function () use ($router){
        $router->get('/',['uses'=>'Internship_Type\Internship_TypeController@show','as'=>'admin.internship_type.show']);
        $router->get('/{id:[0-9]+}',['uses'=>'Internship_Type\Internship_TypeController@showOne','as'=>'admin.internship_type.showOne']);
        $router->post('/',['uses'=>'Internship_Type\Internship_TypeController@create','as'=>'admin.internship_type.create']);
        $router->put('/{id:[0-9]+}', ['uses'=>'Internship_Type\Internship_TypeController@edit','as'=>'admin.internship_type.edit']);
        $router->delete('/{id: [0-9]+}', ['uses'=>'Internship_Type\Internship_TypeController@destroy','as'=>'admin.internship_type.destroy']);
    });


});