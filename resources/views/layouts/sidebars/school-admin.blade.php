<div class="profile-usermenu">
    <center><h5>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5></center>
    <center><h6>School Admin</h6></center>
    <ul class="nav">
        <li class="@if(strpos(url()->current(),'school-admin/dashboard')) active @endif nav_tab" id="dashboard">
            <a href="{{url('school-admin/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/subject-category')) active @endif nav_tab" id="overview">
            <a href="{{url('school-admin/subject-category')}}" class="waves-effect"><i class="material-icons">list</i> Subject Categories</span></a>
        </li>
        <!-- <li class="@if(strpos(url()->current(), 'school-admin/grades')) active @endif nav_tab" id="overview">
            <a href="/school-admin/grades" class="waves-effect"><i class="material-icons">location_city</i> Grades</span></a>
        </li> -->
        <li class="@if(strpos(url()->current(), 'school-admin/curriculum')) active @endif nav_tab" id="overview">
            <a href="/school-admin/curriculum" class="waves-effect"><i class="material-icons">school</i> Subjects</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/parents')) active @endif nav_tab" id="overview">
            <a href="/school-admin/parents" class="waves-effect"><i class="material-icons">person</i> Parents</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/manage-parents')) active @endif nav_tab" id="overview">
            <a href="/school-admin/manage-parents" class="waves-effect"><i class="material-icons">person_add</i> Manage Parents</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/teachers')) active @endif nav_tab" id="settings">
            <a href="/school-admin/teachers" class="waves-effect"><i class="material-icons">contacts</i> Teachers </a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/manage-teachers')) active @endif nav_tab" id="settings">
            <a href="/school-admin/manage-teachers" class="waves-effect"><i class="material-icons">contacts</i> Manage Teachers </a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/announcements')) active @endif nav_tab" id="settings">
            <a href="/school-admin/announcements" class="waves-effect"><i class="material-icons">notifications</i>Announcements </a>
        </li>
        <li class="@if(strpos(url()->current(), 'school-admin/settings')) active @endif nav_tab" id="settings">
            <a href="/school-admin/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
        </li>
    </ul>
</div>
