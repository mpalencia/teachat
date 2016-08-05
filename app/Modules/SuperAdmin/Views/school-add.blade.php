
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
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">location_city</i> School</span></a>
                                </li>
                                <li class="nav_tab" id="overview">
                                    <a href="/su-admin/location" class="waves-effect"><i class="material-icons">room</i> Location</span></a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teacher </a>
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
                            <h4>Add School</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="add-NewSchool_submit" accept-charset="utf-8">
                                    <div class="input-field col s12 m12">
                                        <div class="file-field input-field">
                                          <div class="btn">
                                            <span>File</span>
                                            <input type="file" class="validate" required="required" name="school_logo" accept="image/*">
                                          </div>
                                          <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="School logo or badge">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="school_title" type="text" class="validate" required="required" name="school_name">
                                        <label for="school_title">School Name</label>
                                    </div>
                                    <!--<div class="input-field col s12 m6">
                                        <input id="school_title" type="text" class="validate" required="required" name="country">
                                        <label for="school_title">Country</label>
                                    </div>-->
                                    <div class="input-field col s12 m6">
                                        <select required="required" name="state_id">
                                            <option value="" disabled selected>Choose Country</option>
                                                <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select required="required" name="state_id">
                                            <option value="" disabled selected>Choose Location</option>
                                            @foreach($state as $state)
                                                <option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Add
                                            <i class="material-icons right">add</i>
                                        </button>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <a href="/su-admin/school/" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
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
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            
                $('#add-NewSchool_submit').on('submit',function(e){
                    e.preventDefault();
                    var param = new FormData(this);
                    var url = '/su_admin/v2/process/AddSchool';
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
                                window.location.href = "/su-admin/school";
                            }
                        }
                    });
                });
            });
        </script>


    @stop