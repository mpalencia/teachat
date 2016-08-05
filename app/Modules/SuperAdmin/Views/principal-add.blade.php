
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
                            <h4>Add Principal</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="add-prinsipal_submit" accept-charset="utf-8">
                                    <div class="input-field col s12 m6">
                                        <input id="principal_title" type="text" class="validate" required="required" name="first_name">
                                        <label for="principal_title">Principal Name</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="principal_email" type="email" class="validate" required="required" name="user_email">
                                        <label for="principal_email">Principal Email</label>
                                    </div>
                                    <!--<div class="input-field col s12 m12">
                                        <select id="reg_select_country" >
                                            <option value="" disabled selected>Country</option>
                                            @foreach($country as $country)
                                                <option value="{{ $country->country }}">{{ $country->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select id="reg_select_region">
                                            <option value="" disabled selected>Choose Region</option>
                                             @foreach($region as $region)
                                                <option value="{{ $region->state_name }}">{{ $region->state_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>-->
                                    <div class="input-field col s12 m12">
                                        <select id="reg_select_school" name="school_id" required="required">
                                            <option value="" disabled selected>Choose School</option>
                                            @foreach($school as $school)
                                                <option value="{{  $school->id }}">{{ $school->school_name }}</option>
                                                
                                            @endforeach
                                        </select>
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
                $('select').material_select();
                //$('#reg_select_school').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            
                /*$('#reg_select_country').change(function(){
                    var id = $(this).val();
                    //alert(id);
                        $('#reg_select_region').change();
                    $.get('registration/v2/school/getState/'+id,function(data){
                        console.log(data);
                        $('#reg_select_region').html('<option value="" disabled selected>Choose your Region</option>');
                        for(i = 0; i < data.length; i++){
                            //$('#reg_select_region').parent('div').find('ul').append('<option value="'+data[i].id+'">'+data[i].state_name+'</option>');
                            $('#reg_select_region').append('<option value="'+data[i].id+'">'+data[i].state_name+'</option>');
                            //$('select').material_select();
                        }
                    });
                });

                $('#reg_select_region').change(function(){
                    var id = $(this).val();
                    $.get('registration/v2/school/getSchool/'+id,function(data){
                        $('#reg_select_school').html('<option value="" disabled selected>Choose your School</option>');
                        for(i = 0; i < data.length; i++){
                            $('#reg_select_school').append('<option value="'+data[i].id+'">'+data[i].school_name+'</option>');
                            //$('select').material_select();
                        }
                    });
                });*/

                $('#add-prinsipal_submit').on('submit',function(e){
                    e.preventDefault();
                    var param = new FormData(this);
                    var url = '/su_admin/v2/process/Add_newPrincipal';
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