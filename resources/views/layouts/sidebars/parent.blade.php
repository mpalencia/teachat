                <div class="profile-usermenu">
                                <ul class="nav">
                                    <li class="@if(strpos(url()->current(),'parent/dashboard')) active @endif nav_tab" id="dashboard">
                                        <a href="{{url('parent/dashboard')}}" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'parent/child')) active @endif nav_tab" id="overview">
                                        <a href="{{url('parent/child')}}" class="waves-effect"><i class="material-icons">person_add</i> Children</span></a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'parent/videochat')) active @endif nav_tab" id="overview">
                                        <a href="/parent/videochat" class="waves-effect"><i class="material-icons">room</i> Video Chat</span></a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'parent/appointments')) active @endif nav_tab" id="settings">
                                        <a href="/parent/appointments" class="waves-effect"><i class="material-icons">contacts</i>Appointments </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'parent/announcements')) active @endif nav_tab" id="settings">
                                        <a href="/parent/announcements" class="waves-effect"><i class="material-icons">contacts</i>Announcements </a>
                                    </li>
                                    <li class="@if(strpos(url()->current(), 'parent/history')) active @endif nav_tab" id="settings">
                                        <a href="/parent/history" class="waves-effect"><i class="material-icons">contacts</i>History </a>
                                    </li>
                                </ul>
                            </div>
