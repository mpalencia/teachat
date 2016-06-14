$('#form_contact_us').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', 'contact-us/send', getFormInputs(this.id), false, 'forgot_password_modal', 'form_contact_us');
});