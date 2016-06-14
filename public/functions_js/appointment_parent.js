
$(document).ready(function(){
  $('#appointments_declined_submit').on('submit',function(e){
    e.preventDefault();
      parentAppointmentResponse($('#appointments_declined_submit #appointments_declined_msg').val());
  });
});

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


	function UI_updater(data){
		var image;
		if(data.profile_img === 'dp.png'){
			image = '/images/profile/dp.png';
		}else{
			image = 'https://s3-ap-southeast-1.amazonaws.com/teachatco/images/'+data.profile_img;
		}
		var button;
    var res;
		if(data.action !== null){
			button = '<a class="waves-effect waves-light btn" onClick="functionViewDetail('+data.Appt_id+');" href="#appointment_details"><i class="material-icons">zoom_in</i></a>';
		}else{
			button = 'Waiting for confirmation <a class="waves-effect waves-light btn amber darken-3" onClick="functionViewDetail('+data.Appt_id+');" href="#appointment_details"><i class="material-icons">warning</i></a>';
		}
      if(data.action == null){
        res = '';
      }else if(data.action == 'Accept'){
        res = ' <span class="green-text">You accepted this appointment</span>';
      }else if(data.action == 'Inperson'){
        res = ' <span class="blue-text">You will see the teacher in person</span>';
      }else{
        res = ' <span class="red-text">You declined this appointment</span>';
      }
		var data = '<li class="row">'+
                       ' <div class="col s12 m8">'+
                           ' <figure style="background-image: url('+image+')"></figure>'+
                           ' <span class="appointment_title"> '+data.first_name+' '+data.last_name+' </span>'+
                           ' <small>'+data.appt_stime+' - '+data.appt_etime+'</small>'+
                        '</div>'+
                        '<div class="options_container">'+
                          '  <div class="col s12 m4 options_btn">'+
                              '  <div class="right">'+
                                   ' '+res+' '+button+' '+
                               ' </div>'+
                           ' </div>'+
                       ' </div>'+
                    '</li>';

        $('#view_appointment .appointment_list').append(data);
        $('.modal-trigger').leanModal();
        $('.tooltipped').tooltip({delay: 10});
	}

  var selectedAppoingmentID;
	function functionViewDetail(id){
		$('#appointment_details').openModal();
    selectedAppoingmentID = id;
		$.get('/appointment/v2/process/teacher/viewAppointmentDetailsById/'+id,function(data){
			var json = $.parseJSON(data);
      var disabled = '';
      if(json[0]['action'] == 'Accept'){
          var disabled_0 = 'disabled';
      }else if(json[0]['action'] == 'Inperson'){
        var disabled_1 = 'disabled';
      }else{
        disabled = ''
      }

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
                                '<a href="#!" class="waves-effect btn '+disabled_0+'" onClick="parentAppointmentResponse(0);">Accept</a> '+
                                '<a href="#!" class="waves-effect btn blue darken-4 '+disabled_1+'"  onClick="parentAppointmentResponse(1);">See in person</a> '+
                                '<a href="#appointment_declined" class="waves-effect btn red modal-action modal-close" onClick="parentAppointmentResponseDeclineModal('+id+');">Decline</a>'
                            '</div>';

      $('#appointment_details .modal-content').html(Appt); 
			if(typeof json[0]['file_data'] !== 'undefined'){
				var file = json[0]['file_data'][0];
				//alert(file['ext']);
				$('#appt_attach').html('<a href="/universal/v2/process/downloadFileById/'+file['id']+'"><i class="material-icons">description</i> Download</a> or <a href="/parent/viewAttachment/'+id+'">View</a> Attachment');
				//alert(file_data[0]['id']);
			}
		});
	}

  function parentAppointmentResponse(res){
    var resText;
    if(res == 0){
      resText = 'Accept';
    }else if(res == 1){
      resText = 'Inperson';
    }else{
      resText = res;
    }
      var param = {
        id: selectedAppoingmentID,
        res: resText
      };
      $.post('/appointment/v2/process/parent/parentResponseOnApoointment',param,function(data){
          var json = $.parseJSON(data);
          if(json.code == 1){
            successToast(json.message);
            $('#appointment_declined').closeModal();
          }else{
            errorToast(json.message);
          }
      });
  }

  function parentAppointmentResponseDeclineModal(id){
    $('#appointment_declined').openModal();
    $('#appointment_declined #appointment_declined_id').val(id);
  }

  function errorToast(message){
    Materialize.toast(''+message+'', 5000, 'red');
  }

  function successToast(message){
    Materialize.toast(''+message+'', 5000, 'green');
  }

  function dateTohuman(date){
    //var dateObject = new Date(Date.parse(date));
    var dateReadable =  moment(date).format("dddd, MMMM Do YYYY");//dateObject.toDateString();
    return dateReadable;
  }
