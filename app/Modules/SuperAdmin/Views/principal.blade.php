
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
                                <li class="nav_tab active" id="overview">
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
                        <h4>Principals List</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div class="row">
                            <div id="admin" class="col s12">
                                <div class="card material-table">
                                    <div class="table-header blue-grey lighten-5">
                                        <div class="actions">
                                            <a href="/su-admin/principals/add" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Principal">Add <i class="material-icons">person_add</i></a>
                                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                        </div>
                                    </div>
                                    <table id="datatable" class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>School</th>
                                                <th>Email</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($principals as $principal)
                                                <tr class="principal_list">
                                                    <td>{{ $principal->first_name }}</td>
                                                    <td>
                                                        @if(isset($principal->school[0]))
                                                            {{ $principal->school[0]['school_name'] }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $principal->email }}</td>
                                                    <td>
                                                        <!-- Dropdown Trigger -->
                                                        <a class='dropdown-button btn' data-activates='{{ $principal->id }}' href='#'><i class="material-icons tiny">settings</i></a>

                                                          <!-- Dropdown Structure -->
                                                        <ul id='{{ $principal->id }}' class='dropdown-content'>
                                                            <li><a href="/su-admin/principals/edit/{{ $principal->id }}"><i class="material-icons">edit</i> Edit</a></li>
                                                            <li class="red white-text"><a href="#" onClick="showConfirmDeleteModal({{ $principal->id }});"><i class="material-icons">delete</i> Delete</a></li>
                                                        </ul>
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
        <div id="delete_principal" class="modal">
            <div class="modal-content">
                <center>
                    <h5 class="file_name"></h5>
                    <div class="divider"></div>
                    <h5>Deleting principal.</h5>
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
                $('#delete_principal .btn_yes_delete').attr('id',id);
                $('#delete_principal').openModal();
            }

            $('.btn_yes_delete').on('click',function(){
                var id = $(this).attr('id');
                $.get('/su-admin/principals/delete/'+id,{},function(data){
                    window.location.reload();
                });
            });
        </script>
    @stop