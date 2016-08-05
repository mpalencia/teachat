<?php

Route::group(array('module' => 'Student', 'namespace' => 'App\Modules\Student\Controllers'), function () {

    Route::resource('Student', 'StudentController');

});
