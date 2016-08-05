@extends('layouts.master')

@section('page_title', 'Add Teacher')

@section('body_content')

					<div class="profile-content">
                        <div class="row">
                            <h4>Add Teacher</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                        </div>
                        <div class="div_notif notif"></div>
                        <div class="row">
                            <form id="form_add_teacher" accept-charset="utf-8" class="row form_add_teacher" method="POST">
                                <input type="hidden" id="child_id" name="child_id" value="{{$child->id}}" disabled="" required="" aria-required="true">
                                <input type="hidden" id="school_id" name="school_id" value="{{$child->school_id}}" disabled="" required="" aria-required="true">
                                <div class="input-field col s12 m12">
                                    <select required="" class="select_subject" aria-required="true" name="subject_id" onchange="changeTeacherList(this)">
                                      <option value="" disabled selected>-- Choose a Subject --</option>
                                      @foreach($subjects as $subject)
                                      <option value="{{$subject->subject_id}}" data-subject-id="{{$subject->subject_id}}"> {{$subject->subject_desc}} - {{$subject->subject}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m12">
								    <select class="icons select_teacher" name="teacher_id" id="teacher_id" aria-required="true" required="">
                                    <option value="" disabled selected>-- Choose a Teacher --</option>

								   	</select>
							   	</div>
							   	<div class="input-field col s12 m12 l12">
		                            <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
		                                <i class="material-icons">person_add</i>
		                            </button>
		                        </div>
                            </form>

                        </div>
                    </div>


@stop

@section('custom-scripts')
<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
		<link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
		<script src="{{ asset('select/select2.full.min.js')}}"></script>
		<link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}"></link>
        <script src="{{ asset('teachatv3/parents/children.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });

            function changeTeacherList(subject) {
            	$.get('/parent/children/teachers/getAll/'+subject.value, function(data){

                    var model = $('#teacher_id');
                        model.empty();
                        model.append("<option disabled selected>-- Choose a Teacher --</option>");

            		if(data.result) {
            			var output = [];

            			$.each(data.message, function(key, value){

                                model.append("<option value='"+ value.teacher.id +"'>" + value.teacher.first_name + " " + value.teacher.last_name + "</option>");

            			});
						model.material_select();
            		}

            		else {
            			model.append("");
                        model.material_select();
                        Materialize.toast(data.message, 7000, "red");
            		}
	           	});
            }
        </script>
        
@include('parent.floox-script')

@stop
