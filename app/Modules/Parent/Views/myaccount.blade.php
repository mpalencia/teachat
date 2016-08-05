
    @extends('theme')
        @section('title_tag')
            <title>Parent : My Account</title>
            <meta name="robots" content="noindex">
            <meta name="googlebot" content="noindex">
        @stop

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-parent')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        @include('Universal::profile_img')
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/parent/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/parent/child" class="waves-effect"><i class="material-icons">recent_actors</i>Child </a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/parent/teachers-list" class="waves-effect"><i class="material-icons">supervisor_account</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/parent/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages </a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/parent/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/parent/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/parent/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4>My Account</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <form class="col s12" id="frm_update_Account_parent">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">email</i>
                                        <input id="icon_prefix" type="text" disabled="" value="{{ $profile[0]['email'] }}">
                                        <label for="icon_prefix">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <input id="address_one" type="text" value="{{ $details[0]['address_one'] }}" name="address">
                                        <label for="address_one">Address 1</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <input id="address_two" type="text" value="{{ $details[0]['address_two'] }}" name="address">
                                        <label for="address_two">Address 2</label>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="input-field col s8 m5">
                                      <input id="f_name" type="text" class="validate" required="" name="first_name" aria-required="true" value="{{ $profile[0]['first_name'] }}">
                                      <label for="f_name">First Name</label>
                                    </div>
                                    <div class="input-field col s12 m5">
                                      <input id="l_name" type="text" class="validate" required="" name="last_name" aria-required="true" value="{{ $profile[0]['last_name'] }}">
                                      <label for="l_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m4">
                                        <input id="contact_cell" type="text" name="contact_cell" required="" aria-required="true" data-inputmask='"mask": "999-999-9999"' data-mask value="{{ $details[0]['contact_cell'] }}">
                                        <label for="contact_cell">Contact Number (Mobile)</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="contact_work" type="text" name="contact_work" value="{{ $details[0]['contact_work'] }}">
                                        <label for="contact_work">Contact Number (Work)</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="contact_home" type="text" name="contact_home" value="{{ $details[0]['contact_home'] }}">
                                        <label for="contact_home">Contact Number (Home)</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit" name="action">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <script src="{{ asset('input_mask/jquery.inputmask.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('input_mask/jquery.inputmask.date.extensions.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('input_mask/jquery.inputmask.extensions.js') }}"></script><!-- Input Mask -->
        <script src="{{ asset('functions_js/parent_myAccount.js') }}"></script>
        <script type="text/javascript">


            $(function () {
                //Money Euro
                $("[data-mask]").inputmask();
            });
        </script>
    @stop
