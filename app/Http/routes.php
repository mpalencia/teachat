<?php

Route::group(array('middleware' => 'guest'), function () {

    /*
    |--------------------------------------------------------------------------
    | Login Route
    |--------------------------------------------------------------------------
     */

    Route::get('/login', 'LoginController@index');
    Route::post('/login/authenticate', 'LoginController@authenticate');

    /*
    |--------------------------------------------------------------------------
    | Password Reset Route
    |--------------------------------------------------------------------------
     */

    Route::post('/password/reset', 'Auth\PasswordController@reset');

    /*
    |--------------------------------------------------------------------------
    | Home Page Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('namespace' => 'HomePage'), function () {
        Route::get('/', 'HomeController@index');
        Route::get('terms-of-use', 'HomeController@getTermsOfUse');
        Route::get('privacy-policy', 'HomeController@getPrivacyPolicy');
        Route::get('contact-us', 'ContactUsController@index');
        Route::post('contact-us/send', 'ContactUsController@send');
        Route::get('registration', 'RegistrationController@index');
        Route::post('registration/register', 'RegistrationController@store');
        Route::get('registration/activate/{verification_code}', 'RegistrationController@activate');
    });
});

Route::group(array('middleware' => 'auth'), function () {
    /*
    |--------------------------------------------------------------------------
    | Teachers Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('middleware' => 'teachers', 'namespace' => 'Teacher'), function () {
        /* Dashboard */
        Route::get('teacher/dashboard', 'DashboardController@index');

        /* Subjects */
        Route::get('teacher/subjects/getAll', 'SubjectsController@getAll');
        Route::resource('teacher/subjects', 'SubjectsController', ['except' => ['create', 'edit', 'show']]);

        Route::resource('teacher/announcements', 'AnnouncementsController', ['except' => 'show']);
        Route::get('teacher/announcements/getAll', 'AnnouncementsController@getAll');
        Route::get('teacher/announcements/get/{announcement_id}', 'AnnouncementsController@get');
        Route::post('teacher/appointments/updateByAttributes', 'AppointmentsController@updateByAttributes');
    });

    /*
    |--------------------------------------------------------------------------
    | Parents Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('middleware' => 'parents', 'namespace' => 'Parent'), function () {
        /* Dashboard */
        Route::get('parent/dashboard', 'DashboardController@index');

        /* Children */
        /* Route::get('parent/children/getAll', 'SubjectsController@getAll');*/
        Route::resource('parent/child', 'ChildrenController', ['except' => ['store', 'destroy', 'update', 'show']]);
        Route::post('parent/child/store', 'ChildrenController@store');
/*
Route::resource('parent/announcements', 'AnnouncementsController', ['except' => 'show']);
Route::get('parent/announcements/getAll', 'AnnouncementsController@getAll');
Route::get('parent/announcements/get/{announcement_id}', 'AnnouncementsController@get');
Route::post('parent/appointments/updateByAttributes', 'AppointmentsController@updateByAttributes');*/
    });

    /*
    |--------------------------------------------------------------------------
    | Shool Admin Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('middleware' => 'school-admin', 'namespace' => 'SchoolAdmin'), function () {
        /* Dashboard */
        Route::get('school-admin/dashboard', 'DashboardController@index');

        /* Subject Category */
        Route::get('school-admin/subject-category/getAll', 'SubjectCategoryController@getAll');
        Route::get('school-admin/subject-category', 'SubjectCategoryController@index');
        Route::post('school-admin/subject-category/store', 'SubjectCategoryController@store');
        Route::put('school-admin/subject-category/edit/{subject_category_id}', 'SubjectCategoryController@edit');
        Route::delete('school-admin/subject-category/delete/{subject_category_id}', 'SubjectCategoryController@delete');

        /* Grades */
        Route::get('school-admin/grades/getAll', 'GradesController@getAll');
        Route::get('school-admin/grades', 'GradesController@index');
        Route::post('school-admin/grades/store', 'GradesController@store');
        Route::put('school-admin/grades/edit/{grade_id}', 'GradesController@edit');
        Route::delete('school-admin/grades/delete/{grade_id}', 'GradesController@destroy');

        /* Curriculum */
        Route::resource('school-admin/curriculum', 'CurriculumController', ['except' => 'show']);
        Route::get('school-admin/curriculum/getAll', 'CurriculumController@getAll');

        /* Announcements */
        Route::resource('school-admin/announcements', 'AnnouncementsController', ['except' => 'show']);
        Route::get('school-admin/announcements/getAll', 'AnnouncementsController@getAll');

        /* Teachers */
        Route::resource('school-admin/teachers', 'TeachersController', ['except' => 'show']);
        Route::get('school-admin/teachers/getAll', 'TeachersController@getAll');
        Route::get('school-admin/teachers/get/{parent_id}', 'TeachersController@get');

        /* Parents */
        Route::resource('school-admin/parents', 'ParentsController');
        Route::get('school-admin/parents/getAll', 'ParentsController@getAll');
        Route::get('school-admin/parents/get/{parent_id}', 'ParentsController@get');
        Route::get('school-admin/parents/students/getChild/{parent_id}', 'ParentsController@getChild');
        Route::get('school-admin/parents/students/getAllChildren/{parent_id}', 'ParentsController@getAllChildren');
        Route::put('school-admin/parents/students/updateChild/{child_id}', 'ParentsController@updateChild');

    });

    Route::get('logout', 'LoginController@logout');
});
