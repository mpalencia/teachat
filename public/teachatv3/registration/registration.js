// $('#form_registration').on('submit',function(e){
// 	e.preventDefault();
//     ajaxCall('POST', 'registration/register', getFormInputs(this.id), false, 'card', 'form_registration');
//     window.location.href("{{URL::to('login')}}");
// });

     $("#form_registration").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
          url: "/registration/register", // Url to which the request is send
          type: "POST",             // Type of request to be send, called as method
          data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,        // To send DOMDocument or non processed data file it is set to false
          error: function(data){
              if(data.readyState == 4){
                  errors = JSON.parse(data.responseText);
                  $.each(errors,function(key,value){
                      Materialize.toast(value, 7000, 'red');
                  });
                  $('#password').val('');
                  $('#confirm_password').val('');
              }
          },
          success: function(data)   // A function to be called if request succeeds
          {
            var msg = JSON.parse(data);
            if(msg.result == 'success'){
              Materialize.toast(msg.message, 7000, 'green', function(){ window.location = "/login"; });
            }else{
              Materialize.toast(msg.message, 7000, 'red');
            }
          }
        });
    }));


$('#select_school_id').hide();

$('select').material_select();

$('#role_id').change(function(){
	if($(this).val() == 2) //TEACHER
	{
		$('#select_school_id').show();
	}

	else {
		$('#select_school_id').hide();
	}
});