
    @extends('theme')

    @section('additional_headtag')
        <title>SUAdmin</title>
    @stop

    @section('body_content')

        @include('includes.nav-admin')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active nav_tab" id="dashboard">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/principals" class="waves-effect"><i class="material-icons">person_add</i> School Principal</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/school" class="waves-effect"><i class="material-icons">location_city</i> School</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/location" class="waves-effect"><i class="material-icons">room</i> Location</span></a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/users" class="waves-effect"><i class="material-icons">group</i>Users </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4>Dashboard</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>

                            <div class="col m6 s12 padding_adjust">
                                <div class="info-box">
                                    <span class="info-title grey lighten-3">Schools</span>
                                    <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                        @foreach($school_latest as $item)
                                            <div class="dash_tile">
                                                <span class="pull-right">{{ $item->state[0]['country'] }}</span>
                                                <span class="title_tile">{{ $item->school_name }}</span>
                                                <span class="date_tile"><small>{{ $item->created_at }}</small></span>
                                            </div>
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="col m3 s12 padding_adjust">
                                <span class="info-box-icon mint" style="height: 320px;">
                                    <br/><span class="desc">Date</span><br/><br/><br/><br/>
                                    <span class="day_" id="day_"></span>
                                    <span class="year_" id="year_"></span>
                                </span>
                            </div>

                            <div class="col m3 s12 padding_adjust">
                                <span class="info-box-icon orange darken-3" style="height: 320px;">
                                    <br/><span class="desc">Time</span><br/><br/><br/><br/>
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
                <h5>Announcement Title</h5>
                <table>
                    <tbody>
                        <tr>
                            <td>Announcement to</td>
                            <td>All / Parents / Teachers</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>Announcement time will be placed here</td>
                        </tr>
                        <tr>
                            <td>Attachment</td>
                            <td><a href="#!"><i class="material-icons">description</i> Download Attachement</a> or No Attachement Available</td>
                        </tr>
                    </tbody>
                </table>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
    <script type="text/javascript">
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
            document.getElementById('time').innerHTML = h + ":" + m;
            document.getElementById('ampm').innerHTML = ampm;
            t = setTimeout(function () {
                startTime()
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
                weekday[0]=  "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";

            var M = month[today.getMonth()];
            var d = today.getDate();
            var Y = today.getFullYear();
            var D = weekday[today.getDay()];

            document.getElementById('day_').innerHTML = M + " " + d;
            document.getElementById('year_').innerHTML = Y + " " + D;
        }
        showDate();

        $('.modal-trigger').leanModal();
    </script>
    @stop