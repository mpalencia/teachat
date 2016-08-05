
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
                            <h4>Edit an Appointment</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form action="add-appointments_submit" method="get" accept-charset="utf-8">
                                    <div class="input-field col s12 m12">
                                        <select class="parent_select validate" required="">
                                            <option value="0" selected>-- Choose a parent -- </option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="appointment_date" type="text" readonly="" required="" class="">
                                        <label for="appointment_date">Appointment Date</label>
                                    </div>
                                    <div id="appoinment_time">
                                        <div class="input-field col s12 m4">
                                            <input placeholder="Appointment Start Time" id="appointment_stime" type="text" class="time start" required="">
                                            <label for="appointment_stime">Appointment Start Time</label>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <input placeholder="Appointment End Time" id="appointment_etime" type="text" class="time end" required="">
                                            <label for="appointment_etime">Appointment End Time</label>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="appointment_title" type="text" class="validate" required="">
                                        <label for="appointment_title">Appointment Title</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="appointment_description" class="materialize-textarea" required=""></textarea>
                                        <label for="appointment_description">Appointment Description</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="file-field input-field">
                                            <div class="btn">
                                                <span>File</span>
                                                <input type="file">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" placeholder="Select a file to upload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit" name="action">Add
                                            <i class="material-icons right">perm_contact_calendar</i>
                                        </button>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <a href="/teacher/appointments" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
        <script src="{{ asset('select/select2.full.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}"></link>
        <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('time_picker/jquery.timepicker.min.js') }}"></script><!-- Time Picker -->
        <link rel="stylesheet" href="{{ asset('time_picker/jquery.timepicker.css') }}"></link>
        <script src="{{ asset('time_picker/datepair.min.js') }}"></script><!-- Date Picker -->
        <script src="{{ asset('time_picker/jquery.datepair.min.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function() {
                $('.parent_select').select2();//Initialize Select2 Elements
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });
            /* Date Picker jQuery UI*/
            $(function() {
                $( "#appointment_date" ).datepicker({ minDate: 0,
                    dateFormat: 'yy-mm-dd',
                    buttonImageOnly: true,
                    buttonText: "Select date"
              });
            });
            /* Time Picker */
            $('#appoinment_time .time').timepicker({
                'minTime': '7:00am',
                'maxTime': '7:00pm',
                'timeFormat': 'h:i A',
                'step': '15',
                'disableTimeRanges': [
                  ['12pm', '1pm']
                ]
            });

            var appoinment_time = document.getElementById('appoinment_time');
            var timeOnlyDatepair = new Datepair(appoinment_time);

            $('#dateOnlyExample .date').datepicker({
                'format': 'yyyy-m-d',
                'autoclose': true
            });
            var dateOnlyExampleEl = document.getElementById('dateOnlyExample');
            var dateOnlyDatepair = new Datepair(dateOnlyExampleEl);
        </script>
    @stop