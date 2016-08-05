@extends('layouts.master')

@section('page_title', 'Edit Child')

@section('body_content')

					<div class="profile-content">
                        <div class="row">
                        	@if($errors->any())
								<div class="alert alert-info">{{$errors->first()}}</div>
							@endif
                            <h4>Edit Child</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                        </div>
                            <div class="div_notif notif"></div>
                            <div class="row">
                                <form id="form_child_edit" class="row">
	                                <input type="hidden" id="child_id" value="{{$child->id}}" disabled="" required="" aria-required="true">
	                                <div class="input-field col s12 m4">
	                                    <input id="f_name" type="text" value="{{$child->first_name}}" name="first_name" class="validate" required="" aria-required="true">
	                                    <label for="f_name">First Name</label>
	                                </div>
	                                <div class="input-field col s12 m4">
	                                    <input id="m_i" type="text" value="{{$child->middle_name}}" name="middle_name" class="validate">
	                                    <label for="m_i">Middle Name(Optional)</label>
	                                </div>
	                                <div class="input-field col s12 m4">
	                                    <input id="l_name" type="text" value="{{$child->last_name}}" name="last_name" class="validate" required="" aria-required="true">
	                                    <label for="l_name">Last Name</label>
	                                </div>
	                                <div class="input-field col s12 m12">
                                    <select class="icons select_school" name="school_id" aria-required="true" required="">
                                        <option value="" disabled selected>-- Choose a School --</option>
                                        @foreach($schools as $school)
                                        <option value="{{$school['id']}}" <?php if ($child->school_id == $school['id']): ?> selected <?php endif;?>> {{$school['school_name']}}</option>
                                        @endforeach
                                    </select>
                                	</div>
                                	<div class="input-field col s12 m6">
	                                    <select required="" aria-required="true" id="grade_id" name="grade_id">
	                                      <option value="" disabled selected>-- Choose a Grade --</option>
	                                      @foreach($grades as $grade)
	                                      <option value="{{$grade['id']}}" <?php if ($child->grade_id == $grade['id']): ?> selected <?php endif;?>> {{$grade['description']}}</option>
	                                      @endforeach
	                                    </select>
	                                    <label for="birthdate">Grade</label>
	                                </div>
	                                <div class="input-field col s12 m6">
	                                    <input id="section" type="text" value="{{$child->section}}" name="section" class="validate">
	                                    <label for="section">Section</label><br/><br/>
	                                </div>
	                                

	                                <div class="input-field col s12 m6">
	                                    <input id="birthdate" type="text" value="{{$child->birthdate}}" name="birthdate" class="validate" required="" aria-required="true" data-inputmask='"mask": "yyy-mm-dd"' data-mask>
	                                    <label for="birthdate">Birthdate</label>
	                                </div>

	                                <div class="input-field col s12 m6">
	                                    <select required="" aria-required="true" name="gender">
	                                      <option value="" disabled selected>-- Choose Gender --</option>
	                                      <option value="Male" <?php if ($child->gender == "Male"): ?> selected <?php endif;?>>Male</option>
	                                      <option value="Female" <?php if ($child->gender == "Female"): ?> selected <?php endif;?>>Female</option>
	                                    </select>
	                                    <label for="birthdate">Gender</label>
	                                </div>


	                                <!-- <div class="input-field col s12 m6">
	                                    <select class="icons" required="required" aria-required="true" name="state_id">
	                                        <option value="" disabled selected>Select State</option>
	                                        @foreach($state_us as $su)
	                                            <option value="{{$su['id']}}" <?php if ($child->state_id == $su['id']): ?> selected <?php endif;?>>{{$su['state_name']}}</option>
	                                        @endforeach
	                                    </select>
	                                    <label>Choose State</label>
	                                </div>
	                                <div class="input-field col s12 m6">
	                                	<input id="city" type="text" class="validate" aria-required="true" value="{{$child->city}}" name="city">
                                    	<label for="city">City/Town</label>

	                                </div> -->
	                                
	                                <div class="input-field col s12 m3">
	                                    <button class="btn waves-effect btn-large btn-block waves-light">Update <i class="material-icons right">edit</i></button>
	                                </div>
	                                <div class="input-field col s12 m3">
	                                    <a href="{{url('parent/child')}}" class="btn waves-effect btn-large btn-block waves-light red" type="submit">Cancel</a>
	                                </div>
	                            </form>
                            </div>
                        </div>
                    </div>

@stop

@section('custom-scripts')

		<script src="{{ asset('input_mask/jquery.inputmask.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('input_mask/jquery.inputmask.date.extensions.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('input_mask/jquery.inputmask.extensions.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('teachatv3/parents/children.js')}}"></script>
        <script type="text/javascript">

            $(document).ready(function() {
                $('#child_grade').val('{{ $child[0]["child_grade"] }}');

                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });

            $(function () {
                $("#birthdate").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
            });

            function changeSchool(school) {
                $.get('/parent/children/grades/'+school.value, function(data){
                	var model = $('#grade_id');
                        model.empty();
                        model.append("<option disabled selected>-- Choose a Grade --</option>");

                    if(data.result) {
                        var output = [];

                        $.each(data.message, function(key, value){

                                model.append("<option value='"+ value.id +"'>" + value.description + "</option>");

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
