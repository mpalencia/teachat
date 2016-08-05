
    @extends('theme')

    @section('additional_headtag')
        <title>SUAdmin</title>
    @stop

    @section('body_content')

        @include('includes.nav-admin')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/su-admin" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/principals" class="waves-effect"><i class="material-icons">person_add</i> School Principal</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/school" class="waves-effect"><i class="material-icons">location_city</i> School</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/location" class="waves-effect"><i class="material-icons">room</i> Location</span></a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                                <li class="active nav_tab" id="settings">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/users" class="waves-effect"><i class="material-icons">group</i>Users </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4>Add Teacher</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="add-Teacher" accept-charset="utf-8">
                                    <div class="row">
                                        <div class="input-field col s4 m2">
                                            <select required="" aria-required="true" name="name_prefix">
                                                <option value="" disabled selected>Select</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <label>Select</label>
                                            </select>
                                        </div>
                                        <div class="input-field col s8 m5">
                                            <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name">
                                            <label for="f_name">First Name</label>
                                        </div>
                                        <div class="input-field col s12 m5">
                                            <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name">
                                            <label for="l_name">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <select required="required" name="school_id">
                                            <option value="" disabled selected>Choose School</option>
                                            @foreach($school as $school)
                                                <option value="{{ $school['id'] }}">{{ $school['school_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="email" type="email" class="validate" required="required" name="user_email">
                                        <label for="email">Email Address</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="principal_password" type="password" class="validate" required="required" name="password">
                                        <label for="principal_password">Password</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="principal_againpassword" type="password" class="validate" required="required" name="password_confirm">
                                        <label for="principal_againpassword">Re-type Password</label>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
                                            <i class="material-icons right">add</i>
                                        </button>
                                    </div>
                                    <input type="hidden" value="teacher" name="type">
                                    <div class="input-field col s12 m5 l4">
                                        <a href="/su-admin/teachers" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
                                    </div>
                                </form>
                            </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <script type="text/javascript">
        $('select').material_select();
            $(".dp_custom").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: false, // Displays dropdown below the button
            });
            $('.modal-trigger').leanModal();

            $('#add-Teacher').on('submit',function(e){
                e.preventDefault();
                var param = new FormData(this);
                var url = '/registration/v2/process/registration';
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
                            window.location.href = "/su-admin/teachers";
                        }else{
                            errorToast(json.message);
                        }
                    }
                });
            });

            function errorToast(message){
                Materialize.toast(''+message+'', 5000, 'red');
            }

            function successToast(message){
                Materialize.toast(''+message+'', 5000, 'green');
            }
        </script>
    @stop