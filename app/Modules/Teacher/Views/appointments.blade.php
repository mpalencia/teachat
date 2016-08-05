
    @extends('theme')
    @section('title_tag')
        <title>Teacher : Appointments</title>
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
                                <li class="nav_tab" id="dashboard">
                                    <a href="/teacher/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/teacher/myaccount" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/teacher/students" class="waves-effect"><i class="material-icons">assignment_ind</i>Students </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/teacher/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages</a>
                                </li>
                                <li class="active nav_tab" id="appointment">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
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
                            <h4>Appointments</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <a href="/teacher/appointments/add" class="btn waves-effect waves-light teal" type="submit" name="action">Add
                                <i class="material-icons right">perm_contact_calendar</i>
                            </a><br/><br/>

                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        <li class="tab col s6"><a href="#calendar_view" class="green-text">Calendar View</a></li>
                                        <li class="tab col s6"><a href="#list_view" class="active green-text">List View</a></li>
                                    </ul>
                                </div>

                                <div id="calendar_view" class="col s12">
                                    <br/>
                                    <div id="my-calendar"></div>
                                </div>

                                <div id="list_view" class="col s12">
                                    <br/>
                                    @foreach($dates as $date)
                                        <div id="appointment_listholder">
                                            <h5>{{ $date->appt_date }}</h5>
                                            <ul class="appointment_list">
                                            @foreach($appts as $app)
                                                @if($app->appt_date == $date->appt_date)
                                                    <li class="row">
                                                        <div class="col s12 m8">
                                                            @if($app->parent_id[0]->user[0]->profile_img === 'dp.png')
                                                                <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                            @else
                                                                <figure style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{  $app->parent_id[0]->user[0]->profile_img }}')"></figure>
                                                            @endif

                                                            <span class="appointment_title">{{ $app->parent_id[0]->user[0]->name_prefix }} {{ $app->parent_id[0]->user[0]->first_name }} {{ $app->parent_id[0]->user[0]->last_name }} </span>
                                                            <small>{{ $app->appt_stime }} - {{ $app->appt_etime }}</small>
                                                        </div>
                                                        <div class="options_container">
                                                            <div class="col s12 m4 options_btn">
                                                                <div class="right">
                                                                    @if( $app->action === null || $app->action === '')
                                                                        <a class="waves-effect waves-light btn  amber darken-3 tooltipped" onClick="functionViewDetail( {{ $app->id }} );" href="#appointment_details" data-position="left" data-tooltip="Waiting for Confirmation"><i class="material-icons">zoom_in</i></a>
                                                                    @elseif( $app->action == 'Accept' )
                                                                        <a class="waves-effect waves-light btn darken-3 tooltipped" onClick="functionViewDetail( {{ $app->id }} );" href="#appointment_details" data-position="left" data-tooltip="Accepted"><i class="material-icons">zoom_in</i></a>
                                                                    @elseif( $app->action == 'Inperson')
                                                                        <a class="waves-effect waves-light btn  blue darken-3 tooltipped" onClick="functionViewDetail( {{ $app->id }} );" href="#appointment_details" data-position="left" data-tooltip="In person"><i class="material-icons">zoom_in</i></a>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <br/>
                            <!-- Modal Trigger For Todays Appointment
                            <a class="waves-effect waves-light btn modal-trigger" href="#view_appointment">Modal</a>-->

                            <!-- Modal Structure For Todays Appointment-->
                            <div id="view_appointment" class="modal bottom-sheet">
                                <div class="modal-content">
                                    <h5>Appointments for <span class="date_selected"></span></h5>
                                    <div class="divider"></div>
                                    <ul class="appointment_list">


                                    </ul>
                                </div>
                            </div>

                            <!-- Modal Structure For Appointment Details-->
                            <div id="appointment_details" class="modal">
                                <div class="modal-content">
                                   <center>
                                       <div class="preloader-wrapper big active">
                                            <div class="spinner-layer spinner-blue-only">
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
                                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <link rel="stylesheet" type="text/css" href="{{ asset('zabuto_calendar/zabuto_calendar.css')}}">
        <script src="{{ asset('zabuto_calendar/zabuto_calendar.min.js')}}"></script>
        <script src="{{ asset('functions_js/appointment.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function () {
              //var baseUrl = document.location.origin;//location.host;
                call_mycalendar();
            });
            /* Zabuto Calendar */
            function call_mycalendar(){
              //alert();
              $("#my-calendar").zabuto_calendar({
                  language: "en",
                 // data: eventData,
                  cell_border: true,
                  today: true,
                  show_days: true,
                  weekstartson: 0,
                  nav_icon: {
                    prev: '<i class="fa fa-chevron-left"></i>',
                    next: '<i class="fa fa-chevron-right"></i>'},
                 ajax: {
                    url: "/appointment/v2/process/getAllAppointmentByUser",
                    modal: false },
                    action:function(){calendarClick(this.id);}
                });
                /* Modal*/
                $('.modal-trigger').leanModal();
            }

            /* Hide and Show Delete Btn*/
            function showDelete(id){
                $('#'+id).find('.confirm_delete').removeClass('hide');
                $('#'+id).find('.options_btn').addClass('hide');
            };

            function cancel_delete(id){
                $('#'+id).find('.confirm_delete').addClass('hide');
                $('#'+id).find('.options_btn').removeClass('hide');
            };
        </script>
    @stop
