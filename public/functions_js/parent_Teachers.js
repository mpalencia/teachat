$(document).ready(function(){
	$('#select_teacher').change(function(){
		var id = $(this).val();
			$('#select_subject').html('<option value="" disabled selected>-- Subject --</option>');
			$('#select_subject').material_select();
			$.get('/teachers/v2/process/parent/getSubjectOfSelectedTeacher/'+id,function(data){
					for(i = 0; i < data.length; i++){
						//console.log(data[i].id);
						$('#select_subject').append('<option value="'+data[i].id+'">'+data[i].subject_name+'</option>');
					}
					$('#select_subject').material_select();
			});
	});

	$('#frm_addNewStudent_parent').on('submit',function(e){
		var param = new FormData(this);
		var url = "/teacher/v2/process/parent/addNewStudent";
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
						window.location.reload();
					}else{
						errorToast(json.message);
					}
                }
        	});
	});
});

	function showRemoveChildFrmStudent(id){
		$.post('/teacher/v2/process/parent/RemoveChildFrmStudent',{id:id},function(data){
			var json = $.parseJSON(data);
            	if(json.code == 1){
					successToast(json.message);
					window.location.reload();
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