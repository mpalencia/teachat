
$(document).ready(function(){
    $('#frm_attacht_file').on('submit',function(e){
        e.preventDefault();
        var param = new FormData(this);
        var url = '/universal/v2/process/uploadFile';
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
                    UI_updated(json.file_name,json.file_id,json.file_desc);
                    successToast(json.message);
                   $('#frm_attacht_file')[0].reset();
                }else{
                    errorToast(json.message);
                }
            }
        });
    });
});

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
                var files = json.data.length;
                
            	if(json.code == 1){
                    if(files == 0){
                        $('#file_upload ul').append('<li class="collection-item engraved"><div><center><h4>No file avaible</h4></center></div></li>');
                    }else{
                        $('#file_upload ul').html(' ');
                        for(i = 0; i < files; i++){
                            UI_updated(json.data[i].orig_file,json.data[i].id,json.data[i].file_desc);
                        }
                    }
    			}else{
    				$('#file_upload ul').append('<li class="collection-item engraved"><div><center><h4>No file avaible</h4></center></div></li>');
    			}
            }
        });
    }

    function UI_updated(filename,id,desc){
    	var rowFile = '<li class="collection-item" id="'+id+'">'+
    	                    '<div>'+ filename +'<br/><small>'+desc+'</small><a href="#" class="secondary-content delete" onClick="functionDelete('+id+');"><i class="material-icons waves-effect waves-red">delete</i></a>'+
    	                        		'<a href="#!" class="secondary-content" onClick="functionDownloadfileById('+id+')"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>'+
    	                   ' </div>'+
    	                '</li>';
    	$('#file_upload ul').append(rowFile);
    }

    function functionDelete(id){
        //alert(id);
        $('#delete_attach_file .btn_yes_delete').attr('onClick','functionDeletefileById('+id+')');
        $('#delete_attach_file').openModal();
    }

    function functionDeletefileById(id){
        $.get('/universal/v2/process/deleteFile/'+id,function(data){
            var json = $.parseJSON(data);
            if(json.code == 1){
                $('#delete_attach_file').closeModal();
                $('#file_upload #'+id).remove();
                successToast(json.message);
             }else{
                errorToast(json.message);
             }
        });
    }

    function functionDownloadfileById(id){
       window.location.href = '/universal/v2/process/downloadFileById/'+id;
    }

    function errorToast(message){
        Materialize.toast(''+message+'', 5000, 'red');
    }

    function successToast(message){
        Materialize.toast(''+message+'', 5000, 'green');
    }