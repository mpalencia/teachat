<?php

Route::group(array('module' => 'Parent', 'namespace' => 'App\Modules\Parent\Controllers'), function() {

    Route::resource('Parent', 'ParentController');
    
});	