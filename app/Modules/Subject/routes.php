<?php

Route::group(array('module' => 'Subject', 'namespace' => 'App\Modules\Subject\Controllers'), function() {

    Route::resource('Subject', 'SubjectController');

    //Route::get('teachers/v2/process/parent/getSubjectOfSelectedTeacher/{id}','SubjectController@getSubject');
    
});	