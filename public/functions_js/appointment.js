$(document).ready(function(){
	$('#frm_appointmentAdd_teacher').on('submit',function(e){
		e.preventDefault();
		var param = new FormData(this);
		var url = "/appointment/v2/process/teacher/create_appointment";
			if($('#appointment_stime').val() == $('#appointment_etime').val()){
				errorToast('Invalid Time');
				return;
			}
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
						window.location.href = '/teacher/appointments';
					}else{
						errorToast(json.message);
					}
                }
        	});
	});

	$('#edit-appointments_submit').on('submit',function(e){
		e.preventDefault();
		var param = new FormData(this);
		var url = "/appointment/v2/process/teacher/updateAppointmentById";
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
                        window.location.href='/teacher/appointments';
					}else{
						errorToast(json.message);
					}
                }
        	});
	});
});

		function errorToast(message){
			var error = '<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif">'+
		                                   '<li>'+
		                                      ' <h6><i class="material-icons tiny">error_outline</i> error message</h6>'+
		                                  ' </li>'+
		                            '</ul>';
		}

		function calendarClick(id){
			var date = $("#" + id).data("date");
			var hasEvent = $("#" + id).data("hasEvent");
				//---show loading here----
			    if(hasEvent == true){
			    	$('#view_appointment .date_selected').html(dateTohuman(date));
			    	$('#view_appointment').openModal();
			      	getAppointmentBySelectedDate(date);
			  	}else{
			  		//---render no file here
			  	}
		}

		function getAppointmentBySelectedDate(data){
			var param = {};
			$('#view_appointment .appointment_list').html(' ');
	    	var url = '/appointment/v2/process/getAppointmentBySelectedDate/'+data;
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
	                var files = json.length;

                    for(i = 0; i < files; i++){
                       UI_updater(json[i]);
                    }
	    			
	            }
	        });
		}

		function functionViewDetail(id){
			$('#appointment_details').openModal();
			$.get('/appointment/v2/process/teacher/viewAppointmentDetailsById/'+id,function(data){
				var json = $.parseJSON(data);
				var Appt = '<h5>'+json[0]['title']+'</h5>'+
                                    '<table>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td>Meeting with</td>'+
                                                '<td>'+json[0]['user']['0']['first_name']+' '+json[0]['user']['0']['last_name']+'</td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td>Date</td>'+
                                                '<td>'+dateTohuman(json[0]['appt_date'])+'</td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td>Time</td>'+
                                                '<td>'+json[0]['appt_stime']+' - '+json[0]['appt_etime']+'</td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td>Attachment</td>'+
                                                '<td id="appt_attach">No Attachment Available</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                    '<p>'+json[0]['description']+'</p>'+
                                '</div>';

             	$('#appointment_details .modal-content').html(Appt); 
				if(typeof json[0]['file_data'] !== 'undefined'){
					var file = json[0]['file_data'][0];
					//alert(file['ext']);
					$('#appt_attach').html('<a href="/universal/v2/process/downloadFileById/'+file['id']+'"><i class="material-icons">description</i> Download Attachment</a>');
					//alert(file_data[0]['id']);
				}
			});
		}

		function errorToast(message){
			Materialize.toast(''+message+'', 5000, 'red');
		}

		function successToast(message){
			Materialize.toast(''+message+'', 5000, 'green');
		}

		var decline_list = [];
		function UI_updater(data){
			var image;
			if(data.profile_img === 'dp.png'){
				image = '/images/profile/dp.png';
			}else{
				image = 'https://s3-ap-southeast-1.amazonaws.com/teachatco/images/'+data.profile_img;
			}
			var res;
			var deleteButton = '<a href="javascript:void(0)" class="waves-effect waves-light btn red delete_trigger-btn" onClick="showDelete('+data.Appt_id+')"><i class="material-icons">delete</i></a>';
			if(data.action == null){
				res = '<span class="">Waiting for confirmation</span>';
			}else if(data.action == 'Accept'){
				deleteButton = '';
				res = ' <span class="green-text">The Parent Accepted</span>';
			}else if(data.action == 'Inperson'){
				res = ' <span class="blue-text">The Parent will see you in person</span>';
			}else{
				decline_list[''+data.Appt_id] = data.action;
				console.log(decline_list);
				res = ' <a href="#appointment_declined-reason" class="red-text waves-effect waves-light tooltipped" onClick="onUsersDecline('+data.Appt_id+');" data-position="left" data-tooltip="Click to view the reason">The Parent Declined</a>';
			}
			var data = '<li class="row" '+data.Appt_id+'>'+
	                       ' <div class="col s12 m7">'+
	                           ' <figure style="background-image: url('+image+')"></figure>'+
	                           ' <span class="appointment_title"> '+data.name_prefix+''+data.first_name+' '+data.last_name+' </span>'+
	                           ' <small>'+data.appt_stime+' - '+data.appt_etime+'</small>'+
	                        '</div>'+
	                        '<div class="options_container" id="'+data.Appt_id+'">'+
	                          '  <div class="col s12 m5 options_btn">'+
	                              '  <div class="right">'+
                                       //' <span class="green-text">The Parent Accepted</span>'+
                                       //' <span class="blue-text">The Parent will see you in person</span>'+
                                       ' '+ res + ''+
	                                   ' <a class="waves-effect waves-light btn" href="#appointment_details" onClick="functionViewDetail('+data.Appt_id+');"><i class="material-icons">zoom_in</i></a>'+
	                                   ' <a href="/teacher/appointments/edit/'+data.Appt_id+'" class="waves-effect waves-light btn orange"><i class="material-icons">edit</i></a>'+
	                                   ' '+deleteButton+' '+
	                               ' </div>'+
	                           ' </div>'+
	                           '<div class="col s12 m5 hide confirm_delete" >'+
	                               ' <div class="right">'+
	                                   ' <h6>Delete this appointment?</h6> '+
	                                   ' <a href="#!" onClick="deleteSelectedApptById('+data.Appt_id+');" class="waves-effect waves-light btn">Yes</a>'+
	                                   ' <a href="javascript:void(0)" class="waves-effect waves-light btn red cancel_delete" onClick="cancel_delete('+data.Appt_id+');">No</a>'+
	                               ' </div>'+
	                           ' </div>'+
	                       ' </div>'+
	                    '</li>';

	        $('#view_appointment .appointment_list').append(data);
	        $('.modal-trigger').leanModal();
            $('.tooltipped').tooltip({delay: 5});
		}

		function deleteSelectedApptById(id){
			$.get('/appointment/v2/process/teacher/deleteAppointmentById/'+id,function(data){
				var json = $.parseJSON(data);
            	if(json.code == 1){
            		call_mycalendar();
					successToast(json.message);
					//$('#view_appointment>ul #'+id).remove();
					window.location.reload();
				}else{
					errorToast(json.message);
				}
			});
		}

		function onUsersDecline(id){
			//alert(id);
			$('#appointment_declined-reason').openModal();
			$('#appointment_declined-reason #area_reason_text').html(decline_list[id]);
		}

		function dateTohuman(date){
		    var dateObject = new Date(Date.parse(date));
		    var dateReadable = dateObject.toDateString();
		    return dateReadable;
		  }