
@extends('theme')
@section('title_tag')
    <title>Teachat: Video Chat</title>
@stop

@section('additional_headtag')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>
    <script type="text/javascript" src="https://a.floox.com:1338/rmc3.min.js"></script>
    <script type="text/javascript" src="https://a.floox.com:1338/Floox.js"></script>
    <!--script type="text/javascript" src="{{ asset('functions_js/quickblox/jquery.countdown.min.js') }}"></script-->
    <script type="text/javascript" src="{{ asset('functions_js/quickblox/timer.js') }}"></script>
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"><!-- Font Awesome -->
    <style type="text/css">
        #videoOutput, #videoInput
        {
            transform: rotateY(180deg);
            -webkit-transform:rotateY(180deg); /* Safari and Chrome */
            -moz-transform:rotateY(180deg); /* Firefox */
        }
    </style>
@stop
@section('body_content')

<!-- <div class="se-pre-con">
    <div id="loader"></div>
    <div id="txt">Initializing</div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div> -->

<div id="video_chat-temp">
    <!-- Medium Screen -->
    <div class="video_full-screen">
        <video id="videoOutput" autoplay></video>
    </div>
    <!-- Medium Screen -->

    <!-- Small Screen -->
    <div class="video_min-screen draggable">
        <span id="clock"></span>
        <video id="videoInput" autoplay></video>
    </div>
    <!-- /. Small Screen -->

    <!-- Buttons UI -->
    <div class="ul_container">
        <center>
            <div class="chat_indicator">
                Video chat with

            </div>
            <ul class="list-inline">
                <li><a class="btn-floating blue video_toggle hvr-float" title="Video Camera"><i class="fa fa-fw fa-video-camera"></i></a></li>
                <li><a class="btn-floating green mic_toggle hvr-float" title="Microphone"><i class="fa fa-fw fa-microphone"></i></a></li>
                <li><a href="#" class="btn-floating red hvr-float hangup" title="End call"><i class="material-icons">call_end</i></a></li>
                <li><a class="btn-floating blue-grey attach_toggle hvr-float" title="Attachment List"><i class="fa fa-fw fa-navicon"></i></a></li>
            </ul>
        </center>
    </div>
    <!-- /. Buttons UI -->

    <!-- Chat -->
    <div class="container">
        <div class="row">
            <div class="col m3 l3 hide-on-med-and-down">
                <ul class="collapsible chat_header_bar" data-collapsible="expandable">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">chat_bubble</i>Chat <span class="unread hide">0</div>
                        <div class="collapsible-body panel-body grey lighten-4">
                            <div class="body_msg-content">
                                <div class="msg_body grey lighten-3" id="message_msgPanel">
                                    <!--<div class="right">
                                        <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                                        <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="left">
                                        <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                                        <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="right">
                                        <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                                        <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="left">
                                        <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                                        <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="right">
                                        <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                                        <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="left">
                                        <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                                        <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="right">
                                        <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                                        <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="left">
                                        <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                                        <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="right">
                                        <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                                        <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>
                                    <div class="left">
                                        <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                                        <p class="callout position-left">Your Favourite HTML,CSS,JS Playground! Your Favourite HTML,CSS,JS Playground! Your Favourite HTML,CSS,JS Playground! Your Favourite HTML,CSS,JS Playground!Your Favourite HTML,CSS,JS Playground!</p>
                                    </div>-->
                                </div>
                            </div>
                            <div class="msg_txtarea">
                                <form id="messages_submit">
                                    <div class="input-group">
                                        <span class="input-group-addon input_file">
                                            <input type="file" id="file_chat" class="file_upload">
                                            <i class="fa fa-fw fa-files-o"></i>
                                        </span>
                                        <textarea class="form-control custom-control" style="resize:none" id="Message_msgbody" required></textarea>
                                        <span class="input-group-btn">
                                            <button class = "btn btn-default" id="btn_chat_send" type="submit" style="height:52px;box-shadow:none;">
                                                <i class="fa fa-fw fa-send"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/. Chat -->

    <!-- File Uploads -->
    <div class="attachments_list">
        <div class="title_head">
            Attachments sent
        </div>
        <div class="content">
            <div class="child_pane">
                <h4><i class="material-icons small">face</i> Child Name</h4>
                <ul class="list-unstyled">
                    <li>
                        <a href="/universal/v2/process/downloadFileById/1" class="truncate"><i class="fa fa-fw fa-download"></i> File Name</a>
                        <small>Description</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /. File Uploads-->
    <select hidden="" id="time-selector"></select>

    @include('calls.initialization')
</div>
<input type="hidden" value="{{$user_id}}" id="user_id" disabled="">
<input type="hidden" value="{{$session_id}}" id="session_id" disabled="">
<input type="hidden" value="{{$user_type}}" id="user_type" disabled="">
@stop

@section('additional_bodytag')
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
    $('.page-footer').hide();
