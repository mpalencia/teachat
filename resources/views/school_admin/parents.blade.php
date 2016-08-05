@extends('layouts.master')

@section('page_title', 'Students Approval')

@section('body_content')
<div class="row">
    <h4>Parents List</h4>
    <span class="divider"></span>
    <div class="divider"></div><br/>
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">
                <div class="table-header blue-grey lighten-5">Parents Profile
                    <div class="actions">
                        <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                    </div>
                </div>
                <div class="ddiv_notif notif"></div>
                <!-- <table class="table table-bordered table-hover" id="parents"></table> -->

                <table class="table table-bordered table-hover" id="parents">
                     <thead>
                        <tr>
                            <th style="width: 100px!important;"></th>
                            <th>Name</th>
                            <th class="center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parents as $p)
                            <tr class="principal_list">
                                <td>
                                    @if($p['profile_img'] != null || $p['profile_img'] != '')
                                    <figure class="school_badge" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $p['profile_img'] }}'); width: 70px; height: 70px;"></figure>
                                    @else
                                     <figure class="school_badge" style="background-image: url({{asset('images/dp.png')}}); width: 70px;height: 70px;"></figure>
                                    @endif
                                </td>
                                <td><a href="#" style="color:#3174c7" onclick="viewParent({{$p->id}})">{{$p->first_name}} {{$p->last_name}}</a></td>
                                <td>
                                    <a href="/school-admin/parents/{{$p->id}}" class="btn waves-effect blue white-text">View Child <i class="material-icons">search</i></a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

<div id="approve-parents" class="modal">
    <div class="modal-content">
        <h5>Approve Parent</h5>
        Do you want to approve <span id="parent_to_approve"></span>?
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-approve-yes-parents">Yes</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
    </div>
</div>

<div id="deny-parents" class="modal">
    <div class="modal-content">
        <h5>Deny Parent</h5>
        Do you want to deny <span id="parent_to_deny"></span>?
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-deny-yes-parents">Yes</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
    </div>
</div>


@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/school-admin/parents.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>
<script type="text/javascript">
    var students = $('#parents').DataTable({
        'processing': true,
        'order': [[ 0, "asc" ]],
    });
</script>
@stop
