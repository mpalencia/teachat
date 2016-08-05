<!-- Dropdown PH-->
<nav class="blue-grey darken-4">
    <div class="container">
        <div class="nav-wrapper">
            @if(\Auth::user()->role_id == 2)
            <a href="{{url('teacher/dashboard')}}" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
            @elseif(\Auth::user()->role_id == 3)
            <a href="{{url('parent/dashboard')}}" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
            @elseif(\Auth::user()->role_id == 4)
            <a href="{{url('school-admin/dashboard')}}" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
            @else
            <a href="{{url('admin/dashboard')}}" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
            @endif
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

            <ul class="right">
                @if(\Auth::user()->role_id == 2)
                <li class="hide-on-med-and-down"><a href="{{url('teacher/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                @elseif(\Auth::user()->role_id == 3)
                <li class="hide-on-med-and-down"><a href="{{url('parent/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                @elseif(\Auth::user()->role_id == 4)
                <li class="hide-on-med-and-down"><a href="{{url('school-admin/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                @else
                <li class="hide-on-med-and-down"><a href="{{url('admin/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                @endif
                <li class="hide-on-med-and-down"><a href="javascript:void(0)" class="waves-effect help-toggle"><i class="material-icons">help_outline</i></a></li>
                @if(\Auth::user()->role_id != 4)
                <li>
                    <a style="cursor: pointer;" class="waves-effect dropdown-button messages" data-activates='messages' id="message_notifier"><span id="message_unread" class="unread hide">1</span><i class="material-icons">email</i></a>
                </li>
                @endif
                <li>
                    <a style="cursor: pointer;" class="waves-effect dropdown-button notification" data-activates='notification'>
                    @if(\Auth::user()->role_id == 2)
                    <?php
$count_notif_announcement = count(\Teachat\Models\Announcements::with('user')->where(['announce_to' => 1, 'seen' => 0])->orWhere(['announce_to' => 2, 'seen' => 0])->orderBy('created_at')->get());
$count_notif_video_call = count(\Teachat\Models\Appointments::with('parent')->where(['teacher_id' => \Auth::user()->id, 'seen' => 0])->orderBy('created_at')->get());
$count_notif = ($count_notif_announcement + $count_notif_video_call);
?>
                    @if($count_notif > 0)
                        <span class="unread">{{$count_notif}}</span>
                    @endif
                    <i class="material-icons">notifications</i>
                    @elseif(\Auth::user()->role_id == 3)
                    <?php
$count_notif_announcement = count(\Teachat\Models\Announcements::with('user')->where(['announce_to' => 2, 'seen' => 0])->orWhere(['announce_to' => 3, 'seen' => 0])->orderBy('created_at')->get());
$count_notif_video_call = count(\Teachat\Models\Appointments::with('teacher')->where(['parent_id' => \Auth::user()->id, 'seen' => 0])->orderBy('created_at')->get());
$count_notif = ($count_notif_announcement + $count_notif_video_call);
?>
                    @if($count_notif > 0)
                        <span class="unread">{{$count_notif}}</span>
                    @endif
                    <i class="material-icons">notifications</i>
                    @elseif(\Auth::user()->role_id == 4)
                    <?php
