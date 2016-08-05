
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
                                    <a href="/admin/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="teachers">
                                    <a href="/admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="active nav_tab" id="parents">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">assignment_ind</i>Parents </a>
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
                            <h4>Parents</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <div class="actions">
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Parents</th>
                                                    <th>Child</th>
                                                    <th>Grade / Section</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><i class="fa fa-fw fa-circle online"></i>First Name Last Name 1</td>
                                                    <td>Child Name Last Name 1</td>
                                                    <td title="System">Grade - Section</td>
                                                    <td>
                                                        <a href="#" class="btn waves-effect teal"><i class="material-icons white-text">videocam</i></a>
                                                        <a href="#" class="btn waves-effect deep-orange"><i class="material-icons  white-text">message</i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-fw fa-circle online"></i>First Name Last Name 2</td>
                                                    <td>Child Name Last Name 1</td>
                                                    <td title="System">Grade - Section</td>
                                                    <td>
                                                        <a href="#" class="btn waves-effect teal"><i class="material-icons white-text">videocam</i></a>
                                                        <a href="#" class="btn waves-effect deep-orange"><i class="material-icons  white-text">message</i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal For Attachemnt List-->
                    <div id="file_upload" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h5>( Name of Student here )</h5>
                            <ul class="collection with-header">
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content delete"><i class="material-icons waves-effect waves-red">delete</i></a>
                                        <a href="#!" class="secondary-content"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content delete"><i class="material-icons waves-effect waves-red">delete</i></a>
                                        <a href="#!" class="secondary-content"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content delete"><i class="material-icons waves-effect waves-red">delete</i></a>
                                        <a href="#!" class="secondary-content"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content delete"><i class="material-icons waves-effect waves-red">delete</i></a>
                                        <a href="#!" class="secondary-content"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer teal darken-4">
                            <a href="#file_attach" class="waves-effect waves-light btn modal-trigger">Attach File <i class="material-icons">launch</i></a>
                        </div>
                    </div>

                    <!-- Modal For File Attachments -->
                    <div id="file_attach" class="modal">
                        <div class="modal-content">
                            <h5>Attach a file for ( Name of Student here )</h5>
                            <div class="row">
                                    <form class="col s12">
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <span>File</span>
                                                        <input type="file">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <input id="attachment_desc" type="text" required="required" aria-required="true">
                                                <label for="attachment_desc">Attachment Description</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <button class="btn waves-effect btn-block waves-light modal-action modal-close" type="submit" name="action">Attach</button>
                                            </div>
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
        <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
        <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
        <script type="text/javascript">
            $(".dp_custom").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: false, // Displays dropdown below the button
            });
            $('.modal-trigger').leanModal();
        </script>
    @stop