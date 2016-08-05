<script src="{{ asset('functions_js/incubixSocket.js') }}"></script>

@if($type == 'call')
    <script type="text/javascript">
        var socket = new IncubixSocket('https://floox.com','pb9PsESMdOApPlrNDuhXiQX1','570c65afd87694a60e12211b','{{ $user }}');
        socket.callerStartVideoCall('video_min-screen','video_full-screen','{{ $opp }}');

        function btn_endCurrentCall(){
            socket.stopCall(function(){

            });
        }

        function muteAudio(){
            socket.disableAudio();
        }

        function unMuteAudio(){
            socket.enableAudio();
        }

        function muteVideo(){
            socket.disableVideo();
        }

        function unMuteVideo(){
            socket.enableVideo();
        }

    </script>
@else
    
    <script type="text/javascript">
        var socket = new IncubixSocket('https://floox.com','pb9PsESMdOApPlrNDuhXiQX1','570c65afd87694a60e12211b','{{ $user }}');
        socket.calleeStartVideoCall('video_min-screen','video_full-screen','{{ $opp }}');

        function btn_endCurrentCall(){
            socket.stopCall(function(){

            });
        }

        function muteAudio(){
            socket.disableAudio();
        }

        function unMuteAudio(){
            socket.enableAudio();
        }

        function muteVideo(){
            socket.disableVideo();
        }

        function unMuteVideo(){
            socket.enableVideo();
        }
    </script>

@endif