
    @extends('theme')
        @section('title_tag')
            <title>Parent : Child</title>
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
                                <li class="active nav_tab" id="child">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">recent_actors</i>Child </a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/parent/teachers-list" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/parent/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages </a>
                                </li>
                                <li class="nav_tab" id="appointment">
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
                            <h4>Child / Children</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <div class="actions">
                                                <a href="/parent/child/add" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Child">Add <i class="material-icons">playlist_add</i></a>
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Birthdate</th>
                                                    <th>Age</th>
                                                    <th>Grade / Section</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($child as $child)
                                                    <tr class="child_on_list" id="{{ $child['child_lname'] }}" >
                                                        <td>{{ $child['child_fname'] }} {{ $child['child_mi'] }} {{ $child['child_lname'] }}</td>
                                                        <td title="System">{{ $child['child_date_of_birth'] }}</td>
                                                        <td>{{ $child['child_age'] }}</td>
                                                        <td> {{ $child['child_grade'] }} - {{ $child['child_section'] }}</td>
                                                        <td>
                                                            <a class="btn-flat dropdown-button waves-effect" data-beloworigin="true" href="javascript:void(0)" data-activates="{{ $child['id'] }}"><i class="large material-icons">settings</i></a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='{{ $child["id"] }}' class='dropdown-content'>
                                                                <li><a href="/parent/child/edit/{{ $child['id'] }}"><i class="material-icons">edit</i> Edit</a></li>
                                                                <li><a href="#delete_child_modal" class="waves-effect waves-light modal-trigger" data-id="{{ $child['id'] }}" data-name="{{ $child['child_fname'] }} {{ $child['child_mi'] }} {{ $child['child_lname'] }}" ><i class="material-icons">delete</i>Delete</a></li>
                                                                @if($upload === 1)
                                                                    <li><a href="#file_upload" class="modal-trigger_ waves-effect waves-light teal white-text" data-id="{{ $child['id'] }}" data-name="{{ $child['child_fname'] }} {{ $child['child_mi'] }} {{ $child['child_lname'] }}" ><i class="material-icons">attach_file</i> Files</a></li>
                                                                @endif
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div id="delete_child_modal" class="modal">
                        <div class="modal-content">
                            <center>
                                <h5 class="child_name">Name of Child here.</h5>
                                <div class="divider"></div>
                                <h5>Will be deleted from the entries.</h5>
                                <h5>Are you sure?</h5>
                            </center>
                            <div class="row">
                                <div class="input-field col s12 m4 offset-m2">
                                    <a href="#!" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete">Yes <i class="material-icons right">check</i></a>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="#!" class="modal-action modal-close btn waves-effect btn-large btn-block waves-light red" type="submit" name="action">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal For Attachemnt List-->
                    <div id="file_upload" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h5 class="child_name">( Name of Child here )</h5>
                            <ul class="collection with-header">
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content btn_downloadFileById"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer teal darken-4">
                            <a href="#file_attach" class="waves-effect waves-light btn modal-action modal-close">Close</a>
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
        <script src="{{ asset('functions_js/addChild.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".dropdown-button").dropdown({
                    hover: false,
                    inDuration: 150,
                    belowOrigin: false, // Displays dropdown below the button
                });
                $('.modal-trigger').click(function(e){

                    //get the clicked on link
                    var $link = $(e.target);

                    //get the data-target of that link
                    var id =$link.data('id');
                    var name = $link.data('name');
                        $('#delete_child_modal .child_name').html(name);
                        $('#delete_child_modal .btn_yes_delete').attr('onClick','showDeleteModal('+id+')');

                    //open the modal
                    var $modal = $($link.attr('href'));
                    $modal.openModal();
                });

                $('.modal-trigger_').click(function(e){

                    //get the clicked on link
                    var $link = $(e.target);

                    //get the data-target of that link
                    var id =$link.data('id');
                    var name = $link.data('name');
                        $('#file_upload .child_name').html(name);
                        $('#file_upload .btn_downloadFileById').attr('onClick','btn_downloadFileById('+id+')');
                        getAllfileofSelectedStudent(id);

                    //open the modal
                    var $modal = $($link.attr('href'));
                    $modal.openModal();
                });

                $('.tooltipped').tooltip();
            });
        </script>
    @stop