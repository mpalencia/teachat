    @extends('theme')
    @section('title_tag')
        <title>Teachat: Video Chat</title>
    @stop

    @section('additional_headtag')
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"><!-- Font Awesome -->
    @stop

    @section('body_content')
        <div class="se-pre-con">
            <div id="loader"></div>
            <div id="txt">Initializing</div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>

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
                        <span class="sm_res">
                            @if($opponent[0]['profile_img'] === 'dp.png')
                                <figure style="background-image: url('{{asset('images/profile')}}/{{ $opponent[0]['profile_img'] }}')"></figure> {{ $opponent[0]['first_name'] }} {{ $opponent[0]['last_name'] }}
                            @else
                                <figure style="background-image: url('{{asset('assets/images/profiles')}}/{{ $opponent[0]['profile_img'] }}')"></figure> {{ $opponent[0]['first_name'] }} {{ $opponent[0]['last_name'] }}
                            @endif
                        </span>
                    </div>
                    <ul class="list-inline">
                        <li><a class="btn-floating blue video_toggle hvr-float" title="Video Camera"><i class="fa fa-fw fa-video-camera"></i></a></li>
                        <li><a class="btn-floating green mic_toggle hvr-float" title="Microphone"><i class="fa fa-fw fa-microphone"></i></a></li>
                        <li><a href="#" class="btn-floating red hvr-float" onClick="btn_endCurrentCall({{ $opponent[0]['id'] }});" title="End call"><i class="material-icons">call_end</i></a></li>
                        @if($upload === 1)
                            <li><a class="btn-floating blue-grey attach_toggle hvr-float" title="Attachment List"><i class="fa fa-fw fa-navicon"></i></a></li>
                        @endif
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
                                                @if($upload === 1)
                                                    <span class="input-group-addon input_file">
                                                        <input type="file" id="file_chat" class="file_upload">
                                                        <i class="fa fa-fw fa-files-o"></i>
                                                    </span>
                                                @else
                                                    <span class="input-group-addon input_file" style="display: none;">
                                                        <input type="file" id="file_chat" class="file_upload">
                                                        <i class="fa fa-fw fa-files-o"></i>
                                                    </span>
                                                @endif
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
            @include('Universal::audio')
            <!-- File Uploads -->
            @if($upload === 1)
                <div class="attachments_list">
                    <div class="title_head">
                        Attachments sent
                    </div>
                    <div class="content">
                        @foreach($files as $child)
                            <div class="child_pane">
                                <h4><i class="material-icons small">face</i> {{ $child['children']['0']['child_fname'] }} {{ $child['children']['0']['child_mi'] }} {{ $child['children']['0']['child_lname'] }}</h4>
                                <ul class="list-unstyled">
                                    @foreach($child['files'] as $file)
                                        @if(empty($file))
                                            <h4>NO file</h4>
                                        @else
                                            <li>
                                                <a href="/universal/v2/process/downloadFileById/{{ $file['id']  }}" class="truncate"><i class="fa fa-fw fa-download"></i> {{ $file['orig_file'] }}</a>
                                                <small>{{ $file['file_desc'] }}</small>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <!-- /. File Uploads-->
            <select hidden="" id="time-selector"></select>

            @include('Universal::initialization')
            @include('Universal::audio')
        </div>
    @stop

    @section('additional_bodytag')
        <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>

        <script type="text/javascript">
            $('.page-footer').hide();
        </script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/quickblox/2.0.4/quickblox.min.js"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/config.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/videoPanel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/jquery.countdown.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/timer.js') }}"></script> -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.6/socket.io.min.js"></script>
        <script type="text/javascript" src="http://10.10.0.195:1338/adapter.js"></script>
        <script type="text/javascript" src="http://10.10.0.195:1338/kurento-utils.js"></script>
        <script type="text/javascript" src="http://10.10.0.195:1338/IncubixSocket.js"></script>
        <script type="text/javascript">
        var socket = new IncubixSocket('http://10.10.0.195:1338','T3Vp4mD1GGgTJeKQ9kROUN4y','5743f06cc60856fc3c688ec8',"{{ $currentUser[0]['id'] }}");

        @if($type == 'call')
                var opp = "{{ $opponent[0]['id'] }}";
                socket.connect(function(){
                    socket.callerStartVideoCall('videoInput','videoOutput','{{ $session }}');

                    socket.onCallStarted(function(users){
                        console.log("STARTED");
                        socket.onCallDisconnected(function(){
                            window.location.href = "{{url('/')}}";
                        });

                        $('#message').prop("disabled", false); //message chatbox
                        //STOP CALL
                        $('.hangup').click(function(){
                            var answer = confirm("You want to Stop the Call?");
                            if(answer){
                                socket.stopCall(function(){
                                    window.location.href = "{{url('/')}}";
                                });
                            }
                        });

                        //TOGGLE CAMERA BUTTON
                        $('.btn_camera_off').on('click',function(){
                
                            $('i',this).toggleClass("fa fa-eye fa fa-eye-slash");
                            var status = $('i',this).attr('class');
                            if(status == 'fa fa-eye-slash'){
                                socket.disableVideo();
                            } else{
                                socket.enableVideo();
                            }
                        });

                        
                        $('.btn_mic_off').on('click',function(){
                            
                            $('i',this).toggleClass("fa fa-microphone fa fa-microphone-slash");
                            var status = $('i',this).attr('class');
                            if(status == 'fa fa-microphone-slash'){
                                socket.disableAudio();
                            } else{
                                socket.enableAudio();
                            }
                        });

                    });

                    socket.onMessageReceived(opp, function(data){
                        showMessage(data);

                        socket.seenMessage(data.messageData._id);
                    });
                });

        @else
                var opp = "{{ $opponent[0]['id'] }}";
                socket.connect(function(){
                    socket.calleeStartVideoCall('videoInput','videoOutput','{{ $session }}');

                    socket.onCallStarted(function(users){

                        socket.onCallDisconnected(function(){
                            window.location.href = "{{url('/')}}";
                        });

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
                                socket.disableVideo();
                            } else{
                                socket.enableVideo();
                            }
                        });// End video toggle code
                        // mic toggle code
                        $('.mic_toggle').on('click',function(){
                            $(this).toggleClass('green orange');
                            $('i',this).toggleClass("fa fa-fw fa-microphone fa fa-fw fa-microphone-slash");
                            var status = $('i',this).attr('class');
                            if(status == 'fa fa-fw fa-microphone-slash'){
                                socket.disableAudio();
                            } else{
                                socket.enableAudio();
                            }
                        });// End mic toggle code

                        $('#messages_submit').on('submit',function(e){
                            e.preventDefault();
                            var msg = $('#Message_msgbody').val();
                            //qb.qbSendChat(msg);
                        });

                        $('#Message_msgbody').keyup(function(e){
                            if(e.keyCode == 13){
                                $('#messages_submit').submit();
                            }
                        });

                    });

                    socket.onMessageReceived(opp, function(data){
                        showMessage(data);


                        socket.seenMessage(data.messageData._id);
                    });
                });

        @endif

        </script>
        <script type="text/javascript">

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
          });

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
        </script>
    @stop