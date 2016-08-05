@extends('layouts.master')

@section('page_title', 'Students')

@section('body_content')
	<div class="row btn-thing">
        <h4>Manage Students</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Students
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <table class="responsive-table" id="students"></table>
                </div>
            </div>
        </div>
    </div>
    <div id="view-student" class="modal">
        <div class="modal-content">
            <ul class="collection with-header">
		        <li class="collection-header"><h5><span class="student_name"></span></h5></li>
		        <li class="collection-item"><div>Parent Name: <span class="secondary-content parent_name"></span></a></div></li>
		        <li class="collection-item"><div>Grade: <span class="secondary-content student_grade"></span></div></li>
		        <li class="collection-item"><div>Gender: <span class="secondary-content student_gender"></span></div></li>
		        <li class="collection-item"><div>State: <span class="secondary-content student_state"></span></a></div></li>
	      	</ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
        </div>
    </div>


@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/teachers/students.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>
<script type="text/javascript">
	function viewStudent(student) {
		$('#view-student').openModal();
		$('.student_name').html($(student).attr('data-child-name'));
		$('.parent_name').html($(student).attr('data-parent-name'));
		$('.student_grade').html($(student).attr('data-grade'));
		$('.student_gender').html($(student).attr('data-gender'));
		$('.student_state').html($(student).attr('data-state'));
	}
</script>

@include('teacher.floox-script')

@stop
