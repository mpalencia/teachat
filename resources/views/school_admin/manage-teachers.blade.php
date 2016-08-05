@extends('layouts.master')

@section('page_title', 'Teachers')

@section('body_content')


<div class="profile-content">
        <div class="row">
            <h4>Manage Teachers</h4>
            <span class="divider"></span>
            <div class="divider"></div><br/>
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <div class="table-header blue-grey lighten-5">
                            Teachers List
                            <div class="actions">
                                <a href="{{url('school-admin/manage-teachers/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Teacher">Add <i class="material-icons">playlist_add</i></a>
                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                            </div>
                        </div>
                        <select id="teachers_filter">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <table id="teachers_table" class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>
                                     <input type="checkbox" class="filled-in" id="filled-in-box" checked/>
                                          <label for="filled-in-box">Active</label>
                                    </th>
                                    <th>
                                     <input type="checkbox" class="filled-in" id="filled-in-box2" checked/>
                                          <label for="filled-in-box2">Suspend</label>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher as $t)
                                    <tr class="child_on_list" id="{{ $t['last_name'] }}" >
                                        <td><a href="#" style="color:#3174c7" onclick="viewTeacher({{$t['id']}})">{{ $t['first_name'] }} {{ $t['middle_name'] }} {{ $t['last_name'] }}</a></td>
                                        <td>
                                            <!-- Active Switch -->
                                            <div class="switch divactive hide">
                                                <label style="padding: 0 !important;">
                                                    @if($t['active'] == 1)
                                                        <input type="checkbox" class="switch_in_active" id="{{ $t['id'] }}" checked>
                                                    @else
                                                         <input type="checkbox" class="switch_in_active" id="{{ $t['id'] }}">
                                                    @endif
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Suspend Switch -->
                                            <div class="switch suspendactive hide">
                                                <label style="padding: 0 !important;">
                                                    
                                                    @if($t['suspend'] == 1)
                                                        <input type="checkbox" class="switch_in_suspend" id="{{ $t['id'] }}" checked>
                                                    @else
                                                         <input type="checkbox" class="switch_in_suspend" id="{{ $t['id'] }}">
                                                    @endif
                                                    
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="/school-admin/manage-teachers/{{$t['id']}}/edit" class="btn"><i class="material-icons">edit</i></a>
                                            <a href="#delete_teacher_modal" onclick="deleteTeacher(this)" data-teacher-id="{{$t['id']}}" data-name="{{ $t['first_name'] }} {{ $t['middle_name'] }} {{ $t['last_name'] }}" class="btn red"><i class="material-icons">delete</i></a>
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


<div id="view-teachers" class="modal">
    <div class="modal-content">
        <h5>View Teacher</h5>
        <table class="responsive-table highlight bordered">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td><span id="teacher_name"></span></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><span id="teacher_email"></span></td>
                </tr>
                <tr>
                    <td><b>Gender</b></td>
                    <td><span id="teacher_gender"></span></td>
                </tr>
                <tr>
                    <td><b>Address 1</b></td>
                    <td><span id="teacher_address_one"></span></td>
                </tr>
                <tr>
                    <td><b>Address 2</b></td>
                    <td><span id="teacher_address_two"></span></td>
                </tr>
                <tr>
                    <td><b>State</b></td>
                    <td><span id="teacher_state"></span></td>
                </tr>
                <tr>
                    <td><b>City</b></td>
                    <td><span id="teacher_city"></span></td>
                </tr>
                <tr>
                    <td><b>Zip Code</b></td>
                    <td><span id="teacher_zip_code"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Mobile</b></td>
                    <td><span id="teacher_contact_mobile"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Home</b></td>
                    <td><span id="teacher_contact_home"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Work</b></td>
                    <td><span id="teacher_contact_work"></span></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>

    <!-- Delete -->
    <div id="delete_teacher_modal" class="modal delete_teacher_modal">
        <div class="modal-content">
            <center>
                <h5 class="teacher_name" id="teacher_n">Name of Child here.</h5>
                <div class="divider"></div>
                <h5>Will be deleted from the entries.</h5>
                <h5>Are you sure?</h5>
            </center>
            <div class="row">
                <div class="input-field col s12 m4 offset-m2">
                    <a href="javascript:void(0);" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete">Yes <i class="material-icons right">check</i></a>
                </div>
                <div class="input-field col s12 m4">
                    <a href="" class= "btn waves-effect btn-large btn-block waves-light red modal-action modal-close">Cancel</a>
                </div>
            </div>
        </div>
    </div>

@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/school-admin/manage-teachers.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

@stop
