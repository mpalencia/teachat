
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
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/admin" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="active nav_tab" id="overview">
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
                                <li class="nav_tab" id="appointment">
                                    <a href="/admin/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/admin/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                    <div class="row">
                        <h4>Announcement Title</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>For</td>
                                        <td>Parents / Teachers / ALL</td>
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
                    </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <!-- Scripts for Under Body -->
    @stop