@extends('layouts.master')

@section('page_title', 'Settings')

@section('body_content')
    <h4>Settings</h4>
        <span class="divider"></span>
        <div class="divider"></div>
        <div class="row">
            <form class="col s12" id="form_settings_admin">
                <div class="row">

                    <div class="input-field col s12">
                        <i class="fa fa-envelope prefix"></i>
                        <input id="icon_prefix" type="text" disabled="" value="{{ Auth::user()->email }}">
                        <label for="icon_prefix"></label>
                    </div>

                </div>

                <div class="row">
                    <div class="input-field col s12">
                      <input id="email" type="text" class="validate" required="" aria-required="true" name="email" value="{{ Auth::user()->email }}">
                      <label for="email">Email</label>
                    </div>
                </div>

                <div class="input-field col s12 m4">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Save</button>
                </div>
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

@section('custom-scripts')
    <script src="{{ asset('teachatv3/admin/settings.js')}}"></script>
    <script type="text/javascript">

    </script>
@stop

@stop