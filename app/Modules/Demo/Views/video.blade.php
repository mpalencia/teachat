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
                <video id="video_full-screen" autoplay></video>
            </div>
            <!-- Medium Screen -->
            
            <!-- Small Screen -->
            <div class="video_min-screen draggable">
                <span id="clock"></span>
                <video id="video_min-screen" autoplay></video>
            </div>
            <!-- /. Small Screen -->
            
            <!-- Buttons UI -->
            <div class="ul_container">
                <center>
                    <div class="chat_indicator">
                        Video chat with
                        <span class="sm_res">
                        </span>
                    </div>
                    <ul class="list-inline">
                        <li><a class="btn-floating blue video_toggle hvr-float" title="Video Camera"><i class="fa fa-fw fa-video-camera"></i></a></li>
                        <li><a class="btn-floating green mic_toggle hvr-float" title="Microphone"><i class="fa fa-fw fa-microphone"></i></a></li>
                        <li><a href="#" class="btn-floating red hvr-float" onClick="btn_endCurrentCall" title="End call"><i class="material-icons">call_end</i></a></li>>
                    </ul>
                </center>
            </div>
            <!-- /. Buttons UI -->
        </div>
        @section('additional_bodytag')
        <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript">
            $('.page-footer').hide();
            $(document).ready(function(){
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
                       // qb.muteVideo();
                       muteVideo();
                    } else{
                        unMuteVideo();
                       // qb.UnmuteVideo();
                    }
                });// End video toggle code
                // mic toggle code
                $('.mic_toggle').on('click',function(){
                    $(this).toggleClass('green orange');
                    $('i',this).toggleClass("fa fa-fw fa-microphone fa fa-fw fa-microphone-slash");
                    var status = $('i',this).attr('class');
                    if(status == 'fa fa-fw fa-microphone-slash'){
                       // qb.muteAudio();
                        muteAudio();
                    } else{
                        unMuteAudio();
                       // qb.UnmuteAudio();
                    }
                });// End mic toggle code

                $('#messages_submit').on('submit',function(e){
                    e.preventDefault();
                    var msg = $('#Message_msgbody').val();
                    qb.qbSendChat(msg);
                });

                $('#Message_msgbody').keyup(function(e){
                    if(e.keyCode == 13){
                        $('#messages_submit').submit();
                    }
                });

            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/quickblox/2.0.4/quickblox.min.js"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/config.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/videoPanel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/quickblox/jquery.countdown.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('functions_js/timer.js') }}"></script>
        @include('Demo::includes.include')
    @stop