@extends('layouts.master')

@section('page_title', 'Add Child')

@section('body_content')
					<div class="profile-content">
                        <div class="row">
                            <h4>Add Child</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                        </div>
                        <div class="div_notif notif"></div>
                        <div class="row">
                            <form id="form_child_add" accept-charset="utf-8" class="row" method="POST">
                                <div class="input-field col s12 m5">
                                    <input id="f_name" type="text" name="first_name" class="validate" required="" aria-required="true">
                                    <label for="f_name">First Name</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="m_i" type="text" name="middle_name" class="validate">
                                    <label for="m_i">Middle Initial</label>
                                </div>
                                <div class="input-field col s12 m5">
                                    <input id="l_name" type="text" name="last_name" class="validate" required="" aria-required="true">
                                    <label for="l_name">Last Name</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="section" type="text" name="section" class="validate">
                                    <label for="section">Section</label><br/><br/>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select required="" aria-required="true" name="grade_id">
                                      <option value="" disabled selected>-- Choose a Grade --</option>
                                      @foreach($grades as $grade)
                                      <option value="{{$grade['id']}}">{{$grade['description']}}</option>
                                      @endforeach
                                    </select>
                                    <label for="birthdate">Grade</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input id="birthdate" type="text" name="birthdate" class="validate" required="" aria-required="true" data-inputmask='"mask": "yyy-mm-dd"' data-mask value="">
                                    <label for="birthdate">Birthdate</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <select required="" aria-required="true" name="gender">
                                      <option value="" disabled selected>-- Choose Gender --</option>
                                      <option value="Male">Male</option>
                                      <option value="Female">Female</option>
                                    </select>
                                    <label for="birthdate">Gender</label>
                                </div>


                                <div class="input-field col s12 m6">
                                    <select class="icons" required="required" aria-required="true" name="state_id">
                                        <option value="" disabled selected>Select State</option>
                                        @foreach($state_us as $su)
                                            <option value="{{$su['id']}}">{{$su['state_name']}}</option>
                                        @endforeach
                                    </select>
                                    <label>Choose State</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select required="required" aria-required="true" id="reg_select_country" name="city">
                                      <option value="" disabled selected>Select City</option>
                                      <option value="Cresskill">Cresskill</option>
                                      <option value="Dumont">Dumont</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 m3">
                                    <button class="btn waves-effect btn-large btn-block waves-light">Add <i class="material-icons right">add</i></button>
                                </div>
                                <div class="input-field col s12 m3">
                                    <a href="/parent/child" class="btn waves-effect btn-large btn-block waves-light red" type="submit">Cancel</a>
                                </div>
                            </form>
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
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });

            $(function () {
                $("#birthdate").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
            });
        </script>

@stop