</script>
<script type="text/javascript">

    $('.draggable').draggable({ cursor: "move", cursorAt: { top: 56, left: 56 } });
    // code for the the attach panels
    $('.attach_toggle').on('click', function(e){
        $('i',this).toggleClass("fa fa-fw fa-navicon fa fa-fw fa-times");
        $(this).toggleClass('blue-grey grey');
        $('.attachments_list').toggle('slide', 'left', 'fast');
    });// end code for the the attach panels
    // video toggle code
    $('.video_toggle').on('click',function(){
        $(this).toggleClass('blue orange');
        $('i',this).toggleClass("fa fa-fw fa-video-camera fa fa-fw fa-eye-slash");
        var status = $('i',this).attr('class');
        if(status == 'fa fa-fw fa-eye-slash'){
            floox.disableVideo();
        } else{
            floox.enableVideo();
        }
    });// End video toggle code
    // mic toggle code
    $('.mic_toggle').on('click',function(){
        $(this).toggleClass('green orange');
        $('i',this).toggleClass("fa fa-fw fa-microphone fa fa-fw fa-microphone-slash");
        var status = $('i',this).attr('class');
        if(status == 'fa fa-fw fa-microphone-slash'){
            floox.disableAudio();
        } else{
            floox.enableAudio();
        }
    });// End mic toggle code

    $('#messages_submit').on('submit',function(e){
        e.preventDefault();
        var msg = $('#Message_msgbody').val();
        sendMessage(msg);
        $('#Message_msgbody').val('');
    });

    $('#Message_msgbody').keyup(function(e){
        if(e.keyCode == 13){
            $('#messages_submit').submit();
        }
    });
     var opp = '{{ $opponent_id }}';

     var flooxParams = {
         accessToken:"JZu7WnX14jA1z0M7ytaf43xc",
         appID:"5799b1d7ef84b7801e10e94e",
         userID: $('#user_id').val(),
         useKurento:false,
     };

     var floox = new Floox(flooxParams);
     floox.connect(function(){
    	console.log($('#user_type').val());
        if($('#user_type').val() == 0) {
        	floox.startVideoCall(Floox.VideoCall.UserTypes.CALLER,"videoInput","videoOutput",$('#session_id').val());
            //$('#time-selector').trigger('change');
        }

        else {
            floox.startVideoCall(Floox.VideoCall.UserTypes.CALLEE,"videoInput","videoOutput",$('#session_id').val());
            //$('#time-selector').trigger('change');
        }

        floox.onCallStateChange(function(state, data){
            switch(state) {
                case Floox.States.CallStates.STOPPED:
                    stopTimer();
                    window.location.href = "{{url('/')}}";
                break;
                case Floox.States.CallStates.CALL_STARTED:
                    showTimer();
                    startTimer();
                    $('#initialization').closeModal();
                break;
            }
        });

        floox.messageReceived(function(data){
            showMessage(data);
            chatHeaderBar();
        });
    });

    $('#message').prop("disabled", false); //message chatbox
    //STOP CALL
    $('.hangup').click(function(){
        var answer = confirm("You want to Stop the Call?");
        if(answer){
            stopTimer();
            floox.stopCall($('#session_id').val());
        }
    });

    $('.chat_header_bar').on('click',function(){
        $('.unread').addClass('hide');
        $('.unread').html(0);
        auto_scroll();
    });
</script>
<script type="text/javascript">
    /*var duration = '{{ $duration }}';

    var $clock = $('#clock')
    .on('update.countdown', function(event) {
      var format = '%H:%M:%S';
      if(event.offset.days > 0) {
        format = '%-d day%!d ' + format;
      }
      if(event.offset.weeks > 0) {
        format = '%-w week%!w ' + format;
      }
      $(this).html(event.strftime(format));
    })
    .on('finish.countdown', function(event) {
        Materialize.toast('Times up.. this call will be drop..', 5000,'',function(){
           window.location.href = "{{url('/')}}";
        });
    });

    $('#time-selector').on('change', function() {
        var startSec = duration+'s';
        var val = startSec.toString().match(/^([0-9\.]{1,})([a-z]{1})$/),
            qnt = parseFloat(val[1]),
            mod = val[2];
        switch(mod) {
          case 's':
            val = qnt * 1000;
            break;
          case 'h':
            val = qnt * 60 * 60 * 1000;
            break;
          case 'd':
            val = qnt * 24 * 60 * 60 * 1000;
            break;
          case 'w':
            val = qnt * 7 * 24 * 60 * 60 * 1000;
            break; // Break here to no enter the else value
          default:
            val = 0;
        }
        selectedDate = new Date().valueOf() + val;
        $clock.countdown(selectedDate.toString());
    });*/

    function sendMessage(val) {
      var msg = val;

      floox.sendMessage(msg, [opp], null, true, function(data){ showMessage(data); }, function(){}, function(data){
        console.log(data);
      });
    }

    function showMessage(data){
        console.log(data);
        messageDate = new Date();

        if(data.user_id == '{{ $user_id }}' ){
            var message = '<div class="right"><small>' + messageDate.getHours() + ':' + (messageDate.getMinutes().toString().length === 1 ? '0'+messageDate.getMinutes() : messageDate.getMinutes()) + '</small><p class="callout position-right">' + data.message + '</p></div>';
        } else {
            var message = '<div class="left"><small>' + messageDate.getHours() + ':' + (messageDate.getMinutes().toString().length === 1 ? '0'+messageDate.getMinutes() : messageDate.getMinutes()) + '</small><p class="callout position-left">' + data.message + '</p></div>';
        }

        $('#message_msgPanel').append(message);

        auto_scroll();
    }

    function chatHeaderBar(){
        if($('.collapsible-header').hasClass('active')){
            $('.unread').addClass('hide');
            $('.unread').html(0);
        }else{
            var count = parseInt($('.unread').text());
            $('.unread').removeClass('hide');
            $('.unread').html(count + 1);
        }
    }

    function auto_scroll(){
        $('.body_msg-content').animate({scrollTop: $('.body_msg-content')[0].scrollHeight}, 100);
        //$(".body_msg-content").attr({ scrollTop: $(".body_msg-content").attr("scrollHeight") });
    }
</script>
@stop
