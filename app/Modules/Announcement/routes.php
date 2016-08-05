<?php

Route::group(array('module' => 'Announcement', 'namespace' => 'App\Modules\Announcement\Controllers'), function() {

    Route::resource('Announcement', 'AnnouncementController');
    
});	