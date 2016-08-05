<?php

Route::group(array('module' => 'Errors', 'namespace' => 'App\Modules\Errors\Controllers'), function() {

    Route::resource('Errors', 'ErrorsController');
    
});	