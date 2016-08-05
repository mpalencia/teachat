
    @extends('theme')
        @section('title_tag')
            <title>Parent : Appointments</title>
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
                                <li class="nav_tab" id="dashboard">
                                    <a href="/parent/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
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
                                    <a href="/parent/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages </a>
                                </li>
                                <li class="active nav_tab" id="appointment">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
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
                            <h4>Appointments</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
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

                                                            <span class="appointment_title"> {{ $app->parent_id[0]->user[0]->first_name }} {{ $app->parent_id[0]->user[0]->last_name }} </span>
                                                            <small>{{ $app->appt_stime }} - {{ $app->appt_etime }}</small>
                                                        </div>
                                                        <div class="options_container">
                                                            <div class="col s12 m4 options_btn">
                                                                <div class="right">
                                                                    @if( $app->action === null ||  $app->action === '')
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
                                        <li class="row">
                                            <div class="col s12 m8">
                                                <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                <span class="appointment_title"> Mr. Parent Parent </span>
                                                <small>01:00 PM - 02:00 PM</small>
                                            </div>
                                            <div class="options_container">
                                                <div class="col s12 m4 options_btn">
                                                    <div class="right">
                                                        <a class="waves-effect waves-light btn modal-trigger amber darken-3 tooltipped" href="#appointment_details" data-position="left" data-tooltip="Waiting for Confirmation"><i class="material-icons">warning</i></a><!-- Modal Trigger For Appointment Details-->
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col s12 m8">
                                                <figure style="background-image: url('{{ asset('/images/dp.png') }}')"></figure>
                                                <span class="appointment_title"> Mr. Parent Parent </span>
                                                <small>01:00 PM - 02:00 PM</small>
                                            </div>
                                            <div class="options_container">
                                                <div class="col s12 m4 options_btn">
                                                    <div class="right">
                                                        <a class="waves-effect waves-light btn modal-trigger" href="#appointment_details"><i class="material-icons">zoom_in</i></a><!-- Modal Trigger For Appointment Details-->
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <link rel="stylesheet" type="text/css" href="{{ asset('zabuto_calendar/zabuto_calendar.css')}}">
        <script src="{{ asset('zabuto_calendar/zabuto_calendar.min.js')}}"></script>
        <script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
        <script type="application/javascript">
            $(document).ready(function () {
              var baseUrl = document.location.origin;//location.host;
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
                $('.tooltipped').tooltip({delay: 10});
                $('ul.tabs').tabs();
            }
        </script>
    @stop
