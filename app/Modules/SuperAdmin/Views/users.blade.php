
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
                                <li class="nav_tab" id="settings">
                                    <a href="/su-admin/teachers" class="waves-effect"><i class="material-icons">contacts</i>Teachers </a>
                                </li>
                                <li class="active nav_tab" id="settings">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">group</i>Users </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4>Users</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <h5><small>Total no of users:</small> {{ $totalUser }}</h5>
                                            <div class="actions">
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>School</th>
                                                    <th>Active <a href="#" class="waves-effect btn-flat nopadding"><i class="material-icons" id="Active_lock">lock_outline</i></a></th>
                                                    <th>Suspend <a href="#" class="waves-effect btn-flat nopadding"><i class="material-icons" id="Suspend_lock">lock_outline</i></a></th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>{{ $user->name_prefix }} {{ $user->first_name }} {{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->school_name }}</td>
                                                        <td>
                                                           <!-- Switch -->
                                                            <div class="switch">
                                                                <label>
                                                                    @if($user->status === 0)
                                                                        <input type="checkbox" class="switch_status" disabled id="{{ $user->id }}" checked>
                                                                    @else
                                                                         <input type="checkbox" class="switch_status" disabled id="{{ $user->id }}">
                                                                    @endif
                                                                    <span class="lever"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- Switch -->
                                                            <div class="switch">
                                                                <label>
                                                                    @if($user->suspend === 1)
                                                                        <input type="checkbox" class="switch_in" disabled id="{{ $user->id }}" checked>
                                                                    @else
                                                                         <input type="checkbox" class="switch_in" disabled id="{{ $user->id }}">
                                                                    @endif
                                                                    <span class="lever"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="/su-admin/users/edit/{{ $user->id }}" class="btn waves-effect deep-orange"><i class="material-icons  white-text">edit</i></a>
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


            $('.switch_in').change(function(){
                var changeTo = $(this).is(':checked');
                var id = $(this).attr('id');
                var param = {
                    id: id,
                    suspend: changeTo 
                };
                //alert(changeTo);
                $.post('/su_admin/v2/process/suspendUser',param,function(e){
                    //updating upload status here dont remove fuck my spelling hahaha
                });
            });

            $('.switch_status').change(function(){
                var changeTo = $(this).is(':checked');
                var id = $(this).attr('id');
                var param = {
                    id: id,
                    status: changeTo 
                };
                //alert(changeTo);
                $.post('/su_admin/v2/process/activateUser',param,function(e){
                    //updating upload status here dont remove fuck my spelling hahaha
                });
            });

            $('#Active_lock').on('click',function(){
                var current; 
               var status = $(this).html();
                if(status == 'lock_outline'){
                    current = 'lock_open';
                    $('.switch_status').attr('disabled',false);
                }else{
                    current = 'lock_outline';
                    $('.switch_status').attr('disabled','disabled');
                }

                $(this).html(current);
            });

            $('#Suspend_lock').on('click',function(){
                var current; 
               var status = $(this).html();
                if(status == 'lock_outline'){
                    current = 'lock_open';
                    $('.switch_in').attr('disabled',false);
                }else{
                    current = 'lock_outline';
                    $('.switch_in').attr('disabled','disabled');
                }

                $(this).html(current);
            });
        </script>
    @stop