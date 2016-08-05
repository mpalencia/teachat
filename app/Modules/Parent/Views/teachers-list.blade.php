<?php
    
   use App\Modules\Subject\Models\Subject;
    
?>
    @extends('theme')
        @section('title_tag')
            <title>Parent : Teacher Lists</title>
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
                                <li class="active nav_tab" id="child">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
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
                        <h4>Teachers</h4>
                        <span class="divider"></span>
                        <div class="divider"></div>
                        <ul class="collapsible" data-collapsible="accordion">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">supervisor_account</i>Add a Teacher</div>
                                <div class="collapsible-body">
                                    <div class="row">
                                        <form class="col s12" id="frm_addNewStudent_parent">
                                            <div class="input-field col s12 m4">
                                                <select required="" aria-required="true" name="child_id">
                                                    <option value="" disabled selected>-- Child --</option>
                                                    @if(isset($child))
                                                        @foreach($child as $child)
                                                            <option value="{{ $child['id'] }}">{{ $child['child_fname'] }} {{ $child['child_mi'] }} {{ $child['child_lname'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <select required="" aria-required="true" id="select_teacher" name="teacher_id">
                                                    <option value="" disabled selected>-- Teacher --</option>
                                                    @if(isset($teacher))
                                                        @foreach($teacher as $teacher)
                                                            <option value="{{ $teacher['id'] }}">{{ $teacher['name_prefix'] }} {{ $teacher['first_name'] }} {{ $teacher['last_name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <select id="select_subject" name="subject_id">
                                                    <option value="" disabled selected>-- Subject --</option>
                                                    <label>Select</label>
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <button class="btn waves-effect btn-block waves-light" type="submit">Add<i class="material-icons right">add</i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="row">
                            @foreach($mychild as $mychild)
                                <div class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            {{ $mychild['child_fname'] }} {{ $mychild['child_mi'] }} {{ $mychild['child_lname'] }}
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Teacher's Name</th>
                                                    <th colspan="2">Grade / Section</th>
                                                    <th colspan="2">Subject</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    @if(isset($mychild['detail']))
                                                        @foreach($mychild['detail'] as $detail)
                                                            <tr>
                                                                <td colspan="2">
                                                                    @if($detail->active == '0')
                                                                        <i class="fa fa-fw fa-circle offline"></i>
                                                                    @else
                                                                        <i class="fa fa-fw fa-circle online"></i>
                                                                    @endif
                                                                    {{ $detail->name_prefix }}{{ $detail->first_name }} {{ $detail->last_name }}
                                                                </td>
                                                                <td colspan="2"> {{ $detail->child_grade }} - {{ $detail->child_section }}</td>
                                                                <td colspan="2">
                                                                   
                                                                    <?php
                                                                        echo Subject::where('id',$detail->subject_id)->value('subject_name');
                                                                        
                                                                    ?> 
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a class="btn-flat dp_custom waves-effect" href="javascript:void(0)" data-activates="{{ $detail->STUDENT_ID }}"><i class="large material-icons">settings</i></a>
                                                                    <!-- Dropdown Structure -->
                                                                    <ul id='{{ $detail->STUDENT_ID }}' class='dropdown-content'>
                                                                        @if($detail->active == 0)
                                                                            <li><a href="#" onclick="Materialize.toast('User is currently offline', 4000)" ><i class="material-icons">call</i> Call</a></li>
                                                                        @else
                                                                            <li><a href="/videochat/call/{{ $detail->qbUserId }}"><i class="material-icons">call</i> Call</a></li>
                                                                        @endif
                                                                        <li><a href="#delete_teacher_modal" class="waves-effect waves-light red modal-trigger white-text" data-name="{{ $detail->name_prefix }}{{ $detail->first_name }} {{ $detail->last_name }}" data-id="{{ $detail->STUDENT_ID }}"><i class="material-icons">delete</i>Delete</a></li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="8"><center>*** no teacher yet ***</center></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete -->
            <div id="delete_teacher_modal" class="modal">
                <div class="modal-content">
                    <center>
                        <h5 class="teacher_name">Name of Teacher here.</h5>
                        <div class="divider"></div>
                        <h5>Will be deleted from the entries.</h5>
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

    @stop

    @section('additional_bodytag')
    <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
    <script type="text/javascript" src="{{ asset('functions_js/parent_Teachers.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".dp_custom").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: false, // Displays dropdown below the button
            });
            $('select').material_select();
            $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            $('.modal-trigger').click(function(e){
                //get the clicked on link
                var $link = $(e.target);

                //get the data-target of that link
                var id =$link.data('id');
                var name = $link.data('name');

                    $('#delete_teacher_modal .teacher_name').html(name);
                    $('#delete_teacher_modal .btn_yes_delete').attr('onClick','showRemoveChildFrmStudent('+id+')');

                //open the modal
                var $modal = $($link.attr('href'));
                $modal.openModal();
            });
        });
    </script>
    @stop