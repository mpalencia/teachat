
<!-- SIDEBAR USERPIC -->
@if(Auth::user()->profile_img != NULL)
<div class="profile-userpic" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ Auth::user()->profile_img }}')">
@else
<div class="profile-userpic" style="background-image: url('{{ asset('/images/profile/dp.png') }}')">
@endif

    <span>
        <form id="form_profile" class="frm_profileUpload" enctype="multipart/form-data" file="true">
            <input type="file" class="profile_upload" name="profile_img" id="image_input" accept="image/*">
            <span class="hover_dp" onClick="onClickCamera();return;"><i class="fa fa-camera fa-fw fa-2x"></i> Upload Picture</span>
        </form>
    </span>
</div>
<div class="profile-usertitle">
    <div class="profile-usertitle-name">
        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
    </div>
    <div class="profile-usertitle-job">
        Teacher
    </div>
</div>

<div class="profile-usermenu">
    <ul class="nav">
        <li class="@if(strpos(url()->current(),'teacher/dashboard')) active @endif nav_tab" id="dashboard">
            <a href="{{url('teacher/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/myaccount')) active @endif nav_tab" id="settings">
            <a href="/teacher/myaccount" class="waves-effect"><i class="material-icons">person_pin</i>My Account </a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/students')) active @endif nav_tab" id="overview">
            <a href="{{url('teacher/students')}}" class="waves-effect"><i class="material-icons">person_add</i> Students</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/subjects')) active @endif nav_tab" id="overview">
            <a href="/teacher/subjects" class="waves-effect"><i class="material-icons">subject</i> Subjects</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/messages')) active @endif nav_tab" id="overview">
            <a href="/teacher/messages" class="waves-effect"><i class="material-icons">chat_bubble_outline</i> Messages</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/appointments')) active @endif nav_tab" id="settings">
            <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/announcements')) active @endif nav_tab" id="settings">
            <a href="/teacher/announcements" class="waves-effect"><i class="material-icons">priority_high</i>Announcements </a>
        </li>
        <li class="@if(strpos(url()->current(), 'teacher/history')) active @endif nav_tab" id="settings">
            <a href="/teacher/history" class="waves-effect"><i class="material-icons">contacts</i>History </a>
        </li>
        
    </ul>
</div>


<script type="text/javascript">

$(document).ready(function(){
   $('#image_input').change(function(){
    var myfile = $(this).val();
       var ext = myfile.split('.').pop();
       if(ext=="jpeg" || ext=="jpg" || ext=="png" || ext=="gif"){
        $('#form_profile').submit();
       } else{
        Materialize.toast("Required file types: jpeg, jpg, png, gif", 7000, 'red');
       }
   });

   $("#form_profile").on('submit',(function(e) {
           e.preventDefault();
           $.ajax({
             url: "{{url('teacher/uploadImage')}}", // Url to which the request is send
             type: "POST",             // Type of request to be send, called as method
             data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
             contentType: false,       // The content type used when sending data to the server.
             cache: false,             // To unable request pages to be cached
             processData:false,        // To send DOMDocument or non processed data file it is set to false
             success: function(data)   // A function to be called if request succeeds
             {
               var msg = JSON.parse(data);
               if(msg.result == 'success'){
                 Materialize.toast(msg.message, 7000, 'green');
                 window.location.reload();
               }else{
                Materialize.toast(msg.message, 7000, 'red');
               }
             }
           });
    }));
});


</script>