@extends('includes.nav-school-admin')
@section('school-admin-content')
    <div class="row btn-thing">
        <h4>Teachers Approval</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">Teachers Profile
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <div class="ddiv_notif notif"></div>
                    <table class="table table-bordered table-hover" id="teachers"></table>
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

    <div id="approve-teachers" class="modal">
        <div class="modal-content">
        <h5>Approve Teacher</h5>
            Do you want to approve <span id="teacher_to_approve"></span>?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-approve-yes-teachers">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>

    <div id="deny-teachers" class="modal">
        <div class="modal-content">
            <h5>Deny Teacher</h5>
            Do you want to deny <span id="teacher_to_deny"></span>?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-deny-yes-teachers">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>

    <link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
    <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
    <script src="{{ asset('teachatv3/school-admin/teachers.js')}}"></script>
    <script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

@stop
