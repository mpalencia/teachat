
    @extends('theme')
    @section('title_tag')
        <title>Teacher : Settings</title>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @stop

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-profile')

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
                                    <a href="/teacher/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/teacher/myaccount" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/teacher/students" class="waves-effect"><i class="material-icons">assignment_ind</i>Students </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/teacher/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages</a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/teacher/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="active nav_tab" id="settings">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <h4>Settings</h4>
                        <span class="divider"></span>
                        <div class="divider"></div>
                        <div class="row">
                            <form class="col s12" id="form_settings">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="fa fa-graduation-cap prefix"></i>
                                        <input id="icon_prefix" type="text" disabled="" value="{{ $school[0]['school_name'] }}">
                                        <label for="icon_prefix"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s4 m2">
                                        <select required="" aria-required="true" id="name_prefix" name="name_prefix">
                                            <option value="" disabled selected>Select</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <label>Select</label>
                                        </select>
                                    </div>
                                    <div class="input-field col s8 m5">
                                      <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name" value="{{ $profile[0]['first_name'] }}">
                                      <label for="f_name">First Name</label>
                                    </div>
                                    <div class="input-field col s12 m5">
                                      <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name" value="{{ $profile[0]['last_name'] }}">
                                      <label for="l_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="icon_prefix" type="text" required="" aria-required="true" name="contact_no" value="{{ $details[0]['contact_no'] }}">
                                        <label for="icon_prefix">Contact Number</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="icon_prefix" type="text" disabled="" value="{{ $profile[0]['email'] }}">
                                        <label for="icon_prefix">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="divider"></div>
                            <ul class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header"><i class="material-icons">lock</i>Change Password</div>
                                    <div class="collapsible-body">
                                        <div class="row">
                                            @include('Universal::password')
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <div class="divider"></div><br/>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name_prefix').val('{{ $profile[0]["name_prefix"] }}');
            $('select').material_select();
            $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

            $('#form_settings').on('submit',function(e){
                var param = new FormData(this);
                var url = "/teacher/v2/process/updateSettings_tab";
                e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: url,
                        processData:false,
                        contentType:false,
                        cache:false,
                        data: param,
                        success: function (data) {
                            var json = $.parseJSON(data);
                            if(json.code == 1){
                                successToast(json.message);
                            }else{
                                errorToast(json.message);
                            }
                        }
                    });
            })
        });
        function errorToast(message){
            Materialize.toast(''+message+'', 5000, 'red');
        }

        function successToast(message){
            Materialize.toast(''+message+'', 5000, 'green');
        }
    </script>
    @stop