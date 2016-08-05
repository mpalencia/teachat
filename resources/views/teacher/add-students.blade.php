@extends('layouts.master')

@section('page_title', 'Add Students')

@section('custom-css')
<style type="text/css">
table.dataTable.select tbody tr,
table.dataTable thead th:first-child {
  cursor: pointer;
}

table.dataTable td.select-checkbox::before {
    margin-top: 0px;
}
</style>
@stop

@section('body_content')
    <div class="row btn-thing">
        <h4>{{$grade->description}} Students</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Students to Add in {{$curriculum->subject}}
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <div class="ddiv_notif notif"></div>
                    <table class="responsive-table display select" id="example"></table>

                </div>
            </div>
        </div>
    </div>
    <div id="edit-subjects" class="modal edit-subjects">
        <div class="modal-content">
            <h5>Edit Subject</h5>
            <div class="ediv_notif notif"></div>
            <form id="form_edit_subjects" accept-charset="utf-8" class="row form_edit_subjects" >
                <div class="input-field col s12 m12">
                    <input id="esubject_id" type="hidden" name="subject_id" class="validate" required="" aria-required="true">
                    <input id="esubject" type="text" name="description" class="validate" required="" aria-required="true">
                    <label for="subjects">Subject</label>
                </div>
                <div class="pull-right">
                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat freakin-modal">Close</a>
                    <button class="modal-action btn waves-effect waves-light btn-update-subjects">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-subjects" class="modal">
        <div class="modal-content">
            <h5>Delete Subject</h5>
            Do you want to delete this subject?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-subjects">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>
    <input id="curriculum_id" type="hidden" disabled="" value="{{$curriculum->id}}">
    <input id="grade_id" type="hidden" disabled="" value="{{$curriculum->grade_id}}">

@stop

@section('custom-scripts')
    <link href="{{asset('dataTable/select.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>

    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
    <!-- <script src="{{ asset('teachatv3/teachers/subjects.js')}}"></script> -->
    <script type="text/javascript">
    var nColNumber = -1;
    var students = $('#example').DataTable({
        'ajax': {
            'url': '/teacher/subjects/get-children/'+$('#curriculum_id').val()+'/'+$('#grade_id').val(),
            'dataSrc': function (json) {
                if(jQuery.isEmptyObject(json.data)) {
                    $('#testinglang').attr('disabled', 'disabled');
                }
                return json.data;
            },
        },
        'processing': true,
        'order': [],
        'columnDefs': [
            {
                'targets': [ ++nColNumber ], 'title':'<button id="testinglang" onclick="addAllStudentToSubject()" type="button" class="btn-floating green" title="Add all students to this subject." onclick="addAllStudentToSubject(this)"><i class="material-icons">group_add</i></button>', 'name': 'action', 'data': 'action',
                'ordering': false,
                'width': '10%'
            },
            { 'targets': [ ++nColNumber ], 'title':'Name', 'name': 'name', 'data': 'name' },
        ]
    });

    function addStudentToSubject(student) {
        var data = {
            'child_id' : $(student).attr('data-students-id'),
            'curriculum_id' : $(student).attr('data-curriculum-id'),
        };
        ajaxCall('POST', '/teacher/students', data , false, 'card', '', students);
    }

    function addAllStudentToSubject(student) {
        var data = {
            'curriculum_id' : $('#curriculum_id').val(),
        };
        ajaxCall('POST', '/teacher/students/storeAll/'+$('#grade_id').val()+'/'+$('#curriculum_id').val(), data , false, 'card', '', students);
    }

</script>

    @include('teacher.floox-script')
@stop
