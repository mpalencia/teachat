
    @extends('theme')
    @section('title_tag')
        <title>Teacher : Video Chat</title>
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
                                <li class="active nav_tab" id="msgs">
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
                    @include('Universal::messages-body')
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <script type="text/javascript">
            $('.c_content').on('click', function(){
                $('.c_content').removeClass('blue-grey darken-4');
                $(this).addClass('blue-grey darken-4');
            });
        </script>
    @stop