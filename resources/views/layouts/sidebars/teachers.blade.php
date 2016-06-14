                <div class="profile-usermenu">
                                <ul class="nav">
                                    <li class="@if(strpos(url()->current(),'teacher/dashboard')) active @endif nav_tab" id="dashboard">
                                        <a href="{{url('teacher/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/students')) active @endif nav_tab" id="overview">
                                        <a href="{{url('teacher/students')}}" class="waves-effect"><i class="material-icons">person_add</i> Students</span></a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/subjects')) active @endif nav_tab" id="overview">
                                        <a href="/teacher/subjects" class="waves-effect"><i class="material-icons">location_city</i> Subjects</span></a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/parents')) active @endif nav_tab" id="overview">
                                        <a href="/teacher/parents" class="waves-effect"><i class="material-icons">room</i> Video Chat</span></a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/appointments')) active @endif nav_tab" id="settings">
                                        <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">contacts</i>Appointments </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/announcements')) active @endif nav_tab" id="settings">
                                        <a href="/teacher/announcements" class="waves-effect"><i class="material-icons">contacts</i>Announcements </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'teacher/history')) active @endif nav_tab" id="settings">
                                        <a href="/teacher/history" class="waves-effect"><i class="material-icons">contacts</i>History </a>
                                    </li>
                                </ul>
                            </div>
