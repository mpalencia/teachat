
$('#form_login').on('submit',function(e){
	e.preventDefault();
	ajaxCall('POST', 'login/authenticate', getFormInputs(this.id), false, 'card', 'form_login', '', 'login');
});

$('#form_forgot_password').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', 'password/reset', getFormInputs(this.id), false, 'forgot_password_modal', 'form_forgot_password');
});