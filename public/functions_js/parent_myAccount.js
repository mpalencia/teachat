$(document).ready(function(){
	$('#frm_update_Account_parent').on('submit',function(e){
		e.preventDefault();
		var param = new FormData(this);
		var url = "/myaccount/v2/process/parent/updateMyaccount";
			$.ajax({
                type: "POST",
                url: url,
                processData:false,
                contentType:false,
                cache:false,
                data: param,
                success: function (data) {
                	var json = $.parseJSON(data);
                	if(json.code == 1){
						successToast(json.message);
					}else{
						errorToast(json.message);
					}
                }
        	});
	});
});

	function errorToast(message){
		Materialize.toast(''+message+'', 5000, 'red');
	}

	function successToast(message){
		Materialize.toast(''+message+'', 5000, 'green');
	}