//---Advisory and subjects scripting

$(document).ready(function(){

	$('#frm_updateAdvisory').on('submit',function(e){

		var param = new FormData(this);
		var url = "/myaccount/v2/process/updateAdvisory";
		e.preventDefault();
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

	$('#frm_addSubject').on('submit',function(e){
		var param = new FormData(this);
		var url = "/myaccount/v2/process/addSubject";
		e.preventDefault();
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
                		$('#frm_addSubject')[0].reset();
                		successToast(json.message);
                		$('#subject_list').append(' <div class="chip blue-grey darken-3 white-text">'+
			                                         ' '+json.data.data_name+'<i class="material-icons" onClick="delelteSubject('+json.data.id+');">close</i>'+
			                                    '</div>');
                	}else{
                		errorToast(json.message);
                	}
                }
        	});
	});

});

	function delelteSubject(id){
		$.get('/myaccount/v2/process/deleteSubject/'+id,function(data){
			var json = $.parseJSON(data);
					//remove the chip here currently remove automatically
			if(json.code == 1){
				successToast(json.message);
			}else{
				errorToast(json.message);
			}
			
		});
	}

	function errorToast(message){
		Materialize.toast(''+message+'', 5000, 'red');
	}

	function successToast(message){
		Materialize.toast(''+message+'', 5000, 'green');
	}