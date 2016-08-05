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
                            <form id="form_child_add" class="row form_child_add">
                                <div class="input-field col s12 m4">
                                    <input id="f_name" type="text" name="first_name" class="validate" required="" aria-required="true">
                                    <label for="f_name">First Name</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="m_i" type="text" name="middle_name" class="validate" aria-required="true">
                                    <label for="m_i">Middle Name(Optional)</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="l_name" type="text" name="last_name" class="validate" required="" aria-required="true">
                                    <label for="l_name">Last Name</label>
                                </div>
                                <div class="input-field col s12 m12">
                                    <select class="icons select_school" name="school_id" aria-required="true" required="">
                                        <option value="" disabled selected>-- Choose a School --</option>
                                        @foreach($schools as $school)
                                        <option value="{{$school['id']}}"> {{$school['school_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select required="" aria-required="true" name="grade_id" id="grade_id">
                                        <option value="0" disabled selected>-- Choose a Grade --</option>
                                        @foreach($grades as $g)
                                            <option value="{{$g['id']}}">{{$g['description']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="section" type="text" name="section" class="validate">
                                    <label for="section">Section</label><br/><br/>
                                </div>


                                <div class="input-field col s12 m6">
                                    <input id="birthdate" type="text" name="birthdate" class="validate" required="" aria-required="true" data-inputmask='"mask": "yyy-mm-dd"' data-mask value="">
                                    <label for="birthdate">Birthdate</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <select class="select_gender" required="" aria-required="true" name="gender">
                                      <option value="" disabled selected>-- Choose a Gender --</option>
                                      <option value="Male">Male</option>
                                      <option value="Female">Female</option>
                                    </select>

                                </div>


                                <!-- <div class="input-field col s12 m6">
                                    <select class="icons select_state" required="required" aria-required="true" name="state_id">
                                        <option value="" disabled selected>-- Choose a State --</option>
                                        @foreach($state_us as $su)
                                            <option value="{{$su['id']}}">{{$su['state_name']}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="city" type="text" class="validate" aria-required="true" name="city">
                                    <label for="city">City/Town</label>
                                </div> -->
                                <div class="input-field col s12 m3">
                                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add <i class="material-icons right">add</i></button>
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
        <script src="{{asset('teachatv3/parents/children.js')}}"></script>

        <script type="text/javascript">

            // $(document).ready(function() {
            //     $('#form_child_add').submit(function(e){
            //         e.preventDefault();
            //         ajaxCall('POST', '/parent/child/store', getFormInputs(this.id), false, 'card', 'form_child_add');
            //     });
            // });

            $(document).ready(function() {

                $('.select_grades').select({
                    placeholder: "Choose a Grade",
                    allowClear: false
                });

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
