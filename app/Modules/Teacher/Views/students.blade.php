<?php
    
   use App\Modules\Subject\Models\Subject;
    
?>
    @extends('theme')
    @section('title_tag')
        <title>Teacher : Students</title>
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
                                <li class="active nav_tab" id="child">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">assignment_ind</i>Students </a>
                                </li>
                                <li class="nav_tab" id="msgs">
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
                    <div class="profile-content">
                        <div class="row">
                            <h4>Students</h4>
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
                                                    <th>Student</th>
                                                    <th>Grade / Section</th>
                                                    <th>Subject</th>
                                                    <th>Parent</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($students as $student)
                                                    <tr>
                                                        <td>{{ $student->child_fname }} {{ $student->child_mi }}. {{ $student->child_lname }}</td>
                                                        <td title="System">{{ $student->child_grade }} / {{ $student->child_section }}</td>
                                                        <td>
                                                            <?php
                                                                echo Subject::where('id',$student->subject_id)->value('subject_name');
                                                                
                                                            ?> 
                                                        </td>
                                                        <td title="{{ $student->name_prefix }}{{ $student->first_name }} {{ $student->last_name }}">
                                                            @if($student->active == 0)
                                                                <i class="fa fa-fw fa-circle offline"></i>{{ $student->name_prefix }}{{ $student->first_name }} {{ $student->last_name }}
                                                            @else
                                                                <i class="fa fa-fw fa-circle online"></i>{{ $student->name_prefix }}{{ $student->first_name }} {{ $student->last_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($upload === 1)
                                                                <a class="btn-flat dp_custom waves-effect" href="javascript:void(0)" data-activates="{{ $student->STUDENT_ID }}"><i class="large material-icons">settings</i></a>
                                                                <!-- Dropdown Structure -->
                                                                <ul id='{{ $student->STUDENT_ID }}' class='dropdown-content'>
                                                                    <li><a href="/videochat/call/{{ $student->qbUserId }}"><i class="material-icons">videocam</i> Call</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#file_upload" class="waves-effect waves-light modal-trigger teal white-text" data-id="{{ $student->id }}" data-name="{{ $student->child_fname }} {{ $student->child_mi }}. {{ $student->child_lname }}" ><i class="material-icons">attach_file</i> Files</a></li>
                                                                </ul>
                                                            @else
                                                                <a class="btn-flat dp_custom waves-effect" href="javascript:void(0)" data-activates="{{ $student->STUDENT_ID }}"><i class="large material-icons">settings</i></a>
                                                                <!-- Dropdown Structure -->
                                                                <ul id='{{ $student->STUDENT_ID }}' class='dropdown-content'>
                                                                    <li><a href="/videochat/call/{{ $student->qbUserId }}"><i class="material-icons">videocam</i> Call</a></li>
                                                                    <li class="divider"></li>
                                                                </ul>
                                                            @endif
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

                    <!-- Modal For Attachemnt List-->
                    <div id="file_upload" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h5 class="student_name"></h5>
                            <ul class="collection with-header">
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
                            <a href="#file_attach" class="waves-effect waves-light btn modal-action modal-close red"><i class="material-icons">clear</i></a>
                            <a href="#file_attach" class="waves-effect waves-light btn modal-trigger_">Attach File <i class="material-icons">launch</i></a>
                        </div>
                    </div>

                    <!-- Modal For File Attachments -->
                    <div id="file_attach" class="modal">
                        <div class="modal-content">
                            <h5 class="student_name">Attach a file for ( Name of Student here )</h5>
                            <div class="row">
                                <form class="col s12" id="frm_attacht_file">
                                    <div class="row">
                                        <div class="input-field col s12 m12">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>File</span>
                                                    <input type="file" name="file">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="student_id" id="student_id"></input>
                                    <div class="row">
                                        <div class="input-field col s12 m8">
                                            <input id="attachment_desc" type="text" required="required" aria-required="true" name="file_desc">
                                            <label for="attachment_desc">Attachment Description</label>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <button class="btn waves-effect btn-block waves-light modal-action modal-close" type="submit">Attach</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Delete -->
                    <div id="delete_attach_file" class="modal">
                        <div class="modal-content">
                            <center>
                                <h5 class="file_name"></h5>
                                <div class="divider"></div>
                                <h5>This file will be deleted from the uploads.</h5>
                                <h5>Are you sure?</h5>
                            </center>
                            <div class="row">
                                <div class="input-field col s12 m4 offset-m2">
                                    <a href="#!" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete">Yes <i class="material-icons right">check</i></a>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="#!" class="modal-action modal-close btn waves-effect btn-large btn-block waves-light red">Cancel</a>
                                </div>
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
        <script src="{{ asset('functions_js/student_file.js')}}"></script>
        <script type="text/javascript">
            $(".dp_custom").dropdown({
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
                        $('#file_upload .student_name').html(name);
                        $('#file_upload .modal-trigger_').attr('id',id);

                    //open the modal
                    var $modal = $($link.attr('href'));
                    $modal.openModal();
                    
                        getAllfileofSelectedStudent(id);
                    
                });

            $('.modal-trigger_').click(function(e){

                    //get the clicked on link
                    var $link = $(e.target);

                    //get the data-target of that link
                    var id = $(this).attr('id');
                      var name = $('#file_upload .student_name').html();
                      $('#frm_attacht_file #student_id').val(id);
                      $('#file_attach .student_name').html('Attach a file for <strong>'+name +'</strong>');
                    //open the modal
                    var $modal = $($link.attr('href'));
                    $modal.openModal();
                });

            $('.deleteModal-trigger').delegate('click',function(){
                alert();
            });

        </script>
    @stop