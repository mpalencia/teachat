var toUser_MessageId,videoStatus;
	$(document).ready(function(){
		
		$('#messages_submit *').prop('disabled',true);

		$('ul').delegate('.msg_select_user','click',function(){
			loadingOnClick('Fetching messages');

			$('#messages_submit *').prop('disabled',false);
			var qbId = $(this).attr('id');
			$('#'+qbId+' .unread').html(0);
			$('#'+qbId+' .unread').addClass('hide');
			toUser_MessageId = qbId;
			qb.get_Messages(toUser_MessageId);
			//---UI update to show image person of chating ///
			var contact_name = $(this).closest('li').find('.contact_name').html();
			var profileName = $(this).closest('li').find('.userProfileimg').attr('style');
			var status = $(this).closest('li').find('.contact_status .textStatus').html();
			UI_updaterChat(profileName,contact_name,qbId,status);
			
		});


		$('#messages_submit').on('submit',function(e){
			e.preventDefault();
			var msg = $('#Message_msgbody').val();
			qb.qbSendChat(toUser_MessageId,msg);
		});

		$('#file_chat').change(function(e){
			var filename = e.target.files[0].name;
			if(typeof filename === 'undefined'){
				filename = ' ';
			}
			$('#file_name').html(filename);
		});

		$('#Message_msgbody').keyup(function(e){
			if(e.keyCode == 13){
				$('#messages_submit').submit();
			}
		});

		$('#searchString').keyup(function(){
			$('.contact-name').hide();
			var searchString = $('#searchString').val().toUpperCase();
			if(searchString.length == 0){
				$('.c_content').removeClass('hide');
			}else{
				$('.c_content').each(function(index){
					//alert($(this).find('.contact_name').html().toUpperCase());
					if($(this).find('.contact_name').html().toUpperCase().search(searchString) > 0 == false){
						$(this).addClass('hide');
					}else{
						$(this).removeClass('hide');
					}
					
				});
			}
		});

	});

	function UI_updaterChat(style,contact_name,qbId,status){
		var videocam = '<a href="/videochat/call/'+qbId+'/'+videoStatus+'"><i class="material-icons tooltipped" data-position="left" data-tooltip="Make a videocall">videocam</i></a>';
		if(status == 'Offline'){
			videocam = '<i class="material-icons offline">videocam_off</i>';
		}else{
			if(videoStatus == false){
				videocam = '<i class="material-icons offline">videocam_off</i>';
			}
		}
		UI_update = '<figure style="'+style+'"></figure>'+
                     '<h6 class="truncate"> '+contact_name+' </h6>'+
                     '<small><span id="msgCount"> </span> Messages</small>'+
                     ''+videocam+'';

        $('.contact_msgs .msg_header').html(UI_update);
        $('.tooltipped').tooltip({delay: 50});
	}

	function removeLoading(){
		$('.msgs .loading_hover').addClass('hide');
	}

	function loadingOnClick(status){

		$('#loading_status').html(status);
		$('.msgs .loading_hover').removeClass('hide');
	}

