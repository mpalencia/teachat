@extends('layouts.master')

@section('page_title', 'Create Parent')

@section('body_content')

<div class="profile-content">
    <div class="row">
        <h4>Create Parent</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="div_notif"></div>
                    <form class="col s12 form_create_parent" id="form_create_parent">
                        <div class="row">
                            <input type="hidden" value="1" name="school_id" readonly="">
                            <input type="hidden" value="{{\Auth::user()->role_id}}" name="role_id">
                            <div class="input-field col l4 m4 s6">
                                <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name">
                                <label for="f_name">First Name</label>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="m_name" type="text" name="middle_name">
                                <label for="m_name">Middle Name (Optional)</label>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name">
                                <label for="l_name">Last Name</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input type="text" id="address_one" name="address_one" class="validate" required="" aria-required="true">
                                <label for="address_one">Address 1</label>
                            </div>

                            <div class="input-field col s12 m12">
                                <input type="text" id="address_two" name="address_two">
                                <label for="address_two">Address 2 (Optional)</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select id="country_id" class="icons" required="required" aria-required="true" name="country_id" onchange="changeCountry(this)">
                                    <option value="">Choose a Country</option>
                                    @foreach($country as $c)
                                        <option value="{{$c['id']}}">{{$c['name']}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="input-field col s12 m6">
                                <select id="state_id" class="icons" required="required" aria-required="true" name="state_id">

                                </select>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="zip_code" type="text" class="validate" name="zip_code">
                                <label for="zip_code">Zip Code</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="city" type="text" class="validate" required="required" aria-required="true" name="city">
                                <label for="city">City/Town</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_cell" type="text" class="validate" required="" aria-required="true" name="contact_cell">
                                <label for="contact_cell">Contact Mobile</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_home" type="text" name="contact_home">
                                <label for="contact_home">Contact Home (Optional)</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="contact_work" type="text" name="contact_work">
                                <label for="contact_work">Contact Work (Optional)</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select required="" id="select_gender" aria-required="true" name="gender">
                                    <option value="">Choose a Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="email" type="email" class="validate" required="" aria-required="true" name="email">
                                <label for="email" data-error="Invalid" data-success="Valid">Email</label>
                            </div>
                            <div class="input-field col s12 m12"></div>
                            <div class="input-field col s12 m5 l6">
                                <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Save
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                            <div class="input-field col s12 m5 l6">
                                <a href="{{url('admin/parents')}}">
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
<script src="{{ asset('teachatv3/admin/parents.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('select').material_select();
});


function changeCountry(country) {
    $.get('/admin/states/'+country.value, function(data){
        var model = $('#state_id');
            model.empty();
        $('option', '#state_id').remove();
        model.append("<option disabled selected>-- Choose a State --</option>");

        var output = [];

        $.each(data.states, function(key, value){
            model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");
        });
        model.material_select();
    });
}
</script>
@stop
