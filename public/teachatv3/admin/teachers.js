$('#form_create_teacher').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', '/admin/teachers', getFormInputs(this.id), false, 'card', 'form_create_teacher', '', 'admin-teachers');
});

$('#form_edit_teacher').on('submit',function(e){
	e.preventDefault();
    ajaxCall('PUT', '/admin/teachers/'+$(this).find(":submit").attr('data-teacher-id'), getFormInputs(this.id), false, 'card', 'form_edit_teacher', '', 'admin-teachers');
});

