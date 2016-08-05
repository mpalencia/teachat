<?php

Route::group(array('module' => 'Teacher', 'namespace' => 'App\Modules\Teacher\Controllers'), function() {

    Route::resource('Teacher', 'TeacherController');
   
});	
