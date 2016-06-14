
QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, CONFIG);
var current_session,opponentUser,currentUser,VideoSession;
var toUser_MessageId;
$(function(){
	var qblox ={

		qbLogin:function(user,opponent,current){
			opponentUser = opponent;
			currentUser = current;
			toUser_MessageId = opponentUser.qbId;
			QB.createSession({email:user.email, password: user.password},function(err,res){
				if(res){
					user.id = res.user_id;
					current_session = res.token;
					QB.chat.connect({userId: user.id, password: user.password}, function(err, roster) {
						if(err){
							Materialize.toast('Unable to connect to the chat server. Please reload the page...', 15000);
						}else{
							QB.chat.onMessageListener = MsgListener;
							qb.qbConnect(user);
						}
					});
				}
			});
		},

		qbConnect:function(user){
			console.log(user);
			QB.chat.connect({
                jid: QB.chat.helpers.getUserJid(user.id, QBApp.appId), password: user.password}, function(err, res) {
                	//notif all user status here real time function goes here
                	if(err){
                		//error goes here
                	}else{
                		qb.get_Messages(opponentUser.qbId,10);
                		if(user.type == "call"){
			    			var mediaParams = {
			    					audio: true,
								  	video: true,
								  	options: {
								    	muted: true,
								    	mirror: true
								  	},
							      	elemId: 'video_min-screen'
					    	};
			    		callWithParams(mediaParams, false);
                	}
                }
            });
		},

		qbSendChat:function(txt_body){
			if(txt_body.trim().length == 0 || txt_body.trim() == null){
				$('#messages_submit')[0].reset();
				return null;
			}
            var params_dialog = {
			  type: 3,
			  occupants_ids: opponentUser.qbId,
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
			  }
			};

			QB.chat.dialog.create(params_dialog, function(err, createdDialog) {
			  if (err) {
                alert("error on send chat - creating dialog");
			    console.log(err);
			  } else {
                    var inputFile = $('#file_chat')[0].files[0];
                    var jid = QB.chat.helpers.getUserJid(opponentUser.qbId, QBApp.appId);
                    if(typeof inputFile == "undefined"){
                        QB.chat.send(jid, msg);
                        //show_message(msg,'right');
                        //showLastSendMsg(msg);
                        qb.get_LastMessages( opponentUser.qbId,1);
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
	                            qb.get_LastMessages( opponentUser.qbId,1);
	                            //show_messageWithFile(msg,'right');
	                            done_uploading(); 
	                        }
                        });
                    }
                   // auto_scroll();
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
		                      }
		                    });
		                  qb.getCountChat(res.items[i]._id);
		                  return;
		                }
		             }
		        }
		      });
		    //auto_scroll();
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
		                        //removeLoading();
		                      }
		                    });
		                  qb.getCountChat(res.items[i]._id);
		                  //removeLoading();
		                  return;
		                }
		             }
		        }else{
		        	removeLoading();
		        }
		        //removeLoading();
		      });
		  },

		  AcceptIncomminCall:function(session, extension){
		  	var mediaParams = {
	    					audio: true,
						  	video: true,
						  	options: {
						    	muted: true,
						    	mirror: true
						  	},
					      	elemId: 'video_min-screen'
			    		};
		  		session.getUserMedia(mediaParams, function(err, stream) {
			  		if(err){
			  			alert('Camera not detected');
			  		}else{
			  			var extension = {};
						session.accept(extension);
			  		}
		  	});	
		  },

		  EndCurrentCall:function(userID){
		  	var userID = parseInt(userID);
		  	var extension = {};
			VideoSession.stop(userID, extension);
			//window.location.href = '/';
		  },

		  muteVideo:function(){
		  	VideoSession.mute('video');
		  },

		  UnmuteVideo:function(){
		  	VideoSession.unmute('video');
		  },

		  muteAudio:function(){
		  	VideoSession.mute('audio');
		  },

		  UnmuteAudio:function(){
		  	VideoSession.unmute('audio');
		  }


	}

	qb = qblox;

});

	
		QB.webrtc.onUserNotAnswerListener = function(session, userId) {
			createHistory(userId,'No answer');
		 	onEndCallToast('No answer, Redirecting...');

		};

		QB.webrtc.onAcceptCallListener = function(session, userId, extension) {
          
        };

        QB.webrtc.onRejectCallListener = function(session, userId, extension) {
        	//$('#endCallSignal')[0].play();
        	createHistory(userId,'Rejected');
          	onEndCallToast('Call rejected, Redirecting...');
          	
        };

        QB.webrtc.onStopCallListener = function(session, userId, extension) {
	        	
          	//onEndCallToast('User drop the call, Redirecting...');
        	//$('#endCallSignal')[0].play();
        	
        };

	    QB.webrtc.onCallListener = function(session, extension) {
	    	if(currentUser.type == 'accept'){
	    		VideoSession = session;
	    		qb.AcceptIncomminCall(session, extension);
	    	}
	    };

	    QB.webrtc.onRemoteStreamListener = function(session, userID, remoteStream) {
	    	//---remove initializing modal
	    	$('#callingSignal')[0].pause();
	    	$('#initialization').closeModal();
	    	
	    	VideoSession = session;
	    	//startTimer();
         	session.attachMediaStream('video_full-screen', remoteStream);
         	$('#time-selector').trigger('change');
        };

        QB.webrtc.onSessionConnectionStateChangedListener = function(session, userID, connectionState) {
			if(connectionState == 4){
				createHistory(userID,$('#clock').text());
			}
		};
        
        
        var lastMessageid;
		function MsgListener(userId,msg){
			if(lastMessageid !== msg.extension.message_id){
				if(toUser_MessageId == userId){
					if (msg.extension.hasOwnProperty("attachments")) {
    					if(msg.extension.attachments.length > 0) {
    						show_messageWithFile(msg,'left');
    						chatHeaderBar();
    					}
    				}else{
    					show_message(msg,'left');
    					chatHeaderBar();
    				}
				}else{
					show_message(msg,'left');
					chatHeaderBar();
				}

			}
			
			auto_scroll();
	    	lastMessageid = msg.extension.message_id;
        }

        function showLastSendMsg (msg) {
        	var date_time = timeConverter(msg.extension.date_sent);
        	msgBody_view = '<div class="right">'+
	                                       ' <small><a href="#!" class="del_msg" id=""><i class="fa fa-fw fa-times"></i></a> '+date_time+'</small>'+
	                                       ' <p class="callout position-right">'+msg.body+'</p>'+
	                                    '</div>'; 
	        $('#message_msgPanel').append(msgBody_view);
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

		//var lastMessageidFile;
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
		    $('.body_msg-content').animate({scrollTop: $('.body_msg-content')[0].scrollHeight}, 100);
		    //$(".body_msg-content").attr({ scrollTop: $(".body_msg-content").attr("scrollHeight") });
		}

		function uploading(){
			$('#message_msgPanel').append('<div class="right" id="uploadingIcon">'+
	                                        '<p class="callout position-right"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Uploading <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>'+
	                                    '</div>');
		}

		function done_uploading(){
			$('#message_msgPanel #uploadingIcon').remove();
		}

		function callWithParams(mediaParams, isOnlyAudio){
			//console.log(mediaParams);
			//alert(opponentUser.qbId);
			$('#callingSignal')[0].play();
			var calleesIds = [opponentUser.qbId]; // User's ids 
			var sessionType = QB.webrtc.CallType.VIDEO; // AUDIO is also possible
			var session = QB.webrtc.createNewSession(calleesIds, sessionType);
			console.log(calleesIds);
			  	session.getUserMedia(mediaParams, function(err, stream) {
				    if (err) {
				      console.log(err);
				      Materialize.toast("Camera not detected", 4000,'',function(){ alert('Camera not found'); });
				    }else{
				    	console.log(currentUser);
				    	//session.attachMediaStream('video_min-screen', stream);
				    	var name = currentUser.name_prefix+''+currentUser.fname+' '+currentUser.lname;
			        		var extension = {
								fullName: name,
								caller_id: currentUser.qbId,
								image: currentUser.image,
								duration: duration
							};
							session.call(extension, function(error) {
	 							
							});
							//putMessage_modal("Dialing");
							//start_calling_tone();
				      //QB.webrtc.call(opponentUser.qbId, isOnlyAudio ? 'audio' : 'video', extension);
				    }
			  });
		}

		function btn_endCurrentCall(userID){
			qb.EndCurrentCall(userID);
			$('#clock').countdown('pause');
			createHistory(userID,$('#clock').text());
		}

		function onEndCallToast(msg){
			Materialize.toast(msg, 3000);
		}

		var tryMe = 0;
		function createHistory(opppend_id,duration){
			var param = { 
					oppenent:opppend_id,
					duration:duration,
					date:historyDate,
					time: StartTimeVideoCall
				}
			var url = '/profile/v2/process/createHistory';
			if(tryMe == 0){
				$.post(url,param,function(data){
					window.location.href = '/Dashboard';
					tryMe = 1;
				});
			}

		}