$count_notif_children = count(\Teachat\Models\Children::where(['approved' => 0, 'school_id' => \Auth::user()->school_id])->get());
$count_notif_teacher = count(\Teachat\Models\User::where(['approved' => 0, 'school_id' => \Auth::user()->school_id, 'role_id' => 2])->get());
$count_notif = ($count_notif_children + $count_notif_teacher);
?>
                    @if($count_notif > 0)
                        <span class="unread">{{$count_notif}}</span>
                    @endif
                    <i class="material-icons">notifications</i>
                    @endif
                    </a>
                </li>
                <li><a class="hide-on-med-and-down waves-effect blue-grey darken-2" href="/logout" ><i class="material-icons">power_settings_new</i></a></li>
            </ul>
            <ul id='messages' class='dropdown-content collection'>
                <!-- <li class="collection-item avatar">
                    <img src="http://materializecss.com/images/yuna.jpg" alt="" class="circle">
                    <span class="title truncate">Lowi Pogi</span>
                    <p class="truncate">Message content here. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>
                    <small>1day ago</small>
                </li> -->
                <li>
                    <h6 align="center">No new messages</h6>
                </li>
            </ul>
            <ul id='notification' class='dropdown-content collection'>
                <!--TEACHER-->
                @if(\Auth::user()->role_id == 2)
                @foreach(\Teachat\Models\Announcements::with('user')->where('announce_to', 1)->orWhere('announce_to', 2)->limit(5)->orderBy('created_at')->get() as $announcement)
                <li class="collection-item avatar <?php if ($announcement['seen'] == 0): ?> blue-grey lighten-5 <?php endif;?>" onClick="showDetailsAnnouncementById({{ $announcement['id'] }});">
                    <!-- <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ Auth::user()->profile_img }}" alt="" class="circle"> -->
                    <span class="title truncate">{{$announcement['user']['first_name']}} {{$announcement['user']['last_name']}}</span>
                    <p class="truncate">{{$announcement['title']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($announcement['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                @foreach(\Teachat\Models\Appointments::with('parent')->where('teacher_id', \Auth::user()->id)->limit(5)->orderBy('created_at')->get() as $appointment)
                <li class="collection-item avatar <?php if ($appointment['seen'] == 0): ?> blue-grey lighten-5 <?php endif;?>" onClick="functionViewDetail({{$appointment['id']}});" href="#appointment_details">
                    <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $appointment['parent']['profile_img'] }}" alt="" class="circle">
                    <span class="title truncate">{{$appointment['parent']['first_name']}} {{$appointment['parent']['last_name']}}</span>
                    <p class="truncate">{{$appointment['title']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($appointment['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                <!--PARENT-->
                @elseif(\Auth::user()->role_id == 3)
                @foreach(\Teachat\Models\Announcements::with('user')->where('announce_to', 2)->orWhere('announce_to', 3)->limit(5)->orderBy('created_at')->get() as $announcement)
                <li class="collection-item avatar <?php if ($announcement['seen'] == 0): ?> blue-grey lighten-5 <?php endif;?>" onClick="showDetailsAnnouncementById({{ $announcement['id'] }});">
                    <!-- <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ Auth::user()->profile_img }}" alt="" class="circle"> -->
                    <span class="title truncate">{{$announcement['user']['first_name']}} {{$announcement['user']['last_name']}}</span>
                    <p class="truncate">{{$announcement['title']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($announcement['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                @foreach(\Teachat\Models\Appointments::with('teacher')->where('parent_id', \Auth::user()->id)->limit(5)->orderBy('created_at')->get() as $appointment)
                <li class="collection-item avatar <?php if ($appointment['seen'] == 0): ?> blue-grey lighten-5 <?php endif;?>" onClick="functionViewDetail({{$appointment['id']}});" href="#appointment_details">
                    <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $appointment['teacher']['profile_img'] }}" alt="" class="circle">
                    <span class="title truncate">{{$appointment['teacher']['first_name']}} {{$appointment['teacher']['last_name']}}</span>
                    <p class="truncate">{{$appointment['title']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($appointment['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                <!--SCHOOL ADMIN-->
                @elseif(\Auth::user()->role_id == 4)
                <li class="collection-item avatar">Students Approval</li>
                @foreach(\Teachat\Models\Children::with('parent')->where(['approved' => 0, 'school_id' => \Auth::user()->school_id])->get() as $students)
                <li onclick="goToParentApproval(<?php echo $students['parent_id'] ?>)" class="collection-item avatar <?php if ($students['approved'] == 0): ?> blue-grey lighten-5 <?php endif;?>">
                    <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{$students['parent']['profile_img']}}" alt="" class="circle">
                    <span class="title truncate">{{$students['first_name']}} {{$students['last_name']}}</span>
                    <p class="truncate">{{$students['parent']['first_name']}} {{$students['parent']['last_name']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($students['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                <li class="collection-item avatar">Teachers Approval</li>
                @foreach(\Teachat\Models\User::where(['approved' => 0, 'school_id' => \Auth::user()->school_id, 'role_id' => 2])->get() as $teachers)
                <li onclick="goToTeacherApproval()" class="collection-item avatar <?php if ($teachers['approved'] == 0): ?> blue-grey lighten-5 <?php endif;?>" href="#appointment_details">
                    <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $teachers['profile_img'] }}" alt="" class="circle">
                    <span class="title truncate">{{$teachers['first_name']}} {{$teachers['last_name']}}</span>
                    <p class="truncate">{{$teachers['title']}}</p>
                    <small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($teachers['created_at']))->diffForHumans(); ?></small>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
        <!-- Navigation Mobile View -->
        @if(\Auth::user()->role_id == 2)
        <ul class="side-nav" id="mobile-demo">
            <li>
            </li>
            <li>
                <a href="{{url('teacher/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
            </li>
            <li>
                <a href="{{url('teacher/students')}}" class="waves-effect"><i class="material-icons">person_add</i> Students</span></a>
            </li>
            <li>
                <a href="/teacher/subjects" class="waves-effect"><i class="material-icons">subject</i> Subjects</span></a>
            </li>
            <li>
                <a href="/teacher/videocall" class="waves-effect"><i class="material-icons">room</i> Video Chat</span></a>
            </li>
            <li>
                <a href="/teacher/messages" class="waves-effect"><i class="material-icons">chat_bubble_outline</i> Messages</span></a>
            </li>
            <li>
                <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
            </li>
            <li>
                <a href="/teacher/announcements" class="waves-effect"><i class="material-icons">priority_high</i>Announcements </a>
            </li>
            <li>
                <a href="/teacher/history" class="waves-effect"><i class="material-icons">contacts</i>History </a>
            </li>
            <li>
                <a href="/teacher/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
            </li>
            <li>
                <a href="/logout" ><i class="material-icons">power_settings_new</i> Logout</a>
            </li>
        </ul>
        @else
        <ul class="side-nav" id="mobile-demo">
            <li>
            </li>
            <li>
                <a href="{{url('parent/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
            </li>
            <li>
                <a href="{{url('parent/child')}}" class="waves-effect"><i class="material-icons">person_add</i> Children</span></a>
            </li>
            <li>
                <a href="/parent/videocall" class="waves-effect"><i class="material-icons">room</i> Video Chat</span></a>
            </li>
            <li>
                <a href="/parent/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
            </li>
            <li>
                <a href="/parent/announcements" class="waves-effect"><i class="material-icons">priority_high</i>Announcements </a>
            </li>
            <li>
                <a href="/parent/history" class="waves-effect"><i class="material-icons">contacts</i>History </a>
            </li>
            <li>
                <a href="/logout" ><i class="material-icons">power_settings_new</i> Logout</a>
            </li>
        </ul>
        @endif
        <!-- /. Navigation Mobile View -->
    </div>
</nav>

<div id="announcement_view" class="modal modal-fixed-footer">
    <div class="modal-content">
        <center>
            <div class="preloader-wrapper big active">
              <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
        </center>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>
<!-- Modal Structure For Appointment Details-->
<div id="appointment_details" class="modal">
    <div class="modal-content">
       <center>
           <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                  <div class="circle-clipper left">
                    <div class="circle"></div>
                  </div><div class="gap-patch">
                    <div class="circle"></div>
                  </div><div class="circle-clipper right">
                    <div class="circle"></div>
                  </div>
                </div>
            </div>
       </center>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
@if(\Auth::user()->role_id == 3)
<img src="{{asset('images/help-2.jpg')}}" alt="help" class="help-img">
<script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
@else
<img src="{{asset('images/help-3.jpg')}}" alt="help" class="help-img">
<script src="{{ asset('functions_js/appointment.js') }}"></script>
@endif

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
<script type="text/javascript">
    $(".help-img").addClass("hide");
    $(".help-toggle").click(function(){
       $(".help-img").toggleClass("hide");
    });
    $('.notification').dropdown({
        inDuration: 500,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        belowOrigin: true // Displays dropdown below the button
    });

    function goToParentApproval(parent_id) {
        window.location.href="/school-admin/parents/"+parent_id;
    }

    function goToTeacherApproval() {
        window.location.href="/school-admin/teachers";
    }

    function showDetailsAnnouncementById(id){
        $('#announcement_view').openModal();
        $.get('/teacher/announcements/get/'+id,{},function(data){
                modalUIupdater(data);
        });
    }
    var view;
    var selector = {0:"Parents and Teachers",2:"Teachers",3:"Parents"};
    function modalUIupdater(data){
        view = '<h5>'+data.message.title+'</h5>'+
                    '<table><tbody><tr><td>Announcement to</td>'+
                                    '<td>'+selector[data.message.announce_to]+'</td></tr><tr>'+
                                '<td>Posted Date</td>'+
                                '<td>'+dateTohuman(data.message.created_at)+'</td></tr>'+
                                '<td>Posted By</td>'+
                                '<td>'+data.message.user.first_name+'</td></tr>'+
                                '</tbody>'+
                    '</table>'+
                    '<p>'+data.message.announcement+'</p>';
        $('#announcement_view .modal-content').html(view);
    }

    function showDetailsAppointmentById(id){
        $('#announcement_view').openModal();
        $.get('/teacher/appointments/get/'+id,{},function(data){
                modalUIupdater(data);
        });
    }
    var view;
    var selector = {0:"Parents and Teachers",2:"Teachers",3:"Parents"};
    function modalUIupdater(data){
        view = '<h5>'+data.message.title+'</h5>'+
                    '<table><tbody><tr><td>Announcement to</td>'+
                                    '<td>'+selector[data.message.announce_to]+'</td></tr><tr>'+
                                '<td>Posted Date</td>'+
                                '<td>'+dateTohuman(data.message.created_at)+'</td></tr>'+
                                '<td>Posted By</td>'+
                                '<td>'+data.message.user.first_name+'</td></tr>'+
                                '</tbody>'+
                    '</table>'+
                    '<p>'+data.message.announcement+'</p>';
        $('#announcement_view .modal-content').html(view);
    }

    function dateTohuman(date){
        //var dateObject = new Date(Date.parse(date));
        var dateReadable = moment(date).format("dddd, MMMM Do YYYY, h:mm:ss a"); //dateObject.toDateString();
        return dateReadable;
    }
</script>
