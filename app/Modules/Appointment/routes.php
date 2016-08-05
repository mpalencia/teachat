<?php

Route::group(array('module' => 'Appointment', 'namespace' => 'App\Modules\Appointment\Controllers'), function() {

    Route::resource('Appointment', 'AppointmentController');
    
});	