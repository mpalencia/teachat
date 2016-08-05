@extends('layouts.master')

@section('page_title', 'Students Approval')

@section('body_content')

<div class="row">
    <h4>Children List</h4>
    <span class="divider"></span>
    <div class="divider"></div><br/>
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">
                <div class="table-header blue-grey lighten-5">Children Profile
                    <div class="actions">
                        <a href="/school-admin/manage-parents" class="waves-effect btn-flat nopadding"><i class="material-icons">list</i> Parent List</a>
                    </div>
                </div>
                <div class="ddiv_notif notif"></div>
                <table class="table table-bordered table-hover" id="children"></table>

            </div>
        </div>
    </div>
</div>

<div id="view-students" class="modal">
    <div class="modal-content">
        <h5>Child Information</h5>
        <table class="responsive-table highlight bordered">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td><span id="student_name"></span></td>
                </tr>
                <tr>
                    <td><b>Gender</b></td>
                    <td><span id="student_gender"></span></td>
                </tr>
                <tr>
                    <td><b>Birthdate</b></td>
                    <td><span id="student_birthdate"></span></td>
                </tr>
                <tr>
                    <td><b>Grade</b></td>
                    <td><span id="student_grade_description"></span></td>
                </tr>
                <tr>
                    <td><b>Section</b></td>
                    <td><span id="student_section"></span></td>
                </tr>
                <tr>
                    <td><b>School</b></td>
                    <td><span id="student_state"></span></td>
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

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script type="text/javascript">
    var parent_id = "<?php echo $parent_id ?>";
</script>
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/school-admin/children.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

@stop