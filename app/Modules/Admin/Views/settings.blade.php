
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
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                @include('Universal::adminName')
                            </div>
                            <div class="profile-usertitle-job">
                                Administrator
                            </div>
                        </div>
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/admin" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/admin/announcements" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                                </li>
                                <li class="active nav_tab" id="settings">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                    <div class="row">
                        <h4>Settings</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div class="row">
                            @include('Universal::password')
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