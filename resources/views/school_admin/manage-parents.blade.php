@extends('layouts.master')

@section('page_title', 'Students Approval')

@section('body_content')
<div class="row">
    <h4>Manage Parents</h4>
    <span class="divider"></span>
    <div class="divider"></div><br/>
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">
                <div class="table-header blue-grey lighten-5">
                    Parents List
                    <div class="actions">
                        <a href="/school-admin/manage-parents/create" class="btn-flat nopadding waves-effect tooltipped" data-position="left" data-tooltip="Add Parent">ADD <i class="material-icons">playlist_add</i></a>
                        <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                    </div>
                </div>
                <div class="ddiv_notif notif"></div>
                <!-- <table class="table table-bordered table-hover" id="parents"></table> -->

                 <table class="responsive-table" id="manage-parents">
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
                            @foreach($parents as $p)
                                <tr class="principal_list">
                                    <td><a href="#" style="color:#3174c7" onclick="viewParent({{$p->id}})">{{$p->first_name}} {{$p->middle_name}} {{$p->last_name}}</a></td>
                                    <td>
                                        <!-- Active Switch -->
                                        <div class="switch divactive hide">
                                            <label style="padding: 0 !important;">
                                                @if($p->active == 1)
                                                    <input type="checkbox" class="switch_in_active" id="{{ $p['id'] }}" checked>
                                                @else
                                                     <input type="checkbox" class="switch_in_active" id="{{ $p['id'] }}">
                                                @endif
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Suspend Switch -->
                                        <div class="switch suspendactive hide">
                                            <label style="padding: 0 !important;">
                                                
                                                @if($p->suspend == 1)
                                                    <input type="checkbox" class="switch_in_suspend" id="{{ $p['id'] }}" checked>
                                                @else
                                                     <input type="checkbox" class="switch_in_suspend" id="{{ $p['id'] }}">
                                                @endif
                                                
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/school-admin/manage-parents/{{$p->id}}/edit" class="btn waves-effect primary white-text"><i class="material-icons">edit</i></a> 
                                        <a href="#" onclick="deleteParent({{$p->id}})" class="btn waves-effect red white-text"><i class="material-icons">delete</i></a>
                                        <a href="/school-admin/manage-parents/{{$p->id}}" class="btn waves-effect blue white-text">Child</a>
                                    </td>
                                </tr>   
                            @endforeach
                        </tbody>
                    </table>
                    @if(is_null($parents))
                        No Students to approve.
                    @endif
                @if(is_null($parents))
                	No Students to approve.
                @endif



            </div>
        </div>
    </div>
</div>

<div id="view-parents" class="modal">
    <div class="modal-content">
        <h5>View Parent</h5>
        <table class="responsive-table highlight bordered">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td><span id="parent_name"></span></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><span id="parent_email"></span></td>
                </tr>
                <tr>
                    <td><b>Gender</b></td>
                    <td><span id="parent_gender"></span></td>
                </tr>
                <tr>
                    <td><b>Address 1</b></td>
                    <td><span id="parent_address_one"></span></td>
                </tr>
                <tr>
                    <td><b>Address 2</b></td>
                    <td><span id="parent_address_two"></span></td>
                </tr>
                <tr>
                    <td><b>State</b></td>
                    <td><span id="parent_state"></span></td>
                </tr>
                <tr>
                    <td><b>City</b></td>
                    <td><span id="parent_city"></span></td>
                </tr>
                <tr>
                    <td><b>Zip Code</b></td>
                    <td><span id="parent_zip_code"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Mobile</b></td>
                    <td><span id="parent_contact_mobile"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Home</b></td>
                    <td><span id="parent_contact_home"></span></td>
                </tr>
                <tr>
                    <td><b>Contact Work</b></td>
                    <td><span id="parent_contact_work"></span></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>

<div id="delete-parent" class="modal">
    <div class="modal-content">
        <h5>Delete Parent</h5>
        Do you want to delete <span id="parent_to_delete"></span>?
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-parent">Yes</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
    </div>
</div>

@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/school-admin/manage-parents.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>
<script type="text/javascript">
    var students = $('#manage-parents').DataTable({
        'processing': true,
        'order': [[ 0, "asc" ]],
    });


</script>
@stop
