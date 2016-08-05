$('#form_add_appointment').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/teacher/appointments/store', getFormInputs(this.id), false, 'card', 'form_add_appointment', '');
});

$('.form_edit_appointment').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', '/teacher/appointments/update/'+$(this).find(":submit").attr('data-appointment-id'), getFormInputs(this.id), false, 'card', 'form_edit_appointment');
});