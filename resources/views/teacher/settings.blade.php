@extends('layouts.master')

@section('page_title', 'Settings')

@section('body_content')
    <h4>My Account</h4>
        <span class="divider"></span>
        <div class="divider"></div>
        <div class="row">
            <form class="col s12" id="form_settings">
                <div class="row">
                    <div class="input-field col s6">
                        <i class="fa fa-graduation-cap prefix"></i>
                        @foreach($schools as $sc)
                        <input id="icon_prefix" type="text" disabled="" value="{{ $sc['school_name'] }}">
                        <label for="icon_prefix"></label>
                        @endforeach
                    </div>

                    <div class="input-field col s6">
                        <i class="fa fa-envelope prefix"></i>
                        <input id="icon_prefix" type="text" disabled="" value="{{ Auth::user()->email }}">
                        <label for="icon_prefix"></label>
                    </div>

                </div>

                <div class="row">
                    <div class="input-field col s4 m3">
                        <select required="" aria-required="true" id="name_prefix" name="title">
                            <option value="Mr" {{ $user->title == 'Mr' ? 'selected' : ''}}> Mr. </option>
                            <option value="Ms" {{ $user->title == 'Ms' ? 'selected' : ''}}> Ms.</option>
                            <option value="Mrs" {{ $user->title == 'Mrs' ? 'selected' : ''}}> Mrs.</option>
                            <label>Select</label>
                        </select>
                    </div>

                    <div class="input-field col s12 m3">
                      <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name" value="{{ Auth::user()->first_name }}">
                      <label for="f_name">First Name</label>
                    </div>

                    <div class="input-field col s12 m3">
                        <input id="m_i" type="text" name="middle_name" class="validate" aria-required="true" value="{{ Auth::user()->middle_name }}">
                        <label for="m_i">Middle Name</label>
                    </div>

                    <div class="input-field col s12 m3">
                      <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name" value="{{ Auth::user()->last_name }}">
                      <label for="l_name">Last Name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m12">
                        <input id="address_one" type="text" name="address_one" value="{{ Auth::user()->address_one }}">
                        <label for="address_one">Address 1</label>
                    </div>
                </div>  

                <div class="row">
                    <div class="input-field col s12 m12">
                        <input id="address_two" type="text" name="address_two" value="{{ Auth::user()->address_two }}">
                         <label for="address_two">Address 2</label>
                    </div>
                </div>

                <div class="row">
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
                        <select id="state_id" required="required" aria-required="true" name="state_id">
                            <option value="" disabled selected>Select State/Province</option>
                            @foreach($state_us as $state)
                            <option value="{{$state['id']}}" <?php if ($user->state_id == $state['id']): ?> selected <?php endif;?>> {{$state['state_name']}}</option>
                            @endforeach
                        </select>
                        <label>Choose State/Province</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m6">
                            <input id="zip_code" type="text" class="validate" name="zip_code" value="{{ Auth::user()->zip_code }}">
                            <label for="zip_code">Zip Code</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="city" type="text" class="validate" required="required" aria-required="true" name="city" value="{{ Auth::user()->city }}">
                        <label for="city">City/Town</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m4">
                        <input id="contact_cell" type="text" required="" aria-required="true" name="contact_cell" value="{{ Auth::user()->contact_cell }}">
                        <label for="contact_cell">Contact Number</label>
                    </div>

                    <div class="input-field col s12 m4">
                        <input id="c_home" type="text" name="contact_home" class="validate" value="{{ Auth::user()->contact_home }}">
                        <label for="c_home">Contact Number (Home)</label>
                    </div>

                    <div class="input-field col s12 m4">
                        <input id="c_work" type="text" name="contact_work" class="validate" value="{{ Auth::user()->contact_work }}">
                        <label for="c_work">Contact Number (Work)</label>
                    </div>

                </div>

                <div class="row">
                    <div class="input-field col s12 m12">
                        <p>
                            <input type="checkbox" class="filled-in" id="email_notification" name="email_notification" {{ (Auth::user()->email_notification == 1) ? 'checked' : '' }} />
                            <label for="email_notification">Send me email notifications when offline</label>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m4">
                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Save</button>
                    </div>
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
                                    <label for="confirm_password">Confirm New Password</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Save</button>
                                </div>
                                <div class="div_notif notif"></div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        <div class="divider"></div><br/>
    </div>
@stop

@section('custom-scripts')
    <script src="{{ asset('teachatv3/teachers/myaccount.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('select').material_select();
        });

    </script>

    @include('teacher.floox-script')
    
@stop
