@extends('theme')
    @section('title_tag')
        <title>Parent : Dashboard</title>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @stop

    @section('body_content')
    <nav class="blue-grey darken-4">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
                <ul class="right hide-on-med-and-down">
                    <li class="hide-on-med-and-down"><a href="/" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                    <li class="hide-on-med-and-down"><a href="javascript:void(0)" class="waves-effect help-toggle"><i class="material-icons">help_outline</i></a></li>
                    <li><a class="waves-effect blue-grey darken-2" href="/logout" ><i class="material-icons">power_settings_new</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <img src="{{asset('images/help-3.jpg')}}" alt="help" class="help-img">
    <div class="container">
        <div class="row profile">
            <div class="col s12 m12 l3 hide-on-med-and-down">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/phpQscZ9h.png')">
                        <span>
                            <form id="form_profile" class="frm_profileUpload">
                                <input type="file" class="profile_upload" name="profile_" id="image_input" accept="image/*">
                                <span class="hover_dp" onClick="onClickCamera();return;"><i class="fa fa-camera fa-fw fa-2x"></i> Upload Picture</span>
                            </form>
                        </span>
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            A Demo Account
                        </div>
                        <div class="profile-usertitle-job">
                            Teacher
                        </div>
                    </div>
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active nav_tab" id="dashboard">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                            </li>
                            <li class="nav_tab" id="overview">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                            </li>
                            <li class="nav_tab" id="child">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">recent_actors</i>Child </a>
                            </li>
                            <li class="nav_tab" id="child">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
                            </li>
                            <li class="nav_tab" id="msgs">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages </a>
                            </li>
                            <li class="nav_tab" id="appointment">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                            </li>
                            <li class="nav_tab" id="settings">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">toll</i>History </a>
                            </li>
                            <li class="nav_tab" id="settings">
                                <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
            </div>
            <div class="col s12  m12 l9">
                <div class="profile-content">
                    <div class="row">
                        <h4>
                            <figure class="school_badge" style="background-image: url('http://localhost:5000/images/school_badges/wanbol.jpg');"></figure>
                            Welcome to Wanbol
                        </h4>
                        <span class="divider"></span>
                        <div class="divider"></div>
                        <br/>
                        <div class="col m3 s12 padding_adjust">
                            <a href="#notif" id="notif_block" class="modal-trigger">
                            <span class="info-box-icon red" style="background-image: url('http://localhost:5000/images/bg_notif.png');">
                            <br/><span class="desc">Notifications</span><br/><br/>
                            <br/><span class="count">0</span>
                            </span>
                            </a>
                        </div>
                        <div class="col m3 s12 padding_adjust padding_adjust">
                            <a href="javascript:void(0)">
                            <span class="info-box-icon yellow darken-2" style="background-image: url('http://localhost:5000/images/bg_msg.png');">
                            <br/><span class="desc">Messages</span><br/><br/>
                            <br/><span class="count" id="Message_total">0</span>
                            </span>
                            </a>
                        </div>
                        <div class="col m6 s12 padding_adjust right">
                            <div class="info-box">
                                <span class="info-title grey lighten-3"> Appointments for today</span>
                                <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                    <div class="dash_tile appointment">
                                        <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/phpGa1HuC.jpg')"></figure>
                                        <span class="pull-right appt_class"><a href="#" id="9598821" onclick="functionCall('richie');"><i class="material-icons tiny">videocam</i></a></span>
                                        <span class="title_tile">Parent Account</span>
                                        <span class="date_tile"><span class="time_only">Demo purpose only</span></small></span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col m6 s12 padding_adjust">
                            <div class="info-box">
                                <span class="info-title grey lighten-3">Announcements</span>
                                <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                    <div class="dash_tile">
                                        <span class="pull-right"><a href="#announcement_view" class="waves-effect modal-trigger">Details</a></span>
                                        <span class="title_tile">Please finish your class grades</span>
                                        <span class="date_tile appt"><small>Monday, March 03 2016</small></span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col m3 s12 padding_adjust">
                            <span class="info-box-icon mint">
                            <br/><span class="desc">Date</span><br/><br/><br/>
                            <span class="day_" id="day_"></span>
                            <span class="year_" id="year_"></span>
                            </span>
                        </div>
                        <div class="col m3 s12 padding_adjust">
                            <span class="info-box-icon orange darken-3">
                            <br/><span class="desc">Time</span><br/><br/><br/>
                            <span class="day_"><span id="time"></span></span>
                            <span class="year_"><span id="ampm"></span></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Announcement -->
    <div id="announcement_view" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h5>Please finish your class grades</h5>
            <table>
                <tbody>
                    <tr>
                        <td>Announcement to</td>
                        <td>Teacehrs</td>
                    </tr>
                    <tr>
                        <td>Posted Date</td>
                        <td>2016-03-14 08:50:39</td>
                    </tr>
                    <tr>
                        <td>Posted By</td>
                        <td>School Administrator</td>
                    </tr>
                </tbody>
            </table>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="notif" class="modal bottom-sheet">
        <div class="modal-content">
            <h6 class="grey-text">Appointment Notifications</h6>
            <ul id="notif_modal_body">
            </ul>
        </div>
        <div class="modal-footer grey lighten-2">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
        </div>
    </div>
    <!-- Modal Structure For Todays Appointment-->
    <div id="appointment_details" class="modal">
        <div class="modal-content">
            <h5>Title Appointment</h5>
            <table>
                <tbody>
                    <tr>
                        <td>Meeting with</td>
                        <td>Ms.Teacher Version II</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>07:00 AM - 08:00 AM</td>
                    </tr>
                    <tr>
                        <td>Attachment</td>
                        <td id="appt_attach">No Attachment Available</td>
                    </tr>
                </tbody>
            </table>
            <p>Txt here</p>
            <a href="#!" class="waves-effect btn undefined" onclick="parentAppointmentResponse(0);">Accept</a> 
            <a href="#!" class="waves-effect btn blue darken-4 undefined" onclick="parentAppointmentResponse(1);">See in person</a> 
            <a href="#appointment_declined" class="waves-effect btn red modal-action modal-close" onclick="parentAppointmentResponseDeclineModal(13);">Decline</a>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>
    <!-- Modal Structure For Appointment Details-->
    <div id="appointment_declined" class="modal">
        <div class="modal-content">
            <h5>Decline the appointment?</h5>
            <h6>Submit a reason</h6>
            <small>* Please tell us why you are declining the request. Or let us know if you want to re-schedule.</small>
            <form id="appointments_declined_submit">
                <div class="input-field ">
                    <textarea id="appointments_declined_msg" class="materialize-textarea" required="" name="res" aria-required="true"></textarea>
                    <label for="textarea1">Textarea</label>
                </div>
                <input type="hidden" name="id" value="" id="appointment_declined_id"></input>
                <div class="input-field ">
                    <button class="btn waves-effect waves-light" type="submit">Submit
                    <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
        </div>
    </div>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    </script>
    <script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
    <script type="text/javascript">
        $('.modal-trigger').leanModal();
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            var ampm = h >= 12 ? 'PM' : 'AM';
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            h = h % 12;
            h = h ? h : 12;
            h = checkTime(h);
            //document.getElementById('time').innerHTML = h + ":" + m;
            //document.getElementById('ampm').innerHTML = ampm;
            globalHour = h + ":" + m;
            globalAmpm = ampm;
            $('#time').html(h + ":" + m);
            $('#ampm').html(ampm);

            t = setTimeout(function () {
                //startTime()
                //changeIconOnloadOnNotIntime();
            }, 500);
        }
        startTime();

        function showDate() {
            var today = new Date();
            var month = new Array();
                month[0] = "Jan";
                month[1] = "Feb";
                month[2] = "Mar";
                month[3] = "Apr";
                month[4] = "May";
                month[5] = "Jun";
                month[6] = "Jul";
                month[7] = "Aug";
                month[8] = "Sept";
                month[9] = "Oct";
                month[10] = "Nov";
                month[11] = "Dec";
            var weekday = new Array();
                weekday[0]=  "Sun";
                weekday[1] = "Mon";
                weekday[2] = "Tue";
                weekday[3] = "Wed";
                weekday[4] = "Thu";
                weekday[5] = "Fri";
                weekday[6] = "Sat";

            var M = month[today.getMonth()];
            var d = today.getDate();
            var Y = today.getFullYear();
            var D = weekday[today.getDay()];

            //document.getElementById('day_').innerHTML = M + " " + d;
            //document.getElementById('year_').innerHTML = Y + " " + D;
            historyDate = M + " "+d+","+Y+" "+D;
            $('#day_').html(M + " " + d);
            $('#year_').html(Y + " " + D);
        }
        showDate();
    </script>
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
        @include('Demo::includes.callee')
        @include('Universal::incoming_call')
        @include('Universal::audio')
    @stop