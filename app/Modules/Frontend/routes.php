<?php

Route::group(array('module' => 'Frontend', 'namespace' => 'App\Modules\Frontend\Controllers'), function() {

    Route::resource('Frontend', 'FrontendController');

    Route::get('/', 'FrontendController@Login');
    
    
    
});	