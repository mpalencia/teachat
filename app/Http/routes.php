<?php

Route::group(array('namespace' => 'HomePage'), function () {
    Route::get('terms-of-use', 'HomeController@getTermsOfUse');
    Route::get('privacy-policy', 'HomeController@getPrivacyPolicy');
    Route::get('contact-us', 'ContactUsController@index');
    Route::post('contact-us/send', 'ContactUsController@send');
});

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
        Route::get('registration', 'RegistrationController@index');
        Route::get('registration/country/{country_id}', 'RegistrationController@getStateSchoolByCountryId');
        Route::post('registration/register', 'RegistrationController@store');
        Route::get('registration/activate/{verification_code}', 'RegistrationController@activate');
        /*Add School*/
        Route::get('/add-my-school', 'HomeController@addSchool');
    });
});

Route::group(array('middleware' => 'auth'), function () {
    /*
    |--------------------------------------------------------------------------
    | Teachers Route
    |--------------------------------------------------------------------------
     */

    Route::group(array('middleware' => 'teachers', 'namespace' => 'Teacher'), function () {
        Route::get('teacher/videocall/{usertype}/{user_id}/{session}', 'DashboardController@videocall');
        /* Dashboard */
        Route::get('teacher/dashboard', 'DashboardController@index');
        Route::post('teacher/uploadImage', 'DashboardController@uploadImage');
        Route::post('teacher/uploadAttachment', 'DashboardController@uploadAttachment');

        /* Students */
        Route::resource('teacher/students', 'StudentsController', ['except' => ['create', 'edit', 'show', 'update', 'destroy']]);
        Route::get('teacher/students/get', 'StudentsController@get');
        Route::post('teacher/students/storeAll/{grade_id}/{curriculum_id}', 'StudentsController@storeAll');

        /* Appointments */
        Route::get('teacher/appointments', 'AppointmentsController@index');
        Route::get('teacher/appointments/show/{appointment_id}', 'AppointmentsController@show');
        Route::get('teacher/appointments/create/{parent_id}', 'AppointmentsController@createWithParent');
        Route::post('teacher/appointments/store', 'AppointmentsController@store');
        Route::get('teacher/appointments/{appointment_id}/edit', 'AppointmentsController@edit');
        Route::put('teacher/appointments/update/{appointment_id}', 'AppointmentsController@update');
        Route::get('teacher/appointments/create', 'AppointmentsController@create');
        Route::delete('teacher/appointments/delete/{appointment_id}', 'AppointmentsController@destroy');
        Route::get('teacher/appointments/getAllByTeacher', 'AppointmentsController@getAllByTeacher');
        Route::get('teacher/appointments/getAllBySelectedDate/{selected_date}', 'AppointmentsController@getAllBySelectedDate');
        Route::post('teacher/appointments/updateByAttributes', 'AppointmentsController@updateByAttributes');
        //Route::post('parent/appointments/response/{appointment_id}', 'AppointmentsController@parentResponse');

        /* Subjects */
        Route::get('teacher/subjects/getAll', 'SubjectsController@getAll');
        Route::resource('teacher/subjects', 'SubjectsController', ['except' => ['create', 'edit', 'show']]);
        Route::get('teacher/subjects/add-students/{subject_id}', 'SubjectsController@addStudents');
        Route::get('teacher/subjects/get-children/{subject_id}/{grade_id}', 'ChildrenController@getAllStudents');

        /* Announcements */
        Route::resource('teacher/announcements', 'AnnouncementsController', ['except' => 'show']);
        Route::get('teacher/announcements/getAll', 'AnnouncementsController@getAll');
        Route::get('teacher/announcements/get/{announcement_id}', 'AnnouncementsController@get');

        /* Settings */
        Route::get('teacher/myaccount', 'DashboardController@settings');
        Route::post('teacher/myaccount/update', 'DashboardController@settings_update');
        Route::post('teacher/myaccount/changePassword', 'DashboardController@changePasswords');
        Route::get('teacher/myaccount/country/{country_id}', 'DashboardController@getStateByCountryId');
        Route::post('teacher/resetpassword/forgot', 'DashboardController@changePasswords');

        /* VideoCall */
        // Route::get('teacher/videocall', 'VideoCallController@index');

        /* history */
        Route::get('teacher/history', 'DashboardController@history');

        /* messages */
        Route::get('teacher/messages', 'DashboardController@messages');
        Route::get('teacher/messages/getParentsForMessage', 'DashboardController@getParentsByStudent');
        Route::post('teacher/messages/sendEmailIfOffline', 'DashboardController@sendEmailIfOffline');
    });

    /*
    |--------------------------------------------------------------------------
    | Parents Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('middleware' => 'parents', 'namespace' => 'Parent'), function () {
        /* Dashboard */
        Route::get('parent/dashboard', 'DashboardController@index');
        Route::post('parent/uploadImage', 'DashboardController@uploadImage');
        Route::post('parent/uploadAttachment', 'DashboardController@uploadAttachment');
        Route::get('parent/videocall/{usertype}/{user_id}/{session}', 'DashboardController@videocall');

        /* Children */
        Route::resource('parent/child', 'ChildrenController', ['except' => ['store', 'show']]);
        Route::get('parent/child/create', 'ChildrenController@create');
        Route::post('/parent/child/store', 'ChildrenController@store');
        Route::get('parent/child/{id}/edit', 'ChildrenController@edit');
        Route::post('parent/child/{id}/update', 'ChildrenController@update');
        Route::delete('parent/child/delete/{id}', 'ChildrenController@destroy');
        Route::get('parent/children/teachers/create/{child_id}', 'ChildrenController@addTeachers');
        Route::get('parent/children/teachers/getAll/{subject_id}', 'ChildrenController@getTeachersBySubjectId');
        Route::get('parent/children/teachers/getAllByChild/{child_id}', 'ChildrenController@getTeachersByChildId');
        Route::get('parent/children/teachers/{child_id}', 'ChildrenController@getTeachers');
        Route::post('parent/children/teachers/store', 'ChildrenController@addTeacherToChild');
        Route::get('parent/children/grades/{school_id}', 'ChildrenController@getGradesBySchoolId');

        /* Announcements */
        Route::get('parent/announcements', 'AnnouncementsController@index');
        Route::get('parent/announcements/getAll', 'AnnouncementsController@getAll');
        Route::get('parent/announcements/get/{announcement_id}', 'AnnouncementsController@get');

        /* Appointments */
        Route::get('parent/appointments', 'AppointmentsController@index');
        Route::get('parent/appointments/getAllByParent', 'AppointmentsController@getAllByParent');
        Route::get('parent/appointments/show/{appointment_id}', 'AppointmentsController@show');
        Route::get('parent/appointments/create/{parent_id}', 'AppointmentsController@createWithParent');
        Route::post('parent/appointments/store', 'AppointmentsController@store');
        Route::get('parent/appointments/{appointment_id}/edit', 'AppointmentsController@edit');
        Route::put('parent/appointments/update/{appointment_id}', 'AppointmentsController@update');
        Route::get('parent/appointments/create', 'AppointmentsController@create');
        Route::delete('parent/appointments/delete/{appointment_id}', 'AppointmentsController@destroy');
        Route::get('parent/appointments/getAllByParent', 'AppointmentsController@getAllByParent');
        Route::get('parent/appointments/getAllByTeacher/{teacher_id}', 'AppointmentsController@getAllByTeacher');
        Route::get('parent/appointments/getAllBySelectedDate/{selected_date}', 'AppointmentsController@getAllBySelectedDate');
        Route::post('parent/appointments/response/{appointment_id}', 'AppointmentsController@parentResponse');
        Route::get('parent/appointments/getTimeSchedule/{date}/{teacher_id}', 'AppointmentsController@getTimeSchedule');

        /*My Account*/
        Route::get('parent/myaccount', 'MyAccountController@index');
        Route::post('parent/myaccount/update', 'MyAccountController@account_update');
        Route::post('parent/myaccount/changePassword', 'MyAccountController@changePassword');
        Route::get('parent/myaccount/country/{country_id}', 'MyAccountController@getStateByCountryId');
        Route::post('parent/resetpassword/forgot', 'MyAccountController@changePassword');

        /* VideoCall */
        //Route::get('parent/videocall', 'VideoCallController@index');

        /* History */
        Route::get('parent/history', 'DashboardController@history');

        /* Messages */
        Route::get('parent/messages', 'DashboardController@messages');
        Route::get('parent/messages/getTeachersForMessage', 'DashboardController@getTeachersByStudent');
        Route::post('parent/messages/sendEmailIfOffline', 'DashboardController@sendEmailIfOffline');

        /*Route::get('parent/announcements/get/{announcement_id}', 'AnnouncementsController@get');
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
        Route::get('school-admin/announcements/get/{announcement_id}', 'AnnouncementsController@get');

        /* Teachers */
        Route::resource('school-admin/teachers', 'TeachersController', ['except' => 'show']);
        Route::get('school-admin/teachers/getAll', 'TeachersController@getAll');
        Route::get('school-admin/teachers/get/{parent_id}', 'TeachersController@get');

        /* Manage Teachers */
        Route::resource('school-admin/manage-teachers', 'ManageTeachersController');
        Route::get('school-admin/manage-teachers/getAll', 'TeachersController@getAll');
        Route::get('school-admin/manage-teachers/get/{parent_id}', 'TeachersController@get');
        Route::get('school-admin/manage-teachers/country/{country_id}', 'ManageTeachersController@getStateSchoolByCountryId');
        Route::post('school-admin/manage-teachers/{teacher_id}/update', 'ManageTeachersController@update');
        Route::put('school-admin/manage-teachers/update/{id}', 'ManageTeachersController@updateStatus');
        Route::delete('school-admin/manage-teachers/delete/{id}', 'ManageTeachersController@destroy');

        /* Parents */
        Route::resource('school-admin/parents', 'ParentsController');
        Route::get('school-admin/parents/getAll', 'ParentsController@getAll');
        Route::get('school-admin/parents/get/{parent_id}', 'ParentsController@get');
        Route::get('school-admin/parents/students/getChild/{parent_id}', 'ParentsController@getChild');
        Route::get('school-admin/parents/students/getAllChildren/{parent_id}', 'ParentsController@getAllChildren');
        Route::put('school-admin/parents/students/updateChild/{child_id}', 'ParentsController@updateChild');

        /* Manage Parents*/
        Route::resource('school-admin/manage-parents', 'ManageParentsController');
        Route::get('school-admin/manage-parents/getAll', 'ManageParentsController@getAll');
        Route::get('school-admin/manage-parents/get/{parent_id}', 'ManageParentsController@get');
        Route::get('school-admin/manage-parents/country/{country_id}', 'ManageParentsController@getStateSchoolByCountryId');
        Route::get('school-admin/manage-parents/child/{parent_id}', 'ManageParentsController@getAllChildren');
        Route::get('school-admin/manage-parents/getChildById/{child_id}', 'ManageParentsController@getChildById');
        Route::post('school-admin/manage-parents/updateField/{id}', 'ManageParentsController@updateField');

        /*My Account*/
        Route::get('school-admin/settings', 'SchoolAdminAccountController@index');
        Route::post('school-admin/settings/update', 'SchoolAdminAccountController@account_update');
        Route::post('school-admin/settings/changePassword', 'SchoolAdminAccountController@changePassword');
        Route::get('school-admin/settings/country/{country_id}', 'SchoolAdminAccountController@getStateByCountryId');
        Route::post('school-admin/resetpassword/forgot', 'SchoolAdminAccountController@changePassword');

    });

    /*
    |--------------------------------------------------------------------------
    | Admin Route
    |--------------------------------------------------------------------------
     */
    Route::group(array('middleware' => 'admin', 'namespace' => 'Admin'), function () {

        /* Dashboard */
        Route::resource('admin/dashboard', 'DashboardController');

        /* School */
        Route::post('admin/schools/add', 'SchoolController@store');
        Route::post('admin/schools/update/{id}', 'SchoolController@update');
        Route::resource('admin/schools', 'SchoolController', ['except' => ['show']]);
        Route::put('admin/schools/updateUpload/{school_id}', 'SchoolController@updateUpload');
        Route::get('admin/schools/{state_id}', 'SchoolController@getSchools');
        Route::get('admin/schools/{status}', 'SchoolController@getByStatus');
        Route::get('admin/states/{country_id}', 'SchoolController@getStates');

        /* SchoolAdmin */
        Route::resource('admin/school-admin', 'SchoolAdminController');

        /* Teachers */
        Route::resource('admin/teachers', 'TeacherController');
        Route::get('admin/teachers/get/{teacher_id}', 'TeacherController@get');

        /* Parents */
        Route::resource('admin/parents', 'ParentController');
        Route::get('admin/parents/get/{parent_id}', 'ParentController@get');
        Route::put('admin/update/{parent_id}', 'ParentController@updateAField');

        /* Location */
        Route::get('admin/location/getAll', 'LocationController@getAll');
        Route::resource('admin/location', 'LocationController', ['except' => ['create', 'edit', 'show']]);
        Route::get('/admin/location/edit/{id}', 'LocationController@edit');
        Route::post('/admin/location/store', 'LocationController@store');
        Route::post('/admin/location/update/{id}', 'LocationController@update');
        Route::delete('/admin/location/delete/{id}', 'LocationController@destroy');

        /* Settings */
        Route::resource('admin/settings', 'SettingsController');
        Route::post('admin/settings/update', 'SettingsController@settings_update');
        Route::post('admin/settings/changePassword', 'SettingsController@changePassword');

    });

    Route::get('logout', 'LoginController@logout');
});
