//------------registration js -------------------//
		$(document).ready(function(){

			$('#reg_select_country').change(function(){
				var id = $(this).val();
					$('#reg_select_region').change();
				$.get('registration/v2/school/getState/'+id,function(data){
					console.log(data);
					$('#reg_select_region').html('<option value="" disabled selected>Choose your Region</option>');
					for(i = 0; i < data.length; i++){
						//$('#reg_select_region').parent('div').find('ul').append('<option value="'+data[i].id+'">'+data[i].state_name+'</option>');
						$('#reg_select_region').append('<option value="'+data[i].id+'">'+data[i].state_name+'</option>');
						$('select').material_select();
					}
				});
			});

			$('#reg_select_region').change(function(){
				var id = $(this).val();
				$.get('registration/v2/school/getSchool/'+id,function(data){
					$('#reg_select_school').html('<option value="" disabled selected>Choose your School</option>');
					for(i = 0; i < data.length; i++){
						$('#reg_select_school').append('<option value="'+data[i].id+'">'+data[i].school_name+'</option>');
						$('select').material_select();
					}
				});
			});

			$('#registration_form').on('submit',function(e){
				e.preventDefault();
				$('.card').append(loader);
				//$(this).find(':submit').attr('disabled','disabled');
				$('#registration_form .ul_notif').remove();
				var param = new FormData(this);
				var url = 'registration/v2/process/registration';
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
		            		$('#registration_form').append('<ul class="input-field col s12 m12 green lighten-2 white-text ul_notif">'+
	                                            '<li>'+
	                                                '<h6><i class="material-icons tiny">check</i> '+json.message+'</h6>'+
	                                            '</li>'+
	                                        '</ul>');
		            		//$('#registration_form .btn_cancel_close').html('CLOSE');
		            		//$('#registration_form .cancel').removeClass('hide');
		            		document.getElementById('registration_form').reset();
		            		window.scrollTo(0, document.body.scrollHeight);
		            	}else{
		            		$('#registration_form').find(':submit').removeAttr('disabled');
		            		$('#registration_form').append('<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif">'+
							                                            '<li>'+
							                                                '<h6><i class="material-icons tiny">error_outline</i>'+json.message+'</h6>'+
							                                            '</li>'+
							                                        '</ul>');
		            		window.scrollTo(0, document.body.scrollHeight);
		            	}
		            	$('.card').find('.progress').remove();
		            }
		        });
			});

			var loader = '<div class="progress">'+
                                '<div class="indeterminate"></div>'+
                            '</div>';
		});