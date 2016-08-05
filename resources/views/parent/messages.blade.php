@extends('layouts.master')

@section('page_title', 'Messages')

@section('body_content')

        <div class="msgs">
            <div class="row" style="position: relative;">
                <h4>
                    <span>Select Teacher to chat</span>
                </h4>
                <span class="divider"></span>
                <div class="divider"></div><br/>
                <!-- ADD A CLASS 'HIDE' THIS IS AN INITIALIZATION AND WILL BE REMOVED WHEN CONNECTED TO THE SERVER AND THIS ONE WILL APPEAR ON FETCHING THE SERVER MESSAGES-->
                <div class="loading_hover hide">
                    <p><i class="fa fa-fw fa-spinner fa-spin"></i> <spabn id="loading_status">Connecting to chat server</span> <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>
                </div>
                <div class="col s12 m4 l4 white-text contact_names">
                    <div class="msg_header blue-grey darken-4">
                        <form>
                            <div class="row">
                                <div class="input-field col s12 m12 white-text">
                                  <input id="searchString" type="text">
                                  <label for="text" data-error="wrong" data-success="right">Search</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="contact_content blue-grey darken-1">
                        <ul>
                            <!-- <li class="c_content waves-effect msg_select_user" id="10377663" onclick="timerCheckerRedirectVideoChat(10377663 );">
                                <figure class="offline userProfileimg" style="background-image: url('https://dev2.teachat.co/images/profile/dp.png')"><span class="unread">10</span></figure>
                                <span class="contact_name truncate"> Teacher Test Version II </span>
                                <span class="contact_status" id="10377663">
                                <i class="fa fa-fw fa-circle offline"></i> <span class="textStatus">Offline</span>
                                </span>
                            </li> -->
                            <!-- <li class="c_content waves-effect msg_select_user" id="10406382" onclick="timerCheckerRedirectVideoChat(10406382 );">
                                <figure class="online userProfileimg" style="background-image: url('https://dev2.teachat.co/images/profile/dp.png')"><span class="unread hide">0</span></figure>
                                <span class="contact_name truncate"> Teacher Test </span>
                                <span class="contact_status" id="10406382">
                                <i class="fa fa-fw fa-circle online"></i> <span class="textStatus">Online</span>
                                </span>
                            </li> -->
                            @foreach($teachers as $t)
                                <?php $profile_img = ($t->profile_img != null) ? "https://s3-ap-southeast-1.amazonaws.com/teachatco/images/" . $t->profile_img : "" . asset('/images/profile/dp.png') . "";?>
                                <li class="c_content waves-effect msg_select_user" id="{{$t->id}}" onclick="getUserMessages({{$t->id}}, 0, null, true);">
                                    <figure class="online userProfileimg" style="background-image: url('{{ $profile_img }}')"><span class="unread hide">0</span></figure>
                                    <span class="contact_name truncate"> {{$t->first_name.' '.$t->last_name}} </span>
                                    <span class="contact_status" id="{{$t->id}}">
                                    <i class="fa fa-fw fa-circle offline"></i> <span class="textStatus">Offline</span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col s12 m8 l8 contact_msgs">
                    <div class="msg_header grey lighten-2">
                        <figure class="online userProfileimg" style="background-image: url('https://dev2.teachat.co/images/profile/dp.png')"><span class="unread hide">0</span></figure>
                        <h6>SELECT TEACHER</h6>
                        <small>---</small>
                        <i class="material-icons">email</i>
                    </div>
                    <div class="msg_body grey lighten-3 body_msg-content" id="message_msgPanel">
                        <!-- REMOVE OR COMMENT OUT THIS CODE TO SEE THE MESSAGE FORMAT DO NOT DO THE MESSAGE LOGIC HERE THIS WAS A GUIDE THANKS! -->

                        <!-- <center><h3 class="engraved"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading ... </h3></center>
                        <div class="right">
                            <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                            <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!
                                <a href="#!"><i class="material-icons tiny">attach_file</i> File Attached.</a></p>
                        </div>
                        <div class="left">
                            <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                            <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                        </div>
                        <div class="left">
                            <p class="callout position-left"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Uploading <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>
                        </div>
                        <div class="right">
                            <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                            <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                        </div>
                        <div class="left">
                            <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                            <p class="callout position-left">
                                Your Favourite HTML,CSS,JS Playground!
                                <a href="#!"><i class="material-icons tiny">attach_file</i> File Attached.</a>
                            </p>
                        </div> -->
                        <center><img src="{{asset('images/tutorial.jpg')}}" alt="Tutorial" width="95%"></center>
                    </div>
                    <div class="msg_txtarea">
                        <div class="row grey lighten-2">
                            <form id="messages_submit" accept-charset="utf-8" class="col s12" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="Message_msgbody" class="materialize-textarea" rows="2" autofocus placeholder="Write a message ..."></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s8 m9">
                                        <span class="upload_icon"">
                                            <input type="file" name="file_chat" id="file_chat">
                                            <i class="material-icons waves-effect">present_to_all</i> <span id="file_name"> Upload a file</span>
                                        </span>
                                    </div>
                                    <div class="col s4 m3">
                                        <button class="btn waves-effect btn-block waves-light" type="submit" name="action">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script type="text/javascript" src="{{ asset('functions_js/message_functions.js') }}"></script> -->
    <script src="{{ asset('functions_js/timer.js') }}"></script>
    <script type="text/javascript">
        var iamOnvideoPanel = true;
        $('#Message_msgbody').trigger('autoresize')
    </script>
@stop

@section('custom-scripts')

    @include('parent.floox-script')

    <script type="text/javascript">
        var user_id = $('#user_id').val();
        var opp = '';
        var msg_limit = 10;

        $('#messages_submit *').prop('disabled',true);

        $('#message_msgPanel').scroll(function(){
            if ($('#message_msgPanel').scrollTop() == 0){
                $('#message_msgPanel').prepend('<center class="loading_more"><h6 class="engraved"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading ... </h6></center>');
                getUserMessages(opp, 10, null, false);
            } else {
                $('.loading_more').remove();
            }
        });

        //UI UPDATER
        $('ul').delegate('.msg_select_user','click',function(){
            //---UI update to show image person of chating ///
            $('.msg_select_user').removeClass('blue-grey darken-4');
            $(this).closest('li').addClass('blue-grey darken-4');
            var contact_name = $(this).closest('li').find('.contact_name').html();
            var profileName = $(this).closest('li').find('.userProfileimg').attr('style');
            var status = $(this).closest('li').find('.contact_status .textStatus').html();
            UI_updaterChat(profileName,contact_name,status);

        });

        function UI_updaterChat(style,contact_name,status){
            if(status == 'Offline'){
                var videocam = '<i class="material-icons offline">email</i>';
            }else{
                    var videocam = '<i class="material-icons">email</i>';
            }
            UI_update = '<figure style="'+style+'"></figure>'+
                         '<h6 class="truncate"> '+contact_name+' </h6>'+
                         '<small><span id="msgCount"> </span> Messages</small>'+
                         ''+videocam+'';

            $('.contact_msgs .msg_header').html(UI_update);
            $('.tooltipped').tooltip({delay: 50});
            loadingOnClick('Fetching messages');
        }

        //MESSAGE INBOX FUNCTIONS
        function getUserMessages(opp_id, limit, date, scrolling){
            opp = opp_id;
            msg_limit = msg_limit + limit

            $('#messages_submit *').prop('disabled',false);

            floox.getMessages(opp_id, msg_limit, date, null, true, function(data){
                $('#message_msgPanel').empty();
                data.reverse();
                $.each(data,function(key,value){
                    showMessage(value, scrolling);
                });
                removeLoading();
            });
        }

        function loadingOnClick(status){

            $('#loading_status').html(status);
            $('.msgs .loading_hover').removeClass('hide');
        }

        function removeLoading(){
            $('.msgs .loading_hover').addClass('hide');
        }

        //MESSAGING FUNCTIONS
        $('#messages_submit').on('submit',function(e){
            e.preventDefault();
            var msg = $('#Message_msgbody').val();
            if($('#file_chat').get(0).files.length != 0){
                $.ajax({
                    url: "{{url('parent/uploadAttachment')}}", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                        var message = JSON.parse(data);
                        if(message.result == 'success'){
                            $('#messages_submit')[0].reset();
                            var attachment = {'file': message.message};
                            sendMessage(msg, attachment);
                        }else{
                            $('#messages_submit')[0].reset();
                            Materialize.toast(message.message, 7000, 'red');
                            sendMessage(msg, null);
                        }
                    }
                });
            } else{
                if($.trim(msg).length > 0){
                    sendMessage(msg, null);
                }
            }

            $('#Message_msgbody').val('');
        });

        $('#Message_msgbody').keyup(function(e){
            if(e.keyCode == 13){
                $('#messages_submit').submit();
            }
        });

        function sendMessage(val, attachment) {
            var msg = val;

            floox.getLoggedInUsers([opp], function(users){
                if(users.length == 0){
                    var data = {
                        'opp_id' : opp,
                        'message' : msg
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ url('parent/messages/sendEmailIfOffline') }}",
                        data: data,
                        cache: false,
                        success: function(data){
                            var msg = JSON.parse(data);
                            if(msg.result == 'success'){
                                //SUCCESS
                            }
                        }
                    });
                }
                floox.sendMessage(msg, [opp], attachment, true, function(data){ showMessage(data, true); }, function(){}, function(data){
                    console.log(data);
                });
            });

        }

        function showMessage(data, scrolling){
            console.log(data);
            if(data == ''){
                $('.msg_body').html('<center class="no_message"><small>No message yet. Be the first to send a message.</small></center>');
            } else {
                $('.no_message').remove();


                if(typeof data.from != "undefined"){
                    if(data.from.user_id == user_id){
                        messageDate = new Date();
                        var formattedDate = formatAMPM(messageDate);

                        var message = '<div class="right"><small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> ' + formattedDate + '</small><p class="callout position-right">' + data.message;
                        if(data.attachment != null){
                            message += '<a href="'+ data.attachment.file +'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a>';
                        }
                        message += '</p></div>';
                    } else {
                        messageDate = new Date(data.createdAt);
                        var formattedDate = formatAMPM(messageDate);

                        var message = '<div class="left"><small>' + formattedDate + ' <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small><p class="callout position-left">' + data.message;
                        if(data.attachment != null){
                            message += '<a href="'+ data.attachment.file +'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a>';
                        }
                        message += '</p></div>';
                    }
                } else {
                    messageDate = new Date();
                    var formattedDate = formatAMPM(messageDate);

                    var message = '<div class="right"><small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> ' + formattedDate + '</small><p class="callout position-right">' + data.message;
                    if(data.attachment != null){
                        message += '<a href="'+ data.attachment.file +'" target="_blank"><i class="material-icons tiny">attach_file</i> File Attached.</a>';
                    }
                    message += '</p></div>';
                }

                $('#message_msgPanel').append(message);

                if(scrolling === true){
                    auto_scroll();
                } else {
                    $('.body_msg-content').animate({scrollTop: 200}, 10);
                }
            }
        }

        function auto_scroll(){
            $('.body_msg-content').animate({scrollTop: $('.body_msg-content')[0].scrollHeight}, 100);
            //$(".body_msg-content").attr({ scrollTop: $(".body_msg-content").attr("scrollHeight") });
        }

        function formatAMPM(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = month + '-' + day + '-' + year + '@' + hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }


    </script>

@stop
