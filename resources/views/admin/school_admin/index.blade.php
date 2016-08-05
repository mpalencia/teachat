@extends('layouts.master')

@section('page_title', 'Manage School Admins')

@section('body_content')
<div class="profile-content">
    <div class="row">
        <h4>Manage School Admins</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">
                        <div class="actions">
                            <a href="{{url('admin/school-admin/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add School">Add <i class="material-icons">playlist_add</i></a>
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <select id="school_admin_filter">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <table id="school_admin_table" class="responsive-table">
                        <thead>
                            <tr>
                                <!-- <th>School Logo</th> -->
                                <th>Name</th>
                                <th>School</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th style="visibility: hidden; width: 70px!important;" class="center">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="child_on_list" id="{{ $user['last_name'] }}" >
                                    <!-- <td>
                                        @if($user['school']['school_logo'] != null || $user['school']['school_logo'] != '' || $user['school']['school_logo'] != 'dp.png')
                                        <figure class="school_badge" style="background-image: url({{asset('images/school_badges/'.$user['school']['school_logo'])}}); width: 70px; height: 70px;"></figure>
                                        @else
                                         <figure class="school_badge" style="background-image: url({{asset('images/dp.png')}}); width: 70px;height: 70px;"></figure>
                                        @endif
                                    </td> -->
                                    <td>{{ $user['first_name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}</td>
                                    <td>{{ $user['school']['school_name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['country']['name'] }}</td>
                                    <td style="visibility:hidden;">{{$user['active']}}</td>
                                    <td><a href="{{url('admin/school-admin'). '/' . $user['id'] . '/edit'}}"><button class="btn blue"><i class="material-icons" style="color:#fff">edit</i></button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="delete_principal" class="modal delete_principal">
    <div class="modal-content">
        <center>
            <h5 class="file_name"></h5>
            <div class="divider"></div>
            <h5>Deleting Principal.</h5>
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

@stop

@section('custom-scripts')

<link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script type="text/javascript">
    function showConfirmDeleteModal(id){
        $('#delete_principal .btn_yes_delete').attr('id',id);
        $('#delete_principal').openModal();
    }

    $('.btn_yes_delete').on('click', function() {
    $.ajax({
        url: '/admin/school-admin/'+$(this).attr('id'),
        type: 'DELETE',
        success: function(data) {

           $('.delete_principal').closeModal();

           Materialize.toast("Succesfully deleted.", 3000,'green',function(){window.location.reload();})
        }
    });
});
    $('.switch_in').change(function(){
        var changeTo = $(this).is(':checked');
        var id = $(this).attr('id');
        var param = {
            upload: changeTo
        };

        $.ajax({
            url: '/admin/schools/updateUpload/'+id,
            data: param,
            type: 'PUT',
            success: function(data) {

               Materialize.toast("Succesfully updated.", 2000,'green',function(){window.location.reload();})
            }
        });
    });

    function errorToast(message){
        Materialize.toast(''+message+'', 5000, 'red');
    }

    function successToast(message){
        Materialize.toast(''+message+'', 5000, 'green');
    }

    var schools = $('#school_admin_table').DataTable({
        'processing': true,
        'order': [[ 1, "asc" ]],
    });

    $('#school_admin_filter').material_select();
    $('#school_admin_filter').on('change',function(){

        if(this.value == "") {
            schools.columns(4).search("").draw();
        }
        else {
            schools.columns(4).search(this.value).draw();
        }
    });
</script>
@stop
