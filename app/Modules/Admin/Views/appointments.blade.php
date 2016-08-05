
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
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                @include('Universal::adminName')
                            </div>
                            <div class="profile-usertitle-job">
                                Administrator
                            </div>
                        </div>
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/admin" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/admin/announcements" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                                </li>
                                <li class="nav_tab" id="teachers">
                                    <a href="/admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="parents">
                                    <a href="/admin/parents" class="waves-effect"><i class="material-icons">assignment_ind</i>Parents </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/admin/messages" class="waves-effect"><i class="material-icons">forum</i>Messages </a>
                                </li>
                                <li class="active nav_tab" id="appointment">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/admin/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
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
                            <h4>Appointments</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <a href="/admin/appointments/add" class="btn waves-effect waves-light teal" type="submit" name="action">Add
                                <i class="material-icons right">perm_contact_calendar</i>
                            </a><br/><br/>
                            <div id="my-calendar"></div>
                            <br/>
                            <!-- Modal Trigger For Todays Appointment-->
                            <a class="waves-effect waves-light btn modal-trigger" href="#view_appointment">Modal</a>

                            <!-- Modal Structure For Todays Appointment-->
                            <div id="view_appointment" class="modal bottom-sheet">
                                <div class="modal-content">
                                    <h5>Appointments for today</h5>
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
                                                        <a class="waves-effect waves-light btn modal-trigger" href="#appointment_details"><i class="material-icons">zoom_in</i></a><!-- Modal Trigger For Appointment Details-->
                                                        <a href="/admin/appointments/edit" class="waves-effect waves-light btn orange"><i class="material-icons">edit</i></a>
                                                        <a href="javascript:void(0)" class="waves-effect waves-light btn red delete_trigger-btn"><i class="material-icons">delete</i></a>
                                                    </div>
                                                </div>
                                                <div class="col s12 m4 hide confirm_delete">
                                                    <div class="right">
                                                        <h6>Delete this appointment?</h6> 
                                                        <a href="#!" class="waves-effect waves-light btn">Yes</a>
                                                        <a href="javascript:void(0)" class="waves-effect waves-light btn red cancel_delete">No</a>
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
                                                        <a href="/admin/appointments/edit" class="waves-effect waves-light btn orange"><i class="material-icons">edit</i></a>
                                                        <a href="javascript:void(0)" class="waves-effect waves-light btn red delete_trigger-btn"><i class="material-icons">delete</i></a>
                                                    </div>
                                                </div>
                                                <div class="col s12 m4 hide confirm_delete">
                                                    <div class="right">
                                                        <h6>Delete this appointment?</h6> 
                                                        <a href="#!" class="waves-effect waves-light btn">Yes</a>
                                                        <a href="javascript:void(0)" class="waves-effect waves-light btn red cancel_delete">No</a>
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
                                    <h5>Meeting Title</h5>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Meeting with</td>
                                                <td>Name of Parent Will be placed here</td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td>Meeting time will be placed here</td>
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
                 /*ajax: {
                    url: baseUrl+"/profile/appointment/get_all_appt",
                    modal: false },
                    action:function(){myDateFunction(this.id);}*/
                });
                /* Modal*/
                $('.modal-trigger').leanModal();

                /* Hide and Show Delete Btn*/
                $('.delete_trigger-btn').on('click',function(){
                   var cl =  $(this).parent('div').parent('div').addClass('hide').parent('div').attr('class');
                        var xc = $(this).closest('.'+cl).find('.confirm_delete').removeClass('hide');
                });
                $('.cancel_delete').on('click',function(){
                    var cl = $(this).parent('div').parent('div').addClass('hide').parent('div').attr('class');
                    $(this).closest('.'+cl).find('.options_btn').removeClass('hide');
                });
            }
        </script>
    @stop