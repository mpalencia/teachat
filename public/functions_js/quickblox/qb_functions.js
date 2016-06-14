
QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, CONFIG);
var current_session,Total_messages = 0;
$(function(){
	var qblox ={

		qbLogin:function(user){
			QB.createSession({email:user.email, password: user.password},function(err,res){
				if(res){
					user.id = res.user_id;
					current_session = res.token;
					//alert(current_session);
					QB.chat.connect({userId: user.id, password: user.password}, function(err, roster) {
						if(err){
							Materialize.toast('Unable to connect to the chat server. Please reload the page.', 15000);
						}else{
							QB.chat.onMessageListener = MsgListener;
							qb.qbConnect(user);
							removeLoading();
						}
					});
				}
			});
		},

		qbConnect:function(user){
			console.log(user);
			QB.chat.connect({
                jid: QB.chat.helpers.getUserJid(user.id, QBApp.appId), password: user.password}, function(err, res) {
                	if(res){
                		statusChanger(OnlineUsersID);
                		qb.MessageCounter();
                	}
                	//notif all user here real time function goes here
            });
		},

		qbSendChat:function(userId,txt_body){
			//alert(txt_body.trim().length);
			if(txt_body.trim().length == 0 || txt_body.trim() == null){
				$('#messages_submit')[0].reset();
				return null;
			}
            var params_dialog = {
			  type: 3,
			  occupants_ids: userId,
			  extension:{
			  	save_to_history: 1,
			  }
			};

			var msg = {
			  type: 'chat',
			  body: txt_body,
			  extension: {
			    save_to_history: 1,
          		date_sent: Math.floor(Date.now() /1000)
			  },
			  markable: 1
			};

			QB.chat.dialog.create(params_dialog, function(err, createdDialog) {
			  if (err) {
                alert("error on send chat - creating dialog");
			    console.log(err);
			  } else {
                    var inputFile = $('#file_chat')[0].files[0];
                    var jid = QB.chat.helpers.getUserJid(userId, QBApp.appId);
                    if(typeof inputFile == "undefined"){
                        QB.chat.send(jid, msg);
                        //show_message(msg,'right');
                         qb.get_LastMessages(userId,1);
                    }else{
                    	uploading();
                        var params = {name: inputFile.name, file: inputFile, type: inputFile.type, size: inputFile.size, 'public': false};
                        QB.content.createAndUpload(params, function(err, response){
	                        if (err) {
	                            console.log(err);
	                        } else {
	                            var uploadedFileId = response.id;
	                            msg["extension"]["attachments"] = [{id: uploadedFileId, type: inputFile.type}];
	                            QB.chat.send(jid, msg); 
	                            //show_messageWithFile(msg,'right');
	                             qb.get_LastMessages(userId,1);
	                            done_uploading();
                                $('#file_name').html('Upload a file');
	                        }
                        });
                    }
                $('#messages_submit')[0].reset();
			  }
			});
        },

        getCountChat:function(dialogId){
            var params = {chat_dialog_id: dialogId, count: 1};
            QB.chat.message.list(params, function(err, messagesCount) {
              if (messagesCount) {
                console.log(messagesCount);
                var count = messagesCount.items.count;
                    if(count > 100){
                        count = '100+';
                    }
                    $('#msgCount').html(count);
              }else{
                console.log(err);
              }
            });
        },

        chat_msg_delete:function(msgid){
            QB.chat.message.delete(msgid, function(res){
                //alert('remove');
                $('#'+msgid).remove();  
               
            });
        },

        get_Messages:function(opponentId,limit){
		    $('#message_msgPanel').html(' ');
		      if(typeof limit === "undefined"){
		        limit = 10;
		      }
		    var filter = {
		      type:3
		    };
		    QB.chat.dialog.list(filter, function(err, res) {
		        // callback function
		        if(res){
		          var entries = res.total_entries;
		             for(i = 0; i < entries; i++){
		                var users = res.items[i].occupants_ids;
		                var found =  res.items[i].occupants_ids.indexOf(parseInt(opponentId))>=0;
		                if(found == true){
		                  var params = {chat_dialog_id: res.items[i]._id, sort_desc: 'date_sent', limit: limit, skip: 0};
		                    QB.chat.message.list(params, function(err, messages) {
		                      if (messages) {
		                        console.log(messages);
		                        for(i = messages.items.length; i--;){
		                              if(messages.items[i].attachments.length == '' || messages.items[i].attachments.length == null){
		                                //alert('no file');
		                                var msg = {
		                                  body: messages.items[i].message,
		                                  extension: {
		                                  	message_id:messages.items[i]._id,
		                                    date_sent: messages.items[i].date_sent
		                                  }
		                                };
		                              }else{
		                                //alert('with file');
		                                //console.log($.parseJSON(messages.items[i].attachments[0].id));
		                                console.log(messages.items[i].attachments[0]['id']);
		                                var msg = {
		                                  body: messages.items[i].message,
		                                  extension: {
		                                  	message_id:messages.items[i]._id,
		                                    date_sent: messages.items[i].date_sent,
		                                    id: messages.items[i].attachments[0]['id']
		                                  }
		                                };
		                              }
		                                console.log(msg);
		                            if(messages.items[i].sender_id == opponentId){
		                              show_message(msg,'left');
		                            }else{
		                              show_message(msg,'right');
		                            }
		                        }
		                      
		                      }else{
		                        console.log(err);
		                        removeLoading();
		                      }
		                    });
		                  qb.getCountChat(res.items[i]._id);
		                  removeLoading();
		                 // auto_scroll();
		                  //return;
		                }
		             }
		            auto_scroll();
		        }else{
		        	removeLoading();
		        }
		        removeLoading();
		      });
		  },

		  get_LastMessages:function(opponentId,limit){
		      if(typeof limit === "undefined"){
		        limit = 10;
		      }
		    var filter = {
		      type:3
		    };
		    QB.chat.dialog.list(filter, function(err, res) {
		        // callback function
		        if(res){
		          var entries = res.total_entries;
		             for(i = 0; i < entries; i++){
		                var users = res.items[i].occupants_ids;
		                var found =  res.items[i].occupants_ids.indexOf(parseInt(opponentId))>=0;
		                if(found == true){
		                  var params = {chat_dialog_id: res.items[i]._id, sort_desc: 'date_sent', limit: limit, skip: 0};
		                    QB.chat.message.list(params, function(err, messages) {
		                      if (messages) {
		                        console.log(messages);
		                        for(i = messages.items.length; i--;){
		                              if(messages.items[i].attachments.length == '' || messages.items[i].attachments.length == null){
		                                //alert('no file');
		                                var msg = {
		                                  body: messages.items[i].message,
		                                  extension: {
		                                  	message_id:messages.items[i]._id,
		                                    date_sent: messages.items[i].date_sent
		                                  }
		                                };
		                              }else{
		                                //alert('with file');
		                                //console.log($.parseJSON(messages.items[i].attachments[0].id));
		                                console.log(messages.items[i].attachments[0]['id']);
		                                var msg = {
		                                  body: messages.items[i].message,
		                                  extension: {
		                                  	message_id:messages.items[i]._id,
		                                    date_sent: messages.items[i].date_sent,
		                                    id: messages.items[i].attachments[0]['id']
		                                  }
		                                };
		                              }
		                                console.log(msg);
		                            if(messages.items[i].sender_id == opponentId){
		                              show_message(msg,'left');
		                            }else{
		                              show_message(msg,'right');
		                            }
		                        }
		                      auto_scroll();
		                      }else{
		                        console.log(err);
		                        removeLoading();
		                      }
		                    });
		                  qb.getCountChat(res.items[i]._id);
		                  removeLoading();
		                  //auto_scroll();
		                  //return;
		                }
		             }
		             auto_scroll();
		        }else{
		        	removeLoading();
		        }
		        removeLoading();
		      });
		  },

		  //--------------------Message Counter-----------------------------
		  	MessageCounter:function(){
		  		var filter = null;
		  		QB.chat.dialog.list(filter, function(err, res) {
		  			if(res){
		  				console.log(res);
		  				var ids = [];
		  				$('.contact_content li').each(function (index){
		  					//alert($(this).attr('id'));
		  					//ids.push($(this).attr('id'));
		  					var data = res.total_entries;
		  					 for(i = 0; i < data; i++){
		  					 	//alert(jQuery.inArray($(this).attr('id'),res.items[i].occupants_ids));
		  					 	for(x = 0; x < res.items[i].occupants_ids.length; x++){
		  					 		Total_messages = Total_messages + res.items[i].unread_messages_count;
		  					 		if(res.items[i].occupants_ids[x] == $(this).attr('id')){
		  					 			$(this).find('.unread').html(res.items[i].unread_messages_count);
		  					 			if(res.items[i].unread_messages_count != 0){
		  					 				$(this).find('.unread').removeClass('hide');
		  					 			}
		  					 		}
		  					 	}
		  					 }
		  				});

		  				for(x = 0; x < res.total_entries; x++){
		  					Total_messages = Total_messages + res.items[x].unread_messages_count;
		  				}
		  				//alert(Total_messages)
		  				$('#Message_total').html(Total_messages);
		  				//console.log(ids);
		  				//alert(res.total_entries);
		  			}
		  		});
		  	},
		  //--------------------Message Counter----------------------------
		  broadcastMessage:function(currentUser,data){
		  	var json = JSON.parse(data);
		  	console.log(data);
		  	var message = {
			        extension: {
			          user: currentUser,
			          status: "online" 
			        }
			      };

		      for(i = 0; i < json.length; i++){
		      	(function(i){
			        setTimeout(function(){
			        	var id = parseInt(json[i]);
			            QB.chat.sendSystemMessage(id, message);
			        }, 100 * i);
			    }(i));
		      }
		  }

	}

	qb = qblox;

});
		QB.chat.onSystemMessageListener = function(receivedMessage){
	 		console.log(receivedMessage);
	 		//alert(receivedMessage.extension.user);
	 		$('#'+receivedMessage.extension.user+' .contact_status').find('.fa-circle').removeClass('offline').addClass('online');
			$('#'+receivedMessage.extension.user+' .contact_status').find('.textStatus').html('Online');
			$('#'+receivedMessage.extension.user+' .userProfileimg').removeClass('offline').addClass('online');

			//alert(receivedMessage.extension.user);
			$('.appt_class').each(function(index){
				$(this).find('#'+receivedMessage.extension.user+' .material-icons').removeClass('offline');
				var id = $(this).find('a').attr('id');
				$(this).find('a').attr('onClick','timerCheckerRedirectVideoChat('+id+' , '+$(this).parent('div').attr('id')+');');
			});
			 
		};
	
		QB.webrtc.onUserNotAnswerListener = function(userId) {
		 	
		};

		QB.webrtc.onAcceptCallListener = function(id, extension) {
          
        };

        QB.webrtc.onRejectCallListener = function(session, userId, extension) {
         	
        };

        QB.webrtc.onStopCallListener = function(id, extension) {
          
        };

	    QB.webrtc.onCallListener = function(session, extension) {
	    	$('#ringtoneSignal')[0].play();
			TryHistory = 0;
	    	showIncommingCall(session, extension);
	    };

	    QB.webrtc.onRemoteStreamListener = function(stream) {
         //QB.webrtc.attachMediaStream('remoteVideo', stream);
        };

        var lastMessageid; //toUser_MessageId; //selected user
		function MsgListener(userId,msg){
			//$('#Message_total').html(Total_messages + 1);
			if(lastMessageid !== msg.extension.message_id){
				if(toUser_MessageId == userId){
					if (msg.extension.hasOwnProperty("attachments")) {
    					if(msg.extension.attachments.length > 0) {
    						show_messageWithFile(msg,'left');
    					}
    				}else{
    					show_message(msg,'left');
    				}
				}else{
					//alert('show notif');
					var count = parseInt($('#'+userId+' .unread').text());
					$('#'+userId+' .unread').html(count + 1);
					$('#'+userId+' .unread').removeClass('hide');
					console.log(msg);
				}

			}
			auto_scroll();
	    	lastMessageid = msg.extension.message_id;
        }

        
        function show_message(msg,type){
		    var date_time = timeConverter(msg.extension.date_sent);
		    var msgBody_view;

			    if (typeof msg.extension.id !== "undefined") {
    					if(type == 'left'){
					    		msgBody_view = '<div class="left">'+
			                                       ' <small>'+date_time+' <a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a></small>'+
			                                       ' <p class="callout position-left">'+ msg.body+'<a href="http://api.quickblox.com/blobs/'+msg.extension.id+'/download?token='+current_session+'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a>'+
			                                       ' </p>'+
			                                   ' </div>';
				    	}else{
				    		msgBody_view = '<div class="right">'+
			                                   ' <small><a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a> '+date_time+'</small>'+
			                                   ' <p class="callout position-right">'+ msg.body+' <a href="http://api.quickblox.com/blobs/'+msg.extension.id+'/download?token='+current_session+'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a></p>'+
			                               ' </div>';
				    	}
    				$('#message_msgPanel').append(msgBody_view);
			    }else{
			    	if(type == 'left'){
			    		msgBody_view = '<div class="'+type+'">'+
			                                        '<small>'+date_time+' <a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a></small>'+
			                                        '<p class="callout position-'+type+'"> '+msg.body+'</p>'+
			                                    '</div>'; 
			    	}else{
			    		msgBody_view = '<div class="'+type+'">'+
			                                        '<small><a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a>'+date_time+'</small>'+
			                                        '<p class="callout position-'+type+'"> '+msg.body+'</p>'+
			                                    '</div>'; 
			    	}
			    	$('#message_msgPanel').append(msgBody_view);
			    }
			    //auto_scroll();
		}

		function show_messageWithFile(msg,type){
			console.log(msg);
			var date_time = timeConverter(msg.extension.date_sent);

			if(type == 'left'){
		    		msgBody_view = '<div class="left">'+
                                       ' <small>'+date_time+' <a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a></small>'+
                                       ' <p class="callout position-left">'+ msg.body+'<a href="http://api.quickblox.com/blobs/'+msg.extension.attachments[0].id+'/download?token='+current_session+'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a>'+
                                       ' </p>'+
                                   ' </div>';
	    	}else{
	    		msgBody_view = '<div class="right">'+
                                   ' <small><a href="#!" class="del_msg" id="'+msg.extension.message_id+'"><i class="fa fa-fw fa-times"></i></a> '+date_time+'</small>'+
                                   ' <p class="callout position-right">'+ msg.body+' <a href="http://api.quickblox.com/blobs/'+msg.extension.attachments[0].id+'/download?token='+current_session+'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a></p>'+
                               ' </div>';
	    	}
		    $('#message_msgPanel').append(msgBody_view);
		    //auto_scroll();
		}

        function timeConverter(UNIX_timestamp){
		    var a = new Date(UNIX_timestamp * 1000);
		    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		    var year = a.getFullYear();
		    var month = months[a.getMonth()];
		    var date = a.getDate();
		    var hour = a.getHours();
		    var min = a.getMinutes();
		    var sec = a.getSeconds();
		    var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
		    return time;
		}

		function auto_scroll(){
		    $('#message_msgPanel').animate({scrollTop: $('#message_msgPanel')[0].scrollHeight}, 100);
		    
		}

		function uploading(){
			$('#message_msgPanel').append('<div class="right" id="uploadingIcon">'+
	                                        '<p class="callout position-right"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Uploading <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>'+
	                                    '</div>');
		}

		function done_uploading(){
			$('#message_msgPanel #uploadingIcon').remove();
		}

		var InCommingCallSession;
		var CallerId;
		function showIncommingCall(session, extension){
			var baseUrl = location.origin;
			var image;
			if(extension.image !== 'dp.png'){
				image = 'https://s3-ap-southeast-1.amazonaws.com/teachatco/images/'+extension.image;
			}else{
				image = baseUrl+'/images/'+extension.image;
			}
			InCommingCallSession = session;
			CallerId = extension.caller_id;
			$('#incoming_call .online').prop('style','background-image:url('+image+')');
			$('#incoming_call .truncate').html(extension.fullName);
			$('#incoming_call .accept_btn').prop('href','/videochat/accept/'+extension.caller_id+'/'+extension.duration);
			$('#incoming_call .btn_reject').attr('onClick','rejectIncommingCall();');
			$('#incoming_call').openModal({
            	dismissible: false
        	});
		}

		function rejectIncommingCall(){
			$('#ringtoneSignal')[0].pause();
			var extension = {};
			InCommingCallSession.reject(extension);
			createHistory(CallerId,'Missed');

		}

		var TryHistory = 0;
		function createHistory(opppend_id,duration){
			alert(globalHour+' - '+ 'Time');
			var param = { 
					oppenent:opppend_id,
					duration:duration,
					date:historyDate,
					time: globalHour+' '+globalAmpm
				}
			if(TryHistory == 0){
				var url = '/profile/v2/process/createHistory';
				$.post(url,param,function(data){
					//window.location.href = '/Dashboard';
					TryHistory = 1;
				});
			}

		}

