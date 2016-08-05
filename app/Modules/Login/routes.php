<?php

Route::group(array('module' => 'Login', 'namespace' => 'App\Modules\Login\Controllers'), function() {

    Route::resource('Login', 'LoginController');

    //Route::post('login/v2/process/login','LoginController@processLogin');

    
    Route::get('verify/v2/{email}/{code}','LoginController@accountVerifier');

    //Route::get('logout/v2/process/logout','LoginController@logout');
    
    Route::get('notFound','LoginController@displayError');
    
});	