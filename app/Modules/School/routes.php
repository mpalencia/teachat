<?php

Route::group(array('module' => 'School', 'namespace' => 'App\Modules\School\Controllers'), function() {

    //Route::resource('School', 'SchoolController');
    Route::get('registration/v2/school/getState/{id}','SchoolController@getState');
    Route::get('registration/v2/school/getSchool/{id}','SchoolController@getSchool');
    
});	