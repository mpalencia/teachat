$(document).ready(function(){
	$('#frm_addChild_parent').on('submit',function(e){
		e.preventDefault();
		var param = new FormData(this);
		var url = "/myaccount/v2/process/parent/AddChild";
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
                        window.location.href='/parent/child'
					}else{
						errorToast(json.message);
					}
                }
        	});
	});

	$('#frm_editChild_parent').on('submit',function(e){
		e.preventDefault();
		var param = new FormData(this);
		var url = "/myaccount/v2/process/parent/UpdateChild";
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

	function showDeleteModal(id){
		$.post('/myaccount/v2/process/parent/deleteChild',{id:id},function(data){
			var json = $.parseJSON(data);
			if(json.code == 1){
				$('#delete_child_modal').closeModal();
				//$('#datatable #'+id).remove();
				window.location.reload();
				successToast(json.message);
			}else{
				errorToast(json.message);
			}
		});
	}

	function getAllfileofSelectedStudent(student_id){
		$('#file_upload ul').html(' ');
		var param = {};
		var url = '/universal/v2/process/getAllFileByStudentID/'+student_id;
		$.ajax({
	        type: "GET",
	        url: url,
	        processData:false,
	        contentType:false,
	        async: true,
	        cache:false,
	        data: param,
	        success: function (data) {
	        	var json = $.parseJSON(data);
	        	if(json.code == 1){
	        		var files = json.data.length;
	        		if(files == 0){
	        			$('#file_upload ul').append('<li class="collection-item engraved"><div><center><h4>No file avaible</h4></center></div></li>');
	        		}else{
	        			for(i = 0; i < json.data.length; i++){
	        				//console.log();
	        				UI_updated(json.data[i].orig_file,json.data[i].id,json.data[i].file_desc,json.data[i].uploaded[0]);
	        			}	
	        		}
				}else{
					$('#file_upload ul').append('<li class="collection-item engraved"><div><center><h4>No file avaible</h4></center></div></li>');
				}
	        }
	    });
	}

	 function UI_updated(filename,id,desc,uploaded){
    	var rowFile = '<li class="collection-item" id="'+id+'">'+
    	                    '<div>'+ filename +' <small> uploaded by: '+uploaded.name_prefix+' '+uploaded.first_name+' '+uploaded.last_name+'</small><br/><small>'+desc+'</small>'+
    	                        		'<a href="#!" class="secondary-content" onClick="functionDownloadFileById('+id+');"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>'+
    	                   ' </div>'+
    	                '</li>';
    	$('#file_upload ul').append(rowFile);
    }

    function functionDownloadFileById(id){
    	window.location.href = '/universal/v2/process/downloadFileById/'+id;
    }

	function errorToast(message){
		Materialize.toast(''+message+'', 5000, 'red');
	}

	function successToast(message){
		Materialize.toast(''+message+'', 5000, 'green'); 
	}