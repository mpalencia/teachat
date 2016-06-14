/*$('#btn-login-submit').click(function(e){
	e.preventDefault();
    ajaxCall('POST', 'login/authenticate', getFormInputs('form_login'), true);
});

$('#btn-reset-password').click(function(e){
	e.preventDefault();
    ajaxCall('POST', 'password/reset', getFormInputs('form_forgot_password'), false, 'forgot_password_modal');
});*/

$('#form_login').on('submit',function(e){
	e.preventDefault();
	ajaxCall('POST', 'login/authenticate', getFormInputs(this.id), true);
});

$('#form_forgot_password').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', 'password/reset', getFormInputs(this.id), false, 'forgot_password_modal', 'form_forgot_password');
});