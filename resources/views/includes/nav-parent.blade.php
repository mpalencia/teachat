    <div class="se-pre-con">
        <div id="loader"></div>
        <div id="txt">Loading ...</div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- Dropdown PH-->
    <nav class="blue-grey darken-4">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right">
                    <li class="hide-on-med-and-down"><a href="/Dashboard" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                    <li class="hide-on-med-and-down"><a href="javascript:void(0)" class="waves-effect help-toggle"><i class="material-icons">help_outline</i></a></li>
                    <li><a class="waves-effect blue-grey darken-2" href="/logout" ><i class="material-icons">power_settings_new</i></a></li>
                </ul>
            </div>
            <!-- Navigation Mobile View -->
            <ul class="side-nav" id="mobile-demo">
                <li>
                    @include('Universal::profile_img-nav')
                </li>
                <li>
                    <a href="/parent/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                </li>
                <li>
                    <a href="/parent/myaccount" class="waves-effect"><i class="material-icons">perm_identity</i> My Account</span></a>
                </li>
                <li>
                    <a href="/parent/child" class="waves-effect"><i class="material-icons">recent_actors</i> Child </a>
                </li>
                <li class="active nav_tab" id="child">
                    <a href="/parent/teachers-list" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
                </li>
                <li>
                    <a href="/parent/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat </a>
                </li>
                <li>
                    <a href="/parent/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i> Appointment </a>
                </li>
                <li>
                    <a href="/parent/history" class="waves-effect"><i class="material-icons">toll</i> History </a>
                </li>
                <li>
                    <a href="/parent/settings" class="waves-effect"><i class="material-icons">settings</i> Settings </a>
                </li>
            </ul>
            <!-- /. Navigation Mobile View -->
        </div>
    </nav>
    <img src="{{asset('images/help-2.jpg')}}" alt="help" class="help-img">
    @include('Universal::audio')
    <script type="text/javascript">
        $(".help-img").addClass("hide");
        $(".help-toggle").click(function(){
           $(".help-img").toggleClass("hide");
        });
        $(".button-collapse").sideNav();
        $(".dropdown-button").dropdown({
            hover: false,
            inDuration: 150,
            belowOrigin: true, // Displays dropdown below the button
        });
    </script>
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/quickblox/2.0.4/quickblox.min.js"></script>
    <script type="text/javascript" src="{{ asset('functions_js/quickblox/config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('functions_js/quickblox/qb_functions.js') }}"></script>
    <script src="{{ asset('functions_js/timer.js') }}"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.6/socket.io.min.js"></script>
    <script type="text/javascript" src="http://10.10.0.195:1338/adapter.js"></script>
    <script type="text/javascript" src="http://10.10.0.195:1338/kurento-utils.js"></script>
    <script type="text/javascript" src="http://10.10.0.195:1338/IncubixSocket.js"></script>

    <script type="text/javascript">
        var socket = new IncubixSocket('http://10.10.0.195:1338','T3Vp4mD1GGgTJeKQ9kROUN4y','5743f06cc60856fc3c688ec8',"{{$profile[0]['id']}}");

        socket.connect(function(){

            socket.onUserOffline(function(){
                //$('#waitingCall').modal('hide');
                alert('User is Offline');
            });
                
            socket.onIncomingCall(function(data){
                console.log(data);
                caller = data.additional_data.first_name+' '+data.additional_data.last_name;
                $('#incoming_call .truncate').html(caller);
                $('#incoming_call .accept_btn').attr('data-id', data.user_id);
                $('#incoming_call').openModal({
                    dismissible: false
                });
                $('#ringtoneSignal')[0].play();
            
            });

            $('#btnCall').unbind().on("click", function(){
                var oppId = $(this).attr('data-id');
                var duration = '500';
                socket.call(oppId,function(){
                    //$('#waitingCall').modal('show');


                    socket.onAccept(function(session){
                        window.location.href = "{{url('videochat/call')}}/"+oppId+"/"+duration+"/"+session;
                    });

                    socket.onReject(function(callee){
                        alert(callee+' User rejected the call');
                        //$('#waitingCall').modal('hide');
                        
                    });
                });
            });

            $('.accept_btn').unbind().on("click", function(){
                var oppId = $(this).attr('data-id');
                var duration = '500';
                socket.accept(function (session) {
                    window.location.href = "{{url('videochat/accept')}}/"+oppId+"/"+duration+"/"+session;
                });
            });

            $('.btn_reject').unbind().on("click", function(){
                socket.reject(function(){
                    $('#incoming_call').closeModal();
                    $('#ringtoneSignal')[0].pause();
                    alert('You rejected the call');
                })
            });
        });
        
    </script>
