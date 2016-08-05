
    @extends('theme')
    @section('title_tag')
        <title>Teacher : Dashboard</title>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @stop

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-profile')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        @include('Universal::profile_img')
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active nav_tab" id="dashboard">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/teacher/grades" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/teacher/grades" class="waves-effect"><i class="material-icons">perm_identity</i><span>Grades</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/teacher/students" class="waves-effect"><i class="material-icons">assignment_ind</i>Students </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/teacher/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages</a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/teacher/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/teacher/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>

                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4><figure class="school_badge" style="background-image: url('{{asset('/images/school_badges')}}/{{  $badge[0]['school_logo'] }}');"></figure>Welcome to {{  $badge[0]['school_name'] }}</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="col m3 s6 padding_adjust">
                                <a href="#notif" id="notif_block" class="modal-trigger">
                                    <span class="info-box-icon red" style="background-image: url('{{asset('/images/bg_notif.png')}}');">
                                        <br/><span class="desc">Notifications</span><br/>
                                        <br/><span class="count">{{ $notif }}</span>
                                    </span>
                                </a>
                            </div>

                            <div class="col m3 s6 padding_adjust padding_adjust">
                                <a href="/teacher/messages">
                                    <span class="info-box-icon yellow darken-2" style="background-image: url('{{asset('/images/bg_msg.png')}}');">
                                        <br/><span class="desc">Messages</span><br/>
                                        <br/><span class="count" id="Message_total">0</span>
                                    </span>
                                </a>
                            </div>

                            <div class="col m6 s12 padding_adjust right">
                                <div class="info-box">
                                    <span class="info-title grey lighten-3"> Appointments today <a href="/teacher/appointments/add" class="green right btn-floating"><i class="material-icons">add</i></a></span>
                                    <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                    @foreach($todays_appt as $todays)
                                        @if($todays->action === 'Accept' || $todays->action === 'Inperson' || $todays->action == null)
                                            <div class="dash_tile appointment" id="{{ $todays->Appt_id }}">
                                            @if($todays->active == 0)
                                                @if($todays->profile_img === 'dp.png')
                                                    <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                @else
                                                    <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $todays->profile_img  }}')"></figure>
                                                @endif
                                                <span class="pull-right appt_class"><a href="javascript:void(0)" id="{{ $todays->qbUserId }}"><i class="material-icons tiny offline" >videocam_off</i></a></span>
                                            @else
                                                @if($todays->profile_img === 'dp.png')
                                                    <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                @else
                                                    <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $todays->profile_img  }}')"></figure>
                                                @endif
                                                <!-- <span class="pull-right appt_class"><a href="#" id="" onClick="timerCheckerRedirectVideoChat();"><i class="material-icons tiny">videocam</i></a></span> -->
                                                <span class="pull-right appt_class"><a href="#" id="btnCall" data-id="{{$todays->parent_id}}"><i class="material-icons tiny">videocam</i></a></span>
                                            @endif
                                                <span class="title_tile">{{ $todays->first_name }} {{ $todays->last_name }}</span>
                                                <span class="date_tile"><small>{{ $todays->appt_date }} <span class="time_only">{{ $todays->appt_stime }}</span> - <span class="time_end">{{ $todays->appt_etime }}</span></small></span>
                                            </div>
                                            <!--<div class="dash_tile">
                                                <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                <span class="pull-right"><a href="javascript:void(0)"><i class="material-icons tiny offline">videocam_off</i></a></span>
                                                <span class="title_tile">Cesar Manrique</span>
                                                <span class="date_tile"><small>02/12/16 1:00 pm</small></span>

                                            </div>-->
                                        @endif
                                    @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="col m6 s12 padding_adjust">
                                <div class="info-box">
                                    <span class="info-title grey lighten-3">Announcements</span>
                                    <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                        @if($announcement->isEmpty())
                                            <div class="dash_tile"><center><span> No announcement today.</span></center></div>
                                        @else
                                            @foreach($announcement as $announce)
                                                <div class="dash_tile">
                                                    <span class="pull-right"><a href="#announcement_view" onClick="showDetailsAnnouncementById({{ $announce->id }});" class=" waves-effect">Details</a></span>
                                                    <span class="title_tile">{{ $announce->announceTitle }}</span>
                                                    <span class="date_tile appt"><small>{{ $announce->created_at }}</small></span>
                                               </div>
                                            @endforeach
                                        @endif
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

        <!-- Modal Structure -->
        <div id="notif" class="modal bottom-sheet">
            <div class="modal-content">
                <h6 class="grey-text">Appointment Notifications</h6>
                <ul>
                    @foreach($appt as $appt)
                        <li class="teal lighten-5">
                            @if($appt->profile_img !== 'dp.png')
                                <figure class="school_badge" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $appt->profile_img }}')"></figure>
                            @else
                                <figure class="school_badge" style="background-image: url('{{ asset('/images/profile/dp.png') }}')"></figure>
                            @endif

                            <span class="truncate">{{ $appt->first_name }} {{ $appt->last_name }}</span>
                            @if($appt->action === 'Accept')
                                <small class="teal-text">Accepted your appointment request.</small>
                            @elseif($appt->action === 'Inperson')
                                <small class="blue-text">Will see you in person.</small>
                            @else
                                <small class="red-text">Declined your appointment.</small>
                                <small><!--<a href="#appointment_declined-reason" class="">View Details</a>--></small>
                                <!--onClick="onUsersDecline({{ $appt->Appt_id }});"-->
                            @endif

                            <small class="right grey-text">
                                {{ $appt->updated_at }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer grey lighten-2">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
            </div>
        </div>

        <!-- Modal Structure For Declined Reason-->
        <div id="appointment_declined-reason" class="modal">
            <div class="modal-content">
                <h5>Reason why the parent Declined</h5>
                <p id="area_reason_text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore hic, animi tempora corrupti obcaecati, cumque at. Odit expedita libero fugiat esse nihil autem cum, ducimus fugit provident veniam reiciendis nesciunt.
                </p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

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
    <script src="{{ asset('functions_js/appointment.js') }}"></script>
    <script src="{{ asset('functions_js/timer.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
    <script type="text/javascript">
        var iamOnvideoPanel = false;
        $(document).ready(function(){
            changeIconOnloadOnNotIntime();
            translateDate();
        });

        $('.modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() {

            }, // Callback for Modal open
            complete: function() {
                $('#notif_block .count').html('0');
                var url = '/appointment/v2/process/parent/setAppointmentToSeen';
                $.ajax({
                    type: "POST",
                    url: url,
                    processData:false,
                    contentType:false,
                    async: true,
                    cache:false
                });
            } // Callback for Modal close
        });

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
                                    '<td>'+dateTohuman(data.created_at)+'</td></tr>'+
                                    '<td>Posted By</td>'+
                                    '<td>'+data.first_name+'</td></tr>'+
                                    '</tbody>'+
                        '</table>'+
                        '<p>'+data.announcement+'</p>';
            $('#announcement_view .modal-content').html(view);
        }



        function dateTohuman(date){
            //var dateObject = new Date(Date.parse(date));
            var dateReadable = moment(date).format("dddd, MMMM Do YYYY, h:mm:ss a"); //dateObject.toDateString();
            return dateReadable;
        }

        function translateDate(){
            $('.appt').each(function(index){
                 $(this).find('small').html(dateTohuman($(this).find('small').html()));
            });
        }


    </script>
    @stop
