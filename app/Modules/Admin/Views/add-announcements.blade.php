
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
                    <div class="profile-content">
                        <div class="row">
                            <h4>Add Announcement</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <form id="add-newAnnouncement" accept-charset="utf-8">
                                    <div class="input-field col s12 m12">
                                        <select name="announceTo">
                                            <option value="" disabled selected>This announcement is for ...</option>
                                            <option value="All">All</option>
                                            <option value="Teachers">Teachers</option>
                                            <option value="Parents">Parents</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="announcement_title" name="announceTitle" type="text" class="validate" required="">
                                        <label for="announcement_title">Announcement Title</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="announcement_description" name="announcement" class="materialize-textarea" required=""></textarea>
                                        <label for="announcement_description">Announcement Description</label>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
                                            <i class="material-icons right">error_outline</i>
                                        </button>
                                    </div>
                                    <div class="input-field col s12 m5 l4">
                                        <a href="/admin/announcements" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
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
        <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}"></link>
        <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
        <!--<script src="{{ asset('time_picker/jquery.timepicker.min.js') }}"></script> Time Picker -->
        <link rel="stylesheet" href="{{ asset('time_picker/jquery.timepicker.css') }}"></link>
        <!--<script src="{{ asset('time_picker/datepair.min.js') }}"></script> Date Picker -->
        <script src="{{ asset('time_picker/jquery.datepair.min.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function() {
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});


                $('#add-newAnnouncement').on('submit',function(e){
                    e.preventDefault();
                    var param = new FormData(this);
                    var url = '/admin/v2/process/Add_newAnnouncement';
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
                                window.location.href = '/admin/announcements';
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
            /* Date Picker jQuery UI*/
            $(function() {
                $( "#announcement_date" ).datepicker({ minDate: 0,
                    dateFormat: 'yy-mm-dd',
                    buttonImageOnly: true,
                    buttonText: "Select date"
              });
            });
            /* Time Picker 
            $('#appoinment_time .time').timepicker({
                'minTime': '7:00am',
                'maxTime': '7:00pm',
                'timeFormat': 'h:i A',
                'step': '15',
                'disableTimeRanges': [
                  ['12pm', '1pm']
                ]
            });

            var appoinment_time = document.getElementById('appoinment_time');
            var timeOnlyDatepair = new Datepair(appoinment_time);

            $('#dateOnlyExample .date').datepicker({
                'format': 'yyyy-m-d',
                'autoclose': true
            });
            var dateOnlyExampleEl = document.getElementById('dateOnlyExample');
            var dateOnlyDatepair = new Datepair(dateOnlyExampleEl);*/
        </script>
    @stop