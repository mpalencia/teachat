$('#form_add_appointment').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/parent/appointments/store', getFormInputs(this.id), false, 'card', 'form_add_appointment', '', 'parent-appointment');
});

$('.form_edit_appointment').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', '/parent/appointments/update/'+$(this).find(":submit").attr('data-appointment-id'), getFormInputs(this.id), false, 'card', 'form_edit_appointment');
});