
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
                        <h4>School List</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div class="row">
                            <div id="admin" class="col s12">
                                <div class="card material-table">
                                    <div class="table-header blue-grey lighten-5">
                                        <div class="actions">
                                            <a href="/su-admin/school/add" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add School">Add</a>
                                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                        </div>
                                    </div>
                                    <table id="datatable" class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 31px!important;">ID</th>
                                                <th>School</th>
                                                <th>Country</th>
                                                <th style="width: 130px!important;">Region</th>
                                                <th style="width: 70px!important;" class="center">Upload</th>
                                                <th class="center">Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($school as $school)
                                                <tr class="principal_list">
                                                    <td>{{ $school->id }}</td>
                                                    <td>{{ $school->school_name }}</td>
                                                    <td>{{ $school->state_id[0]->country }}</td>
                                                    <td>{{ $school->state_id[0]->state_name }}</td>
                                                    <td>
                                                        <!-- Switch -->
                                                        <div class="switch">
                                                            <label style="padding: 0 !important;">
                                                                @if($school->upload === 1)
                                                                    <input type="checkbox" class="switch_in" id="{{ $school->id }}" checked>
                                                                @else
                                                                     <input type="checkbox" class="switch_in" id="{{ $school->id }}">
                                                                @endif
                                                                <span class="lever"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="/su-admin/school/edit/{{ $school->id }}" class="btn waves-effect deep-orange"><i class="material-icons  white-text">edit</i></a>
                                                        <a href="#!" class="btn" onClick="showConfirmDeleteModal({{ $school->id }});"><i class="material-icons white-text">delete</i></a>
                                                    </td>
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
         <!-- Delete -->
        <div id="delete_school" class="modal">
            <div class="modal-content">
                <center>
                    <h5 class="file_name"></h5>
                    <div class="divider"></div>
                    <h5>Deleting School.</h5>
                    <h5>Are you sure?</h5>
                </center>
                <div class="row">
                    <div class="input-field col s12 m4 offset-m2">
                        <a href="#!" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete">Yes <i class="material-icons right">check</i></a>
                    </div>
                    <div class="input-field col s12 m4">
                        <a href="#!" class="modal-action modal-close btn waves-effect btn-large btn-block waves-light red">Cancel</a>
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
            $('.dropdown-button').dropdown();

            function showConfirmDeleteModal(id){
                //alert(id);
                $('#delete_school .btn_yes_delete').attr('id',id);
                $('#delete_school').openModal();
            }

            $('.btn_yes_delete').on('click',function(){
                var id = $(this).attr('id');
                $.post('/su_admin/v2/process/school_delete',{id:id},function(data){
                   var json = JSON.parse(data);
                    if(json.code == 1){
                        window.location.reload();
                    }else{
                        errorToast(json.message);
                    }
                });
            });

            $('.switch_in').change(function(){
                var changeTo = $(this).is(':checked');
                var id = $(this).attr('id');
                var param = {
                    id: id,
                    upload: changeTo 
                };

                $.post('/su_admin/v2/process/UpdateSchool_updateState',param,function(e){
                    //updating upload status here dont remove fuck my spelling hahaha
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