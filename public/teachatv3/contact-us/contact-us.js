$('#form_contact_us').on('submit',function(e){
	e.preventDefault();
	ajaxCall('POST', 'contact-us/send', getFormInputs(this.id), false, 'card', 'form_contact_us');
	$('#form_contact_us')[0].reset();
});
