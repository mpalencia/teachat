<?php

Route::group(array('module' => 'Files', 'namespace' => 'App\Modules\Files\Controllers'), function() {

    Route::resource('Files', 'FilesController');
    
});	