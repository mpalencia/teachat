@extends('layouts.master')

@section('page_title', 'Edit Teacher')

@section('body_content')

<div class="profile-content">
    <div class="row">
        <h4>Edit Teacher</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="div_notif"></div>
                    <form class="col s12 form_edit_teacher" id="form_edit_teacher">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="hidden" value="{{\Auth::user()->role_id}}" name="role_id" readonly="">
                                <input type="hidden" value="{{$teacher->id}}" name="user_id" readonly="">
                                <select id="country_id" class="icons" required="required" aria-required="true" name="country_id" onchange="changeCountry(this)">
                                    <option value="">Choose a Country</option>
                                    @foreach($country as $c)
                                        <option <?php if ($teacher->country_id == $c['id']): ?> selected="" <?php endif;?> value="{{$c['id']}}">{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-field col s12 m6">
                                <select id="state_id" class="icons" required="required" aria-required="true" name="state_id" onchange="changeState(this)">
                                    @foreach($states as $state)
                                    <option value="{{$state['id']}}" <?php if ($state['id'] == $teacher['state_id']): ?> selected <?php endif;?>>{{$state['state_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-field col s12 m6" id="select_school_id">

                                <select id="school_id" class="icons" aria-required="true" name="school_id">
                                    <option value="">Choose a School</option>
                                    @foreach($school as $s)
                                    <option <?php if ($teacher->school_id == $s['id']): ?> selected="" <?php endif;?> value="{{$s['id']}}">{{$s['school_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-field col s12 m6">
                                <select required="" id="select_gender" aria-required="true" name="gender">
                                    <option value="">Choose a Gender</option>
                                    <option value="Male" <?php if ($teacher->gender == "Male"): ?> selected="" <?php endif;?>>Male</option>
                                    <option value="Female" <?php if ($teacher->gender == "Female"): ?> selected="" <?php endif;?>>Female</option>
                                </select>
                            </div>
                            <div class="input-field col l4 m4 s6">
                                <input id="f_name" type="text" class="validate" value="{{$teacher->first_name}}" required="" aria-required="true" name="first_name">
                                <label for="f_name">First Name</label>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="m_name" type="text" name="middle_name" value="{{$teacher->middle_name}}" >
                                <label for="m_name">Middle Name (Optional)</label>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="l_name" type="text" class="validate" value="{{$teacher->last_name}}" required="" aria-required="true" name="last_name">
                                <label for="l_name">Last Name</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input type="text" id="address_one" name="address_one" value="{{$teacher->address_one}}"  class="validate" required="" aria-required="true">
                                <label for="address_one">Address 1</label>
                            </div>

                            <div class="input-field col s12 m12">
                                <input type="text" id="address_two" name="address_two" value="{{$teacher->addres_two}}" >
                                <label for="address_two">Address 2 (Optional)</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="zip_code" type="text" class="validate" name="zip_code" value="{{$teacher->zip_code}}">
                                <label for="zip_code">Zip Code</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="city" type="text" class="validate" required="required" aria-required="true" name="city" value="{{$teacher->city}}">
                                <label for="city">City/Town</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_cell" type="text" class="validate" required="" aria-required="true" name="contact_cell" value="{{$teacher->contact_cell}}">
                                <label for="contact_cell">Contact Mobile</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_home" type="text" name="contact_home" value="{{$teacher->contact_home}}">
                                <label for="contact_home">Contact Home (Optional)</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_work" type="text" name="contact_work" value="{{$teacher->contact_work}}">
                                <label for="contact_work">Contact Work (Optional)</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="email" type="email" class="validate" required="" aria-required="true" name="email" value="{{$teacher->email}}">
                                <label for="email" data-error="Invalid" data-success="Valid">Email</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select required="" id="select_active" aria-required="true" name="active">
                                    <option value="1" <?php if ($teacher->active == "1"): ?> selected="" <?php endif;?>>Active</option>
                                    <option value="0" <?php if ($teacher->active == "0"): ?> selected="" <?php endif;?>>Inactive</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m6">
                                <select required="" id="select_suspend" aria-required="true" name="suspend">
                                    <option value="1" <?php if ($teacher->suspend == "1"): ?> selected="" <?php endif;?>>Suspend</option>
                                    <option value="0" <?php if ($teacher->suspend == "0"): ?> selected="" <?php endif;?>>Unsuspend</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m12">

                            </div>
                            <div class="input-field col s12 m5 l6">
                                <button class="btn waves-effect btn-large btn-block waves-light" data-teacher-id="{{$teacher->id}}" type="submit">Update
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                            <div class="input-field col s12 m5 l6">
                                <a href="{{url('admin/teachers')}}">
                                    <button class="btn waves-effect btn-large red btn-block waves-light" type="button">Cancel</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom-scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
<script src="{{ asset('select/select2.full.min.js')}}"></script>
<script src="{{ asset('teachatv3/admin/teachers.js')}}"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('select').material_select();
});


function changeCountry(country) {
    $.get('/admin/states/'+country.value, function(data){
        var model = $('#state_id');
            $('#school_id').empty();
            $('#school_id').append("<option disabled selected>-- Choose a School --</option>");
            model.empty();
            model.append("<option disabled selected>-- Choose a State --</option>");

            var output = [];

            $.each(data.states, function(key, value){

                model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

            });
            model.material_select();
            $('#school_id').material_select();
    });
    }

    function changeState(state) {
    $.get('/admin/schools/'+state.value, function(data){
        var model = $('#school_id');
            model.empty();
            model.append("<option disabled selected>-- Choose a School --</option>");

            var output = [];

            $.each(data.schools, function(key, value){

                model.append("<option value='"+ value.id +"'>" + value.school_name + "</option>");

            });
            model.material_select();
    });
    }
</script>
@stop
