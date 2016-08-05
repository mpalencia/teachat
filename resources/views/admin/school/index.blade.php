@extends('layouts.master')

@section('page_title', 'Manage Schools')

@section('body_content')

<div class="profile-content">
    <div class="row">
        <h4>Manage Schools</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">
                        <div class="actions">
                            <a href="{{url('admin/schools/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add School">Add</a>
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <select id="school_filter">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <table id="schools" class="responsive-table">
                        <thead>
                            <tr>
                                <th style="width: 100px!important;">Logo</th>
                                <th>School</th>
                                <th>Country</th>
                                <th style="width: 130px!important;">State/Province</th>
                                <th style="width: 70px!important;" class="center">Upload</th>
                                <th style="visibility: hidden; width: 70px!important;" class="center">Status</th>
                                <th class="center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                                <tr class="principal_list">
                                    <td>
                                        @if($school['school_logo'] != null || $school['school_logo'] != '')
                                        <figure class="school_badge" style="background-image: url({{asset('images/school_badges/'.$school['school_logo'])}}); width: 70px; height: 70px;"></figure>
                                        @else
                                        <figure class="school_badge" style="background-image: url({{asset('images/dp.png')}}); width: 70px;height: 70px;"></figure>
                                        @endif
                                    </td>
                                    <td>{{ $school['school_name'] }}</td>
                                    <td>{{ $school['country']['name'] }}</td>
                                    <td>{{ $school['state']['state_name'] }}</td>
                                    <td>
                                        <!-- Switch -->
                                        <div class="switch">
                                            <label style="padding: 0 !important;">
                                                @if($school['upload'] == 1)
                                                    <input type="checkbox" class="switch_in" id="{{ $school['id'] }}" checked>
                                                @else
                                                     <input type="checkbox" class="switch_in" id="{{ $school['id'] }}">
                                                @endif
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td style="visibility:hidden;">{{$school['active']}}</td>
                                    <td>
                                        <a href="{{ url('admin/schools'). '/' . $school['id'] . '/edit' }}" class="btn waves-effect deep-orange"><i class="material-icons  white-text">edit</i></a>
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
            <h5>Deleting School.</h5>
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
        $('#delete_school .btn_yes_delete').attr('id',id);
        $('#delete_school').openModal();
    }

    $('.btn_yes_delete').on('click', function() {
    $.ajax({
        url: '/admin/schools/'+$(this).attr('id'),
        type: 'DELETE',
        success: function(data) {

           $('.delete_school').closeModal();

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

    var schools = $('#schools').DataTable({
        'processing': true,
        'order': [[ 1, "asc" ]],
    });
    $('#school_filter').material_select();
    $('#school_filter').on('change',function(){

        if(this.value == "") {
            schools.columns(5).search("").draw();
        }
        else {
            schools.columns(5).search( this.value ).draw();
        }
    });
</script>
@stop
