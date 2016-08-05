
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
                            <h4>Teachers</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <div class="actions">
                                                <a href="/su-admin/teachers/add" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons right">add</i> Add Teachers</a>
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Teacher's Name</th>
                                                    <th>Email Address</th>
                                                    <th>School</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>{{ $user->name_prefix }} {{ $user->first_name }} {{ $user->last_name }} </td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->school_name }}</td>
                                                        <td>
                                                            <a href="/su-admin/teachers/edit/{{ $user->id }}" class="btn waves-effect deep-orange"><i class="material-icons  white-text">edit</i></a>
                                                            <a href="#" class="btn waves-effect teal" onClick="showConfirmDeleteModal({{ $user->id }});"><i class="material-icons white-text">delete</i></a>
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
        <div id="delete_teacher" class="modal">
            <div class="modal-content">
                <center>
                    <h5>Deleting Teacher</h5>
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

             function showConfirmDeleteModal(id){
                //alert(id);
                $('#delete_teacher .btn_yes_delete').attr('id',id);
                $('#delete_teacher').openModal();
            }

            $('.btn_yes_delete').on('click',function(){
                var id = $(this).attr('id');
                $.post('/su_admin/v2/process/teacher_delete',{id:id},function(data){
                   var json = JSON.parse(data);
                    if(json.code == 1){
                        window.location.reload();
                    }else{
                        errorToast(json.message);
                    }
                });
            });

            $(".dp_custom").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: false, // Displays dropdown below the button
            });
            $('.modal-trigger').leanModal();

            function errorToast(message){
                Materialize.toast(''+message+'', 5000, 'red');
            }

            function successToast(message){
                Materialize.toast(''+message+'', 5000, 'green');
            }
        </script>
    @stop