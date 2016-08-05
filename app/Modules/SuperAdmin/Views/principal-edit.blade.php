
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
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">person_add</i> School Principal</span></a>
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
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
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
                            <h4>Edit Principal</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="updatePrincipal_submit" accept-charset="utf-8">
                                    <div class="input-field col s12 m6">
                                        <input id="principal_title" type="text" class="validate" value="{{ $principal[0]['first_name'] }}" name="first_name" required="required">
                                        <label for="principal_title">Principal Name</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="principal_email" type="email" class="validate" value="{{ $principal[0]['email'] }}" name="email" required="required">
                                        <label for="principal_email">Principal Email</label>
                                    </div>
                                    <!--<div class="input-field col s12 m12">
                                        <select>
                                            <option value="" disabled selected>Country</option>
                                            <option value="Country 1">Country 1</option>
                                            <option value="Country 2">Country 2</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select>
                                            <option value="" disabled selected>Choose Region</option>
                                            <option value="Region 1">Region 1</option>
                                            <option value="Region 2">Region 2</option>
                                        </select>
                                    </div>-->
                                    <div class="input-field col s12 m12">
                                        <select name="school_id" id="school_id">
                                            <option value="" disabled selected>Choose School</option>
                                            @foreach($school as $school)
                                                <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $principal[0]['id'] }}"></input>
                                    <!--<div class="input-field col s12 m6">
                                        <input id="principal_password" type="password" class="validate"  required="required">
                                        <label for="principal_password">Password</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="principal_againpassword" type="password" class="validate" required="required">
                                        <label for="principal_againpassword">Re-type Password</label>
                                    </div>-->
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Save Changes
                                            <i class="material-icons right">border_color</i>
                                        </button>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <a href="/su-admin/principals/" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
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
        <script type="application/javascript">
            $(document).ready(function() {
                $('#school_id').val('{{ $principal[0]["school_id"] }}');
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

                $('#updatePrincipal_submit').on('submit',function(e){
                    e.preventDefault();
                    var param = new FormData(this);
                    var url = '/su_admin/v2/process/Update_Principal';
                    $.ajax({
                        type: "POST",
                        url: url,
                        processData:false,
                        contentType:false,
                        async: true,
                        cache:false,
                        data: param,
                        success: function (data) {
                            var json = JSON.parse(data);
                            if(json.code == 1){
                                successToast(json.message);
                                window.location.href = '/su-admin/principals';
                                //$('#add-prinsipal_submit')[0].reset();
                            }else{
                                errorToast(json.message);
                            }
                        }
                    });

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