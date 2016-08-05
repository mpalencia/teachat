$('#form_create_parent').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', '/admin/parents', getFormInputs(this.id), false, 'card', 'form_create_parent', '', 'admin-parents');
});

$('#form_edit_parent').on('submit',function(e){
	e.preventDefault();
    ajaxCall('PUT', '/admin/parents/'+$(this).find(":submit").attr('data-parent-id'), getFormInputs(this.id), false, 'card', 'form_edit_parent', '', 'admin-parents');
});