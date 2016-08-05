
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
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">room</i> Location</span></a>
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
                            <h4>Location</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row" id="add_location">
                                <form id="add-new_state" accept-charset="utf-8">
                                    <div class="input-field col s12 m4">
                                        <select name="country" required="required">
                                            <option value="" disabled selected>Country</option>
                                            @foreach($country as $country_)
                                                <option value="{{ $country_->country }}">{{ $country_->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="state_region" type="text" class="validate" required="required" name="state_name">
                                        <label for="state_region">Region / State</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
                                            <i class="material-icons right">add</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="row hide" id="edit_location">
                                <form id="edit_location_form" accept-charset="utf-8">
                                    <div class="input-field col s12 m4">
                                        <select name="country" required="required" id="set_country">
                                            <option value="" disabled selected>Country</option>
                                            @foreach($country as $key => $country_list)
                                                <option value="{{ $country_list->country }}">{{ $country_list->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="set_region" type="text" class="validate" required="required" name="state_name">
                                        <label for="state_region">Region / State</label>
                                    </div>
                                    <input type="hidden" name="id" id="editing_id">
                                    <div class="input-field col s12 m4">
                                        <button class="btn waves-effect btn-large btn-block waves-light orange" type="submit">Save
                                            <i class="material-icons right">check</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <div class="actions">
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th class="center">Country</th>
                                                    <th class="center">Region / State</th>
                                                    <th class="center">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list as $list)
                                                    <tr id="{{ $list->id }}">
                                                        <td class="center country">{{ $list->country }}</td>
                                                        <td class="center state">{{ $list->state_name }}</td>
                                                        <td class="center"><a href="#!" class="btn waves-effect white-text" onclick="showEditLocation('{{ $list->id }}');"><i class="material-icons">edit</i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
        <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
        <script type="text/javascript">
            $(".dp_custom").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: false, // Displays dropdown below the button
            });
            $('.modal-trigger').leanModal();
            $('select').material_select();

            $('#add-new_state').on('submit',function(e){
                e.preventDefault();
                var param = new FormData(this);
                var url = "/su_admin/v2/process/addNewState";
                $.ajax({
                    type: "POST",
                    url: url,
                    processData:false,
                    contentType:false,
                    //async: true,
                    cache:false,
                    data: param,
                    success: function (data) {
                        var json = $.parseJSON(data);
                        if(json.code == 1){
                            window.location.reload();
                        }else{
                            errorToast(json.message);
                        }
                    }
                });
            });

            $('#edit_location_form').on('submit',function(e){
                e.preventDefault();
                var param = new FormData(this);
                var url = "/su_admin/v2/process/updateState";
                $.ajax({
                    type: "POST",
                    url: url,
                    processData:false,
                    contentType:false,
                    //async: true,
                    cache:false,
                    data: param,
                    success: function (data) {
                        var json = $.parseJSON(data);
                        if(json.code == 1){
                            successToast(json.message);
                            window.location.reload();
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

            function showEditLocation(id) {
                $('#add_location').addClass('hide');
                $('#edit_location').removeClass('hide');
                $('#set_country').val($('#datatable #'+id+' .country').text());
                $('#set_region').val($('#datatable #'+id+' .state').text());
                $('#editing_id').val(id);
                $('#set_country').material_select();
            }
        </script>
    @stop