$('#form_registration').on('submit',function(e){
	e.preventDefault();
    ajaxCall('POST', 'registration/register', getFormInputs(this.id), false, 'card', 'form_registration');
});