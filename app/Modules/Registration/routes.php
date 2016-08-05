<?php

Route::group(array('module' => 'Registration', 'namespace' => 'App\Modules\Registration\Controllers'), function() {

    //Route::resource('Registration', 'RegistrationController');

    Route::get('/registration', 'RegistrationController@index');
    Route::post('registration/v2/process/registration','RegistrationController@registration');
    Route::post('teachatco/api/v2/email/subcribe','RegistrationController@mailer_deamon_teachat');
    Route::post('teachatco/api/v2/email/contact_us','RegistrationController@contact_us');
});	