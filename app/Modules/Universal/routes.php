<?php

Route::group(array('module' => 'Universal', 'namespace' => 'App\Modules\Universal\Controllers'), function() {

    Route::resource('Universal', 'UniversalController');

    //Route::get('Dashboard','UniversalController@viewDashboard');
    
    //Route::get('Dashboard',['middleware' => 'auth','uses'=>'UniversalController@viewDashboard']);
});	

