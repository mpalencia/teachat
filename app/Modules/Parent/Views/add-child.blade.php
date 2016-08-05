
    @extends('theme')
        @section('title_tag')
            <title>Parent : Add Child</title>
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
                                <li class="nav_tab" id="overview">
                                    <a href="/parent/myaccount" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="active nav_tab" id="child">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">recent_actors</i>Child </a>
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
                            <h4>Add Child</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            </div>
                            <div class="row">
                                <form id="frm_addChild_parent" accept-charset="utf-8" class="row">
                                    <div class="input-field col s12 m5">
                                        <input id="f_name" type="text" name="child_fname" class="validate" required="" aria-required="true">
                                        <label for="f_name">First Name</label>
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <input id="m_i" type="text" name="child_mi" class="validate">
                                        <label for="m_i">Middle Initial</label>
                                    </div>
                                    <div class="input-field col s12 m5">
                                        <input id="l_name" type="text" name="child_lname" class="validate" required="" aria-required="true">
                                        <label for="l_name">Last Name</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="birthdate" type="text" name="child_date_of_birth" class="validate" required="" aria-required="true" data-inputmask='"mask": "yyy-mm-dd"' data-mask value="">
                                        <label for="birthdate">Birthdate</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select required="" aria-required="true" name="child_grade">
                                          <option value="" disabled selected>-- Choose a Grade --</option>
                                          <option value="Kinder">Kinder</option>
                                          <option value="Grade 1">Grade 1</option>
                                          <option value="Grade 2">Grade 2</option>
                                          <option value="Grade 3">Grade 3</option>
                                          <option value="Grade 4">Grade 4</option>
                                          <option value="Grade 5">Grade 5</option>
                                          <option value="Grade 6">Grade 6</option>
                                          <option value="Grade 7">Grade 7</option>
                                          <option value="Grade 8">Grade 8</option>
                                          <option value="Grade 9">Grade 9</option>
                                          <option value="Grade 10">Grade 10</option>
                                          <option value="Grade 11">Grade 11</option>
                                          <option value="Grade 12">Grade 12</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="section" type="text" name="child_section" class="validate">
                                        <label for="section">Section</label><br/><br/>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add <i class="material-icons right">add</i></button>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <a href="/parent/child" class="btn waves-effect btn-large btn-block waves-light red" type="submit">Cancel</a> 
                                    </div>
                                </form>
                            </div>
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
        <script src="{{ asset('functions_js/addChild.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });

            $(function () { 
                //birthdate mm/dd/yyyy
                $("#birthdate").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
            });
        </script>
    @stop