<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>
        <script type="text/javascript" src="https://a.floox.com:1338/rmc3.min.js"></script>
        <script type="text/javascript" src="https://a.floox.com:1338/Floox.js"></script>
        @include('layouts.header')
        @include('layouts.teachat-css')
        @include('layouts.teachat-js')
    </head>

    <body>
        <main>
            @include('layouts.loader')
            @if(! \Auth::check())
                @include('layouts.navigations.homepage')
            @else
                @include('layouts.navigations.master')
            @endif
            <div class="container">
                <div class="row profile">
                    <div class="col s12 m12 l3 hide-on-med-and-down">
                        <div class="profile-sidebar">
                            @if(\Auth::user()->role_id == 1)

                            @include('layouts.sidebars.admin')

                            @elseif(\Auth::user()->role_id == 2)

                            @include('layouts.sidebars.teachers')

                            @elseif(\Auth::user()->role_id == 3)

                            @include('layouts.sidebars.parent')

                            @else

                            @include('layouts.sidebars.school-admin')

                            @endif
                        </div>
                    </div>
                    <div class="col s12  m12 l9">
                    
                        @if(Auth::user()->password_reset == 1)
                            <div class= "s12 m12">
                                <div class="card-panel blue white-text">
                                    <h6 style="display: inline-block">
                                        You need to change your password
                                    </h6>
                                    @if(Auth::user()->role_id == 3)
                                    <!-- <a href="/parent/myaccount" class="waves-effect waves-light btn orange right">Go to My Account</a> -->
                                    <a href="#reset_password_modal" onclick="resetPassword3(this)" class="waves-effect waves-light btn orange right">Change Password</a>
                                    @elseif(Auth::user()->role_id == 2)
                                    <!-- <a href="/teacher/myaccount" class="waves-effect waves-light btn orange right">Go to My Account</a> -->
                                    <a href="#reset_password_modal" onclick="resetPassword2(this)" class="waves-effect waves-light btn orange right">Change Password</a>
                                    @elseif(Auth::user()->role_id == 4)
                                    <!-- <a href="/school-admin/myaccount" class="waves-effect waves-light btn orange right">Go to My Account</a> -->
                                    <a href="#reset_password_modal" onclick="resetPassword4(this)" class="waves-effect waves-light btn orange right">Change Password</a>
                                    @elseif(Auth::user()->role_id == 5)
                                    <!-- <a href="/teacher/myaccount" class="waves-effect waves-light btn orange right">Go to My Account</a> -->
                                    <a href="#reset_password_modal" onclick="resetPassword5(this)" class="waves-effect waves-light btn orange right">Change Password</a>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @endif

                        @yield('body_content')
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.footer')
    </body>

    <!-- Forgot Password Modal -->
<div id="reset_password_modal_parent" class="modal reset_password_modal_parent">
    <div class="modal-content">
            <form class="col s12" id="frm_reset_password_modal_parent">
                <div class="input-field col s6">
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
                <div class="input-field col s12 m6 offset-m3">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Reset</button>
                    <a href="" onclick="reload(this)" class="waves-effect waves-white btn-flat modal-action modal-close right freakin-modal">Close</a>
                </div>
                <div class="div_notif notif"></div>
            </form>
    </div>
</div>

<div id="reset_password_modal_teacher" class="modal reset_password_modal_teacher">
    <div class="modal-content">
            <form class="col s12" id="frm_reset_password_modal_teacher">
                <div class="input-field col s6">
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
                <div class="input-field col s12 m6 offset-m3">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Reset</button>
                    <a href="" onclick="reload(this)" class="waves-effect waves-white btn-flat modal-action modal-close right freakin-modal">Close</a>
                </div>
                <div class="div_notif notif"></div>
            </form>
    </div>
</div>

<div id="reset_password_modal_school-admin" class="modal reset_password_modal_school-admin">
    <div class="modal-content">
            <form class="col s12" id="frm_reset_password_modal_school-admin">
                <div class="input-field col s6">
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
                <div class="input-field col s12 m6 offset-m3">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Reset</button>
                    <a href="" onclick="reload(this)" class="waves-effect waves-white btn-flat modal-action modal-close right freakin-modal">Close</a>
                </div>
                <div class="div_notif notif"></div>
            </form>
    </div>
</div>

<div id="reset_password_modal_admin" class="modal reset_password_modal_admin">
    <div class="modal-content">
            <form class="col s12" id="frm_reset_password_modal_admin">
                <div class="input-field col s6">
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
                <div class="input-field col s12 m6 offset-m3">
                    <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Reset</button>
                    <a href="" onclick="reload(this)" class="waves-effect waves-white btn-flat modal-action modal-close right freakin-modal">Close</a>
                </div>
                <div class="div_notif notif"></div>
            </form>
    </div>
</div>
    
    @yield('custom-scripts')
    <script type="text/javascript" src="{{asset('teachatv3/teachatv3.js')}}"></script>
    <script type="text/javascript">   
        function resetPassword3(password) {
            $('#reset_password_modal_parent').openModal();
        }

        function resetPassword2(password) {
            $('#reset_password_modal_teacher').openModal();
        }

        function resetPassword4(password) {
            $('#reset_password_modal_school-admin').openModal();
        }

        function resetPassword5(password) {
            $('#reset_password_modal_admin').openModal();
        }

        function reload(password) {
            window.location.reload();
        }

        $('#frm_reset_password_modal_parent').on('submit',function(e){
            e.preventDefault();
            ajaxCall('POST', '/parent/resetpassword/forgot', getFormInputs(this.id), false, 'card', 'frm_reset_password_modal_parent', '', 'one');
            $('#frm_reset_password_modal_parent')[0].reset();
        });

        $('#frm_reset_password_modal_teacher').on('submit',function(e){
            e.preventDefault();
            ajaxCall('POST', '/teacher/resetpassword/forgot', getFormInputs(this.id), false, 'card', 'frm_reset_password_modal_teacher', '', 'one');
            $('#frm_reset_password_modal_teacher')[0].reset();
        });

        $('#frm_reset_password_modal_school-admin').on('submit',function(e){
            e.preventDefault();
            ajaxCall('POST', '/school-admin/resetpassword/forgot', getFormInputs(this.id), false, 'card', 'frm_reset_password_modal_school-admin', '', 'one');
            $('#frm_reset_password_modal_school-admin')[0].reset();
        });

        $('#frm_reset_password_modal_admin').on('submit',function(e){
            e.preventDefault();
            ajaxCall('POST', '/admin/resetpassword/forgot', getFormInputs(this.id), false, 'card', 'frm_reset_password_modal_admin', '', 'one');
            $('#frm_reset_password_modal_admin')[0].reset();
        });

    </script>

</html>

