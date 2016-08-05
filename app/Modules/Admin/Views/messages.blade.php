
    @extends('theme')

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')


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
                                <li class="nav_tab" id="overview">
                                    <a href="/admin/announcements" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                                </li>
                                <li class="nav_tab" id="teachers">
                                    <a href="/admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="parents">
                                    <a href="/admin/parents" class="waves-effect"><i class="material-icons">assignment_ind</i>Parents </a>
                                </li>
                                <li class="active nav_tab" id="msgs">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">forum</i>Messages </a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/admin/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
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