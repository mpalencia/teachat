<div class="profile-usermenu">
    <ul class="nav">
        <li class="@if(strpos(url()->current(),'admin/dashboard')) active @endif nav_tab" id="dashboard">
            <a href="{{url('admin/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard</a>
        </li>
        <li class="@if(strpos(url()->current(),'admin/location')) active @endif nav_tab" id="location">
            <a href="{{url('admin/location')}}" class="waves-effect"><i class="material-icons">room</i> Manage Locations</a>
        </li>
        <li class="@if(strpos(url()->current(), 'admin/schools')) active @endif nav_tab" id="overview">
            <a href="{{url('admin/schools')}}" class="waves-effect"><i class="material-icons">location_city</i> Manage Schools</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'admin/school-admin')) active @endif nav_tab" id="overview">
            <a href="{{url('admin/school-admin')}}" class="waves-effect"><i class="material-icons">person_add</i> Manage School Admins</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'admin/teachers')) active @endif nav_tab" id="overview">
            <a href="{{url('admin/teachers')}}" class="waves-effect"><i class="material-icons">contacts</i> Manage Teachers</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'admin/parents')) active @endif nav_tab" id="overview">
            <a href="{{url('admin/parents')}}" class="waves-effect"><i class="material-icons">contacts</i> Manage Parents</span></a>
        </li>
        <li class="@if(strpos(url()->current(), 'admin/settings')) active @endif nav_tab" id="overview">
            <a href="{{url('admin/settings')}}" class="waves-effect"><i class="material-icons">settings</i> Settings</span></a>
        </li>
    </ul>
</div>
