
    @extends('theme')
        @section('title_tag')
            <title>Parent : Dashboard</title>
            <meta name="robots" content="noindex">
            <meta name="googlebot" content="noindex">
        @stop

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-parent')

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
                                    <a href="/parent/myaccount" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/parent/child" class="waves-effect"><i class="material-icons">recent_actors</i>Child </a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/parent/teachers-list" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/parent/videochat" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages </a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/parent/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/parent/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/parent/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
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

                            <div class="col m3 s12 padding_adjust padding_adjust">
                                <a href="/parent/messages">
                                    <span class="info-box-icon red" style="background-image: url('{{asset('/images/bg_msg.png')}}');">
                                        <br/><span class="desc">Messages</span><br/><br/>
                                        <br/><span class="count" id="Message_total">0</span>
                                    </span>
                                </a>
                            </div>

                            <div class="col m6 s12 padding_adjust right">
                                <div class="info-box">
                                    <span class="info-title grey lighten-3"> Appointments for today</span>
                                    <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                                    @if( $todays_appt != null)
                                        @foreach($todays_appt as $todays)
                                            @if($todays->action === 'Accept' || $todays->action === 'Inperson' || $todays->action == null)
                                                <div class="dash_tile appointment" id="{{ $todays->Appt_id }}">
                                                @if($todays->active == 0)
                                                    @if($todays->profile_img === 'dp.png')
                                                        <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                    @else
                                                        <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $todays->profile_img  }}')"></figure>
                                                    @endif
                                                    <span class="pull-right appt_class"><a href="javascript:void(0)" id=""><i class="material-icons tiny offline">videocam_off</i></a></span>
                                                @else
                                                    @if($todays->profile_img === 'dp.png')
                                                        <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                    @else
                                                        <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $todays->profile_img  }}')"></figure>
                                                    @endif
                                                    <!-- <span class="pull-right appt_class"><a href="#" id="" onClick="timerCheckerRedirectVideoChat(8899593,{{ $todays->Appt_id }});"><i class="material-icons tiny">videocam</i></a></span> -->
                                                    <span class="pull-right appt_class"><a href="#" id="btnCall" data-id="{{$todays->teacher_id}}"><i class="material-icons tiny">videocam</i></a></span>
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
                                    @else
                                        <div class="dash_tile"><center><span>You have no appointment today.</span></center></div>
                                    @endif
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

    @stop

    @section('additional_bodytag')
    <script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
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
                $.get('/appointment/v2/process/parent/getAllNewAppointment',{},function(data){
                    var json = JSON.parse(data);
                    var files = json.length;
                    $('#notif_modal_body').html(' ');
                    for(i = 0; i < files; i++){
                        var image;
                        if(json[i].profile_img !== 'dp.png'){
                            image = 'https://s3-ap-southeast-1.amazonaws.com/teachatco/images/'+json[i].profile_img;
                        }else{
                            image = '/images/profile/dp.png';
                        }
                        var body = '<li class="teal lighten-5">'+
                                    '<figure class="school_badge" style="background-image: url('+image+')"></figure>'+
                                    '<span class="truncate">'+json[i].name_prefix+' '+json[i].first_name+' '+json[i].last_name+'</span>'+
                                    '<small class="teal-text">New appointment</small> '+
                                    '<p class="right" style="margin-top: -33px;"><a href="#appointment_details" onClick="functionViewDetail('+json[i].Appt_id+');" class="modal-trigger teal-text">View Details</a><br/>'+
                                    '<small class="grey-text">'+dateTohuman(json[i].appt_date)+' <br/> '+json[i].appt_stime+' </small></p>'+
                                '</li>';
                        $('#notif_modal_body').append(body);
                    }

                });
            }, // Callback for Modal open
            complete: function() {
                $('#notif_block .count').html('0');
                /*var url = '/appointment/v2/process/parent/setAppointmentToSeen';
                $.ajax({
                    type: "POST",
                    url: url,
                    processData:false,
                    contentType:false,
                    async: true,
                    cache:false
                }); */
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
                                    '<td>'+data.created_at+'</td></tr>'+
                                    '<td>Posted By</td>'+
                                    '<td>'+data.first_name+'</td></tr>'+
                                    '</tbody>'+
                        '</table>'+
                        '<p>'+data.announcement+'</p>';
            $('#announcement_view .modal-content').html(view);
        }

        function dateTohuman(date){
            //var dateObject = new Date(Date.parse(date));
            var dateReadable = moment(date).format("dddd, MMMM MM YYYY");//dateObject.toDateString();
            return dateReadable;
        }

        function translateDate(){
            $('.appt').each(function(index){
                 $(this).find('small').html(dateTohuman($(this).find('small').html()));
            });
        }


    </script>
    @stop
