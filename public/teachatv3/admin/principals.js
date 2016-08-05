$('#form_add_principal').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', '/admin/school-admin', getFormInputs(this.id), false, 'card', 'form_add_principal', '', 'admin-schooladmin');
});

$('#form_edit_principal').on('submit',function(e){
	e.preventDefault();
    ajaxCall('PUT', '/admin/school-admin/'+$(this).find(":submit").attr('data-principal-id'), getFormInputs(this.id), false, 'card', 'form_edit_principal', '', 'admin-schooladmin');
});