@extends('layouts.master')

@section('page_title', 'Manage Teachers')

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
                        <div class="actions">
                            <a href="{{url('admin/teachers/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Teacher">Add</a>
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <select id="teacher_filter">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <table id="teachers" class="responsive-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>School</th>
                                <th>State/Province</th>
                                <th>
                                 <input type="checkbox" class="filled-in" id="filled-in-box" checked/>
                                      <label for="filled-in-box">Active</label>
                                </th>
                                <th>
                                 <input type="checkbox" class="filled-in" id="filled-in-box2" checked/>
                                      <label for="filled-in-box2">Suspend</label>
                                </th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                <tr class="principal_list">
                                    <td>{{ $teacher['first_name'] }} {{ $teacher['last_name'] }}</td>
                                    <td>{{ $teacher['school']['school_name'] }}</td>
                                    <td>{{ $teacher['state']['state_name'] }}</td>
                                    <td>
                                        <!-- Active Switch -->
                                        <div class="switch divactive hide">
                                            <label style="padding: 0 !important;">
                                                @if($teacher['active'] == 1)
                                                    <input type="checkbox" class="switch_in_active" id="{{ $teacher['id'] }}" checked>
                                                @else
                                                     <input type="checkbox" class="switch_in_active" id="{{ $teacher['id'] }}">
                                                @endif
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Suspend Switch -->
                                        <div class="switch suspendactive hide">
                                            <label style="padding: 0 !important;">
                                                @if($teacher['suspend'] == 1)
                                                    <input type="checkbox" class="switch_in_suspend" id="{{ $teacher['id'] }}" checked>
                                                @else
                                                     <input type="checkbox" class="switch_in_suspend" id="{{ $teacher['id'] }}">
                                                @endif
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#!" onClick="viewTeacher({{ $teacher['id'] }});" class="btn waves-effect blue"><i class="material-icons  white-text">search</i></a>
                                        <a href="{{ url('admin/teachers'). '/' . $teacher['id'] . '/edit' }}" class="btn waves-effect deep-orange"><i class="material-icons  white-text">edit</i></a>
                                        <a href="#!" class="btn" onClick="showConfirmDeleteModal({{ $teacher['id'] }});"><i class="material-icons white-text">delete</i></a>
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
<div id="delete_school" class="modal delete_school">
    <div class="modal-content">
        <center>
            <h5 class="file_name"></h5>
            <div class="divider"></div>
            <h5>Deleting Teacher.</h5>
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
<div id="view-teachers" class="modal">
    <div class="modal-content">
        <h5>Teacher Information</h5>
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
@stop

@section('custom-scripts')

<link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script type="text/javascript">
    function showConfirmDeleteModal(id){
        $('#delete_school .btn_yes_delete').attr('id',id);
        $('#delete_school').openModal();
    }

    $('.btn_yes_delete').on('click', function() {
        $.ajax({
            url: '/admin/teachers/'+$(this).attr('id'),
            type: 'DELETE',
            success: function(data) {
               $('.delete_school').closeModal();
               Materialize.toast("Succesfully deleted.", 3000,'green',function(){window.location.reload();})
            }
        });
    });

    $('.switch_in_active').change(function(){
        var changeTo = $(this).is(':checked');

        if(changeTo == true){
            changeTo = 1;
        }

        else {
            changeTo = 0;
        }
        var id = $(this).attr('id');
        var param = {
            active: changeTo,
        };

        $.ajax({
            url: '/admin/update/'+id,
            data: param,
            type: 'PUT',
            success: function(data) {

               Materialize.toast("Succesfully updated.", 2000,'green',function(){})
            }
        });
    });

    $('.switch_in_suspend').change(function(){
        var changeTo = $(this).is(':checked');

        if(changeTo == true){
            changeTo = 1;
        }

        else {
            changeTo = 0;
        }
        var id = $(this).attr('id');
        var param = {
            suspend: changeTo,
        };

        $.ajax({
            url: '/admin/update/'+id,
            data: param,
            type: 'PUT',
            success: function(data) {

               Materialize.toast("Succesfully updated.", 2000,'green',function(){})
            }
        });
    });

    function errorToast(message){
        Materialize.toast(''+message+'', 5000, 'red');
    }

    function successToast(message){
        Materialize.toast(''+message+'', 5000, 'green');
    }

    function viewTeacher(id) {
        $('#view-teachers').openModal();

        $.get('teachers/get/'+id, function(result){

            $('#teacher_name').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
            $('#teacher_email').html(result.data.email);
            $('#teacher_gender').html(result.data.gender);
            $('#teacher_address_one').html(result.data.email);
            $('#teacher_address_two').html(result.data.gender);
            $('#teacher_state').html(result.data.state.state_name);
            $('#teacher_city').html(result.data.city);
            $('#teacher_zip_code').html(result.data.zip_code);
            $('#teacher_contact_mobile').html(result.data.contact_cell);
            $('#teacher_contact_home').html(result.data.contact_home);
            $('#teacher_contact_work').html(result.data.contact_work);
        });
    }

    var teachers = $('#teachers').DataTable({
        'processing': true,
        'order': [[ 1, "asc" ]],
    });
    $('#teacher_filter').material_select();
    $('#teacher_filter').on('change',function(){

        if(this.value == "") {
            teachers.columns(5).search("").draw();
        }
        else {
            teachers.columns(5).search( this.value ).draw();
        }
    });

     $('#filled-in-box').change(function(){
        var changeTo = $(this).is(':checked');

        if(changeTo == true){
            changeTo = 1;
            $('.divactive').addClass("hide");
        }

        else {
            changeTo = 0;
            $('.divactive').removeClass("hide");
        }
    });

    $('#filled-in-box2').change(function(){
        var changeTo = $(this).is(':checked');

        if(changeTo == true){
            changeTo = 1;
            $('.suspendactive').addClass("hide");
        }

        else {
            changeTo = 0;
            $('.suspendactive').removeClass("hide");
        }
    });

</script>
@stop
