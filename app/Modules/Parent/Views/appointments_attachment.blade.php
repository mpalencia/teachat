
    @extends('theme')
    @section('title_tag')
        <title>Parent : View Attach File</title>
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
                            <h4>{{ $appointment[0]->title }}</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row attachment_view_">
                                <div class="col m7 attach_container">
                                @if(preg_match( '/^image.*/', $appointment[0]->file_data[0]->mimetype))
                                    <center>
                                        <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/attach/{{ $appointment[0]->file_data[0]->file_name }}" id="img_drag"><!-- For Img-->
                                    </center>
                                @else
                                    <iframe src="https://docs.google.com/viewer?url=https://s3-ap-southeast-1.amazonaws.com/teachatco/attach/{{ $appointment[0]->file_data[0]->file_name }}&embedded=true"></iframe><!-- For Docsx-->
                                @endif
                                </div>
                                <div class="col m5">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Meeting with</td>
                                                <td>: {{ $appointment[0]->user[0]->first_name }} {{ $appointment[0]->user[0]->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td>: {{ $appointment[0]->appt_stime }} - {{ $appointment[0]->appt_etime }}</td>
                                            </tr>
                                            <tr>
                                                <td>Attachment</td>
                                                <td><a href="/universal/v2/process/downloadFileById/{{ $appointment[0]->file_id }}">: <i class="material-icons">description</i> Download</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="height: 200px; overflow-y: scroll;">{{ $appointment[0]->description }}</p>
                                    @if( $appointment[0]->action === 'Accept')
                                        <a href="#!" class="disabled waves-effect btn btn-block" onClick="parentAppointmentResponse(0);">Accept</a> <div class="divider"></div>
                                        <a href="#!" class="waves-effect btn btn-block blue darken-4" onClick="parentAppointmentResponse(1);">See in person</a><div class="divider"></div>
                                        <a href="#!" class="waves-effect btn btn-block red modal-action modal-close" onClick="parentAppointmentResponseDeclineModal({{ $appointment[0]->id }});">Decline</a>
                                    @elseif( $appointment[0]->action === 'Inperson' )
                                        <a href="#!" class="waves-effect btn btn-block" onClick="parentAppointmentResponse(0);">Accept</a> <div class="divider"></div>
                                        <a href="#!" class=" disabled waves-effect btn btn-block blue darken-4" onClick="parentAppointmentResponse(1);">See in person</a><div class="divider"></div>
                                        <a href="#!" class="waves-effect btn btn-block red modal-action modal-close" onClick="parentAppointmentResponseDeclineModal({{ $appointment[0]->id }});">Decline</a>
                                    @else
                                        <a href="#!" class="waves-effect btn btn-block" onClick="parentAppointmentResponse(0);">Accept</a> <div class="divider"></div>
                                        <a href="#!" class="waves-effect btn btn-block blue darken-4" onClick="parentAppointmentResponse(1);">See in person</a><div class="divider"></div>
                                        <a href="#!" class="waves-effect btn btn-block red modal-action modal-close" onClick="parentAppointmentResponseDeclineModal({{ $appointment[0]->id }});">Decline</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}"></link>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
    <script type="text/javascript">
        selectedAppoingmentID = '{{ $appointment[0]->id }}';
        $('#img_drag').draggable({ containment: ".attach_container", scroll: false, cursor: "move", cursorAt: { top: 56, left: 56 }});
    </script>
    @stop
