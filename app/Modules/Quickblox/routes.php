<?php

Route::group(array('module' => 'Quickblox', 'namespace' => 'App\Modules\Quickblox\Controllers'), function() {

    Route::resource('Quickblox', 'QuickbloxController');
    
});	