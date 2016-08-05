@extends('layouts.master')

@section('page_title', 'Update Teacher')

@section('body_content')
<div class="row">
    <h4>Edit Teacher</h4>
    <span class="divider"></span>
    <div class="divider"></div><br/>
    <div class="row">
        <form class="col s12 form_update_teachers" id="form_update_teachers">
            <div class="row">
                <input type="hidden" name="role_id" value="4">
                <input type="hidden" id="teacher_id" value="{{$teacher['id']}}" disabled="" required="" aria-required="true">
                <input type="hidden" name="user_id" value="{{$teacher['id']}}" disabled="" required="" aria-required="true">
                <input type="hidden" name="country_id" value="{{$teacher['country_id']}}" disabled="" required="" aria-required="true">
                <input type="hidden" name="school_id" value="{{$teacher['school_id']}}" disabled="" required="" aria-required="true">
                <div class="input-field col s6">
                    @foreach($country as $c)
                        <input id="icon_prefix" type="text" disabled="" value="{{$c['name']}}">
                        <label for="icon_prefix">Country</label>
                    @endforeach
                </div>

                <div class="input-field col s6">
                    @foreach($school as $s)
                        <input id="icon_prefix" type="text" disabled="" value="{{$s['school_name']}}">
                        <label for="icon_prefix">School</label>
                    @endforeach
                </div>

                <div class="input-field col s12 m12">
                    <select required="" aria-required="true" name="gender">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male" {{ ($teacher['gender'] == 'Male') ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ ($teacher['gender'] == 'Female') ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="input-field col l4 m4 s12">
                    <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name" value="{{$teacher['first_name']}}">
                    <label for="f_name">First Name</label>
                </div>
                <div class="input-field col l4 m4 s12">
                    <input id="m_name" type="text" name="middle_name">
                    <label for="m_name">Middle Name (Optional)</label>
                </div>
                <div class="input-field col l4 m4 s12">
                    <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name" value="{{$teacher['last_name']}}">
                    <label for="l_name">Last Name</label>
                </div>
                <div class="input-field col s12 m12">
                    <input type="text" id="address_one" name="address_one" class="validate" required="" aria-required="true" value="{{$teacher['address_one']}}">
                    <label for="address_one">Address 1</label>
                </div>

                <div class="input-field col s12 m12">
                    <input type="text" id="address_two" name="address_two" value="{{$teacher['address_two']}}">
                    <label for="address_two">Address 2 (Optional)</label>
                </div>
              
                <div class="input-field col s12 m6">
                    <select id="state_id" class="icons" required="required" aria-required="true" name="state_id">
                        <option value="" disabled selected>Select State/Province</option>
                        @foreach($state_us as $state)
                        <option value="{{$state['id']}}" {{ ($teacher['state_id'] == $state['id']) ? 'selected' : '' }} >{{$state['state_name']}}</option>
                        @endforeach
                    </select>
                    <label>Choose State/Province</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="zip_code" type="text" class="validate" name="zip_code" value="{{$teacher['zip_code']}}">
                    <label for="zip_code">Zip Code</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12">
                    <input id="city" type="text" class="validate" required="required" aria-required="true" name="city" value="{{$teacher['city']}}">
                    <label for="city">City/Town</label>
                </div>
               
            </div>
            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="contact_cell" type="text" class="validate" required="" aria-required="true" name="contact_cell" value="{{$teacher['contact_cell']}}">
                    <label for="contact_cell">Contact Mobile</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="contact_home" type="text" name="contact_home" value="{{$teacher['contact_home']}}">
                    <label for="contact_home">Contact Home (Optional)</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="contact_work" type="text" name="contact_work" value="{{$teacher['contact_work']}}">
                    <label for="contact_work">Contact Work (Optional)</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="birthdate" type="date" required="" name="birthdate" class="datepicker" value="{{ date_format(date_create($teacher['birthdate']), 'd F, Y') }}">
                    <label for="birthdate">Birthdate</label>
                </div>
                <div class="input-field col s12 m12">
                    <input id="email" type="email" class="validate" required="" aria-required="true" name="email" value="{{$teacher['email']}}">
                    <label for="email" data-error="Invalid" data-success="Valid">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m5 l4">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit">SAVE</button>
                </div>
               
            </div>
            <div class="div_notif"></div>
        </form>
    </div>
</div>

@stop

@section('custom-scripts')
<script src="{{ asset('teachatv3/school-admin/manage-teachers.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

<script type="text/javascript">
        $(document).ready(function() {

            $('select').material_select();
            $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

        });

        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15 // Creates a dropdown of 15 years to control year
        });

    </script>

@stop
