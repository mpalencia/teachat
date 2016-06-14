@extends('layouts.master')

@section('page_title', 'Edit Child')

@section('body_content')

					<div class="profile-content">
                        <div class="row">
                            <h4>Edit Child</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            </div>
                            <div class="row">
                                <form id="form_child_add" accept-charset="utf-8" class="row" method="POST">
	                                <div class="input-field col s12 m5">
	                                    <input id="f_name" type="text" value="{{$child->first_name}}" name="first_name" class="validate" required="" aria-required="true">
	                                    <label for="f_name">First Name</label>
	                                </div>
	                                <div class="input-field col s12 m2">
	                                    <input id="m_i" type="text" value="{{$child->middle_name}}" name="middle_name" class="validate">
	                                    <label for="m_i">Middle Initial</label>
	                                </div>
	                                <div class="input-field col s12 m5">
	                                    <input id="l_name" type="text" value="{{$child->last_name}}" name="last_name" class="validate" required="" aria-required="true">
	                                    <label for="l_name">Last Name</label>
	                                </div>
	                                <div class="input-field col s12 m6">
	                                    <input id="section" type="text" value="{{$child->section}}" name="section" class="validate">
	                                    <label for="section">Section</label><br/><br/>
	                                </div>
	                                <div class="input-field col s12 m6">
	                                    <select required="" aria-required="true" name="grade_id">
	                                      <option value="" disabled selected>-- Choose a Grade --</option>
	                                      @foreach($grades as $grade)
	                                      <option value="{{$grade['id']}}" <?php if ($child->grade_id == $grade['id']): ?> selected <?php endif;?>> {{$grade['description']}}</option>
	                                      @endforeach
	                                    </select>
	                                    <label for="birthdate">Grade</label>
	                                </div>



	                                <div class="input-field col s12 m5">
	                                    <input id="birthdate" type="text" value="{{$child->birthdate}}" name="last_name" class="validate" required="" aria-required="true" data-inputmask='"mask": "yyy-mm-dd"' data-mask>
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


	                                <div class="input-field col s12 m6">
	                                    <select class="icons" required="required" aria-required="true" name="state_id">
	                                        <option value="" disabled selected>Select State</option>
	                                        @foreach($state_us as $su)
	                                            <option value="{{$su['id']}}" <?php if ($child->state_id == $su['id']): ?> selected <?php endif;?>>{{$su['state_name']}}</option>
	                                        @endforeach
	                                    </select>
	                                    <label>Choose State</label>
	                                </div>
	                                <div class="input-field col s12 m6">
	                                    <select required="required" aria-required="true" id="reg_select_country" name="city">
	                                      <option value="" disabled selected>Select City</option>
	                                      <option value="Cresskill" <?php if ($child->city == "Cresskill"): ?> selected <?php endif;?>>Cresskill</option>
	                                      <option value="Dumont" <?php if ($child->city == "Dumont"): ?> selected <?php endif;?>>Dumont</option>
	                                    </select>
	                                </div>
	                                <div class="input-field col s12 m3">
	                                    <button class="btn waves-effect btn-large btn-block waves-light">Update <i class="material-icons right">Pencil</i></button>
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


                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });
            $(function () {
                $("#birthdate").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
            });
        </script>

@stop
