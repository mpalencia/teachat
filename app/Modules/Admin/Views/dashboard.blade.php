
    @extends('theme')

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-admin')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                @include('Universal::adminName')
                            </div>
                            <div class="profile-usertitle-job">
                                Administrator
                            </div>
                        </div>
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active nav_tab" id="dashboard">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/admin/announcements" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4><figure class="school_badge" style="background-image: url('{{asset('/images/school_badges')}}/{{ $school[0]['school_logo']  }}');"></figure>Welcome to {{ $school[0]['school_name']  }}</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>

                            <div class="col m6 s12 padding_adjust">
                                <div class="info-box">
                                    <span class="info-title grey lighten-3">Announcements</span>
                                        <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                        @foreach($announcement as $annouce)
                                            <div class="dash_tile">
                                                <span class="pull-right"><a href="#announcement_view" onClick="showDetailsAnnouncementById({{ $annouce->id }});" class=" waves-effect">Details</a></span>
                                                <span class="title_tile">{{ $annouce->announceTitle }}</span>
                                                <span class="date_tile"><small>{{ $annouce->created_at }}</small></span>
                                            </div>
                                        @endforeach
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
                <center>
                    <div class="preloader-wrapper big active">
                      <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                          <div class="circle"></div>
                        </div><div class="gap-patch">
                          <div class="circle"></div>
                        </div><div class="circle-clipper right">
                          <div class="circle"></div>
                        </div>
                      </div>

                      <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                          <div class="circle"></div>
                        </div><div class="gap-patch">
                          <div class="circle"></div>
                        </div><div class="circle-clipper right">
                          <div class="circle"></div>
                        </div>
                      </div>

                      <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                          <div class="circle"></div>
                        </div><div class="gap-patch">
                          <div class="circle"></div>
                        </div><div class="circle-clipper right">
                          <div class="circle"></div>
                        </div>
                      </div>

                      <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                          <div class="circle"></div>
                        </div><div class="gap-patch">
                          <div class="circle"></div>
                        </div><div class="circle-clipper right">
                          <div class="circle"></div>
                        </div>
                      </div>
                    </div>
                </center>
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

        function showDetailsAnnouncementById(id){
            $('#announcement_view').openModal();
            $.get('/admin/v2/process/viewDetailsAnnouncement/'+id,{},function(data){
                var json = JSON.parse(data);
                    console.log(json);
                    modalUIupdater(json[0]);
            });
        }
        var view;
        var selector = {0:"All",2:"Teachers",3:"Parents"};
        function modalUIupdater(data){
            view = '<h5>'+data.announceTitle+'</h5>'+
                        '<table><tbody><tr><td>Announcement to</td>'+
                                        '<td>'+selector[data.announceTo]+'</td></tr><tr>'+
                                    '<td>Posted Date</td>'+
                                    '<td>'+data.created_at+'</td></tr>'+
                                    '</tbody>'+
                        '</table>'+
                        '<p>'+data.announcement+'</p>';
            $('#announcement_view .modal-content').html(view);
        }
    </script>
    @stop