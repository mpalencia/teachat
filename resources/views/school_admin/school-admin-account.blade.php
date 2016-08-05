@extends('layouts.master')

@section('page_title', 'Appointments')

@section('body_content')

    <h4>My Account</h4>
        <span class="divider"></span>
        <div class="divider"></div>
        <div class="row">
            <form class="col s12" id="form_myaccount">
                <div class="input-field col s12 m12">
                    <i class="material-icons prefix">email</i>
                    <input id="icon_prefix" type="text" name="email" value="{{ Auth::user()->email }}">
                    <label for="icon_prefix">Email</label>
                </div>

                <div class="input-field col s12 m3">
                            <select required="" aria-required="true" id="name_prefix" name="title">
                                <option value="Mr" {{ $user->title == 'Mr' ? 'selected' : ''}}> Mr. </option>
                                <option value="Ms" {{ $user->title == 'Ms' ? 'selected' : ''}}> Ms.</option>
                                <option value="Mrs" {{ $user->title == 'Mrs' ? 'selected' : ''}}> Mrs.</option>
                                <label>Select</label>
                            </select>
                </div>

                <div class="input-field col s12 m3">
                    <input id="f_name" type="text" name="first_name" class="validate" required="" aria-required="true" value="{{ Auth::user()->first_name }}">
                    <label for="f_name">First Name</label>
                </div>

                <div class="input-field col s12 m3">
                    <input id="m_i" type="text" name="middle_name" class="validate" value="{{ Auth::user()->middle_name }}">
                    <label for="m_i">Middle Initial</label>
                </div>

                <div class="input-field col s12 m3">
                    <input id="l_name" type="text" name="last_name" class="validate" required="" aria-required="true" value="{{ Auth::user()->last_name }}">
                    <label for="l_name">Last Name</label>
                </div>

                <div class="input-field col s12 m12">
                    <input id="address_one" type="text" name="address_one" required="" value="{{ Auth::user()->address_one }}">
                    <label for="address_one">Address 1</label>
                </div>

                <div class="input-field col s12 m12">
                    <input id="address_two" type="text" name="address_two" value="{{ Auth::user()->address_two }}">
                     <label for="address_two">Address 2</label>
                </div>

                <div class="input-field col s12 m6">
                    <select id="country_id" required="required" aria-required="true" name="country_id" onchange="changeCountry(this)">
                        <option value="" disabled selected>Select Country</option>
                        @foreach($country as $c)
                        <option value="{{$c['id']}}" <?php if ($user->country_id == $c['id']): ?> selected <?php endif;?>> {{$c['name']}}</option>
                        @endforeach
                    </select>
                    <label>Choose Country</label>
                </div>

                <div class="input-field col s12 m6">
                    <select id="state_id" required="required" aria-required="true" name="state_id" class="validate">
                        <option value="" disabled selected>Select State/Province</option>
                        @foreach($state_us as $state)
                        <option value="{{$state['id']}}" <?php if ($user->state_id == $state['id']): ?> selected <?php endif;?>> {{$state['state_name']}}</option>
                        @endforeach
                    </select>
                    <label>Choose State/Province</label>
                </div>

                <div class="input-field col s12 m12">
                    <select id="school_id" class="icons select_school" name="school_id" aria-required="true" required="required" class="validate">
                        <option value="" disabled selected>-- Choose a School --</option>
                        @foreach($schools as $school)
                        <option value="{{$school['id']}}" <?php if ($user->school_id == $school['id']): ?> selected <?php endif;?>> {{$school['school_name']}}</option>
                        @endforeach
                        </select>
                </div>

                <div class="input-field col s12 m6">
                        <input id="zip_code" type="text" class="validate" name="zip_code" value="{{ Auth::user()->zip_code }}">
                        <label for="zip_code">Zip Code</label>
                </div>

                <div class="input-field col s12 m6">
                    <input id="city" type="text" class="validate" required="required" aria-required="true" name="city" value="{{ Auth::user()->city }}">
                    <label for="city">City/Town</label>
                </div>
                    
                                
                <div class="input-field col s12 m4">
                    <input id="c_cell" type="text" name="contact_cell" class="validate" required="" aria-required="true" value="{{ Auth::user()->contact_cell }}">
                    <label for="c_cell">Contact Number (Mobile)</label>
                </div>
                <div class="input-field col s12 m4">
                    <input id="c_home" type="text" name="contact_home" class="validate" value="{{ Auth::user()->contact_home }}">
                    <label for="c_home">Contact Number (Home)</label>
                </div>
                <div class="input-field col s12 m4">
                    <input id="c_work" type="text" name="contact_work" class="validate" value="{{ Auth::user()->contact_work }}">
                    <label for="c_work">Contact Number (Work)</label>
                </div>

                <div class="input-field col s12 m4">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit">SAVE</button>
                </div>
                <div class="div_notif notif"></div>
            </form>
        </div>
        <div class="divider"></div>
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><i class="material-icons">lock</i>Change Password</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <form class="col s12" id="frm_settings_changePassword">
                                <div class="input-field col s12">
                                    <input id="current_password" type="password" required="" aria-required="true" name="current_pass">
                                    <label for="current_password">Current Password</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="new_password" type="password" required="" aria-required="true" min="8" name="password">
                                    <label for="new_password">New Password</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="confirm_password" type="password" required="" aria-required="true" min="8" name="password_confirmation">
                                    <label for="confirm_password">Confirm Password</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Save</button>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        <div class="divider"></div><br/>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });

        $(document).ready(function() {
            $('#form_myaccount').submit(function(e){
                e.preventDefault();
                ajaxCall('POST', '/school-admin/settings/update', getFormInputs(this.id), false, 'card', 'form_myaccount');
            });
        });

        $(document).ready(function(){
            $('#frm_settings_changePassword').submit(function(e){
                e.preventDefault();
                ajaxCall('POST', '/school-admin/settings/changePassword', getFormInputs(this.id), false, 'card', 'frm_settings_changePassword', '', 'one');
                $('#frm_settings_changePassword')[0].reset();
            });
        });

        function changeCountry(country) {
                $.get('/school-admin/settings/country/'+country.value, function(data){
                    var model = $('#state_id');
                        model.empty();
                        model.append("<option disabled selected>Select State/Province</option>");

                    var models = $('#school_id');
                        models.empty();
                        models.append("<option disabled selected>Select School</option>");

                    if(data.result) {
                        var output = [];
                        
                        $.each(data.message, function(key, value){

                                model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

                        });
                        model.material_select();

                        $.each(data.message1, function(key, value){

                                models.append("<option value='"+ value.id +"'>" + value.school_name + "</option>");

                        });
                        models.material_select();
                                
                    }

                    else {
                        model.append("");
                        model.material_select();
                        Materialize.toast(data.message, 7000, "red");

                        models.append("");
                        models.material_select();
                        Materialize.toast(data.message1, 7000, "red");

                    }
                });
            }

    </script>

@stop