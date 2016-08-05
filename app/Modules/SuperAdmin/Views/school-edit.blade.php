
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
                            <h4>Edit School</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="SU_updateSchool" accept-charset="utf-8">
                                    <div class="input-field col s10 m10">
                                        <div class="file-field input-field">
                                          <div class="btn">
                                            <span>File</span>
                                            <input type="file" class="validate" name="school_logo" accept="image/*">
                                          </div>
                                          <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="School logo or badge">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col s2 m2">
                                        <small style="margin-top: -5px !important; display: block;">Current Badge</small>
                                        <figure class="school_badge" style="background-image: url('{{asset('/images/school_badges')}}/{{ $school[0]['school_logo']  }}'); width: 70px; height: 70px;"></figure>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="school_title" type="text" class="validate" required="required" value="{{ $school[0]['school_name'] }}" name="school_name">
                                        <label for="school_title">School Name</label>
                                    </div>
                                    
                                    <div class="input-field col s12 m12">
                                        <select required="required" name="state_id" id="state_id">
                                            <option value="" disabled selected>Choose State</option>
                                            @foreach($state as $state)
                                                 <option value="{{ $state['id'] }}" class="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <input type="hidden" name="id" value="{{ $school[0]['id'] }}"></input>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Save
                                            <i class="material-icons right">check</i>
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
                $('#state_id').val('{{ $school[0]["state_id"] }}');
                $('#country_id').val('{{ $school[0]["state_id"] }}');
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});


                $('#SU_updateSchool').on('submit',function(e){
                    e.preventDefault();
                    var param = new FormData(this);
                    var url = '/su_admin/v2/process/updateSchool';
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