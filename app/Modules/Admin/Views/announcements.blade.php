
    @extends('theme')

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')
        @include('includes.nav-admin')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                @include('Universal::adminName')
                            </div>
                            <div class="profile-usertitle-job">
                                Administrator
                            </div>
                        </div>
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/admin" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="row" id="announcements">
                        <h4>Announcements</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <a href="/admin/announcements/add" class="btn waves-effect waves-light teal" type="submit" name="action">Add
                            <i class="material-icons right">error_outline</i>
                        </a><br/><br/>
                        <ul class="collection with-header">
                            @foreach($announce as $announce)
                                <li class="collection-item">
                                    <div>
                                        {{ $announce->announceTitle }} <br/>
                                        <small>{{ $announce->created_at }}</small>
                                        <div class="options_container">
                                            <div class="options_btn">
                                                <div class="right">
                                                    <a class="waves-effect waves-light btn " href="#announcement_view" onClick="showDetailsAnnouncementById({{ $announce->id }});"><i class="material-icons">zoom_in</i></a><!-- Modal Trigger For Appointment Details-->
                                                    <a href="/admin/announcements/edit/{{ $announce->id }}" class="waves-effect waves-light btn orange"><i class="material-icons">edit</i></a>
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn red delete_trigger-btn" ><i class="material-icons">delete</i></a>
                                                </div>
                                            </div>
                                            <div class="hide confirm_delete">
                                                <div class="right">
                                                    <h6>Delete this announcement?</h6> 
                                                    <a href="#" onClick="deleteAnnouncementById({{ $announce->id }});" class="waves-effect waves-light btn">Yes</a>
                                                    <a href="javascript:void(0)" class="waves-effect waves-light btn red cancel_delete">No</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Announcement -->
        <div id="announcement_view" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Announcement Title</h5>
                <table>
                    <tbody>
                        <tr>
                            <td>Announcement to</td>
                            <td>All / Parents / Teachers</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>Announcement time will be placed here</td>
                        </tr>
                        <tr>
                            <td>Attachment</td>
                            <td><a href="#!"><i class="material-icons">description</i> Download Attachement</a> or No Attachement Available</td>
                        </tr>
                    </tbody>
                </table>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
    <script type="text/javascript">
        $('.c_content').on('click', function(){
            $('.c_content').removeClass('blue-grey darken-4');
            $(this).addClass('blue-grey darken-4');
        });

        /* Hide and Show Delete Btn*/
        $('.delete_trigger-btn').on('click',function(){
           var cl =  $(this).parent('div').parent('div').addClass('hide').parent('div').attr('class');
                var xc = $(this).closest('.'+cl).find('.confirm_delete').removeClass('hide');
        });
        $('.cancel_delete').on('click',function(){
            var cl = $(this).parent('div').parent('div').addClass('hide').parent('div').attr('class');
            $(this).closest('.'+cl).find('.options_btn').removeClass('hide');
        });

        function deleteAnnouncementById(id){
           $.get('/admin/v2/process/deleteAnnounce/'+id,{},function(data){
                var json = JSON.parse(data);
                    if(json.code == 1){
                        successToast(json.message);
                        window.location.href = '/admin/announcements';
                        //$('#add-prinsipal_submit')[0].reset();
                    }else{
                        errorToast(json.message);
                    }
           });
        }

        function errorToast(message){
            Materialize.toast(''+message+'', 5000, 'red');
        }

        function successToast(message){
            Materialize.toast(''+message+'', 5000, 'green');
        }

        $('.modal-trigger').leanModal();

        function showDetailsAnnouncementById(id){
            $('#announcement_view').openModal();
            $.get('/admin/v2/process/viewDetailsAnnouncement/'+id,{},function(data){
                var json = JSON.parse(data);
                    console.log(json);
                    modalUIupdater(json[0]);
            });
        }
        var view;
        var selector = {0:"All",2:"Teachers",3:"Parents"};
        function modalUIupdater(data){
            view = '<h5>'+data.announceTitle+'</h5>'+
                        '<table><tbody><tr><td>Announcement to</td>'+
                                        '<td>'+selector[data.announceTo]+'</td></tr><tr>'+
                                    '<td>Posted Date</td>'+
                                    '<td>'+data.created_at+'</td></tr>'+
                                    '</tbody>'+
                        '</table>'+
                        '<p>'+data.announcement+'</p>';
            $('#announcement_view .modal-content').html(view);
        }
    </script>
    @stop