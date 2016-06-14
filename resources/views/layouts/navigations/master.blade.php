            <!-- Dropdown PH-->
            <nav class="blue-grey darken-4">
                <div class="container">
                    <div class="nav-wrapper">
                        <a href="/" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
                        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li><a class="waves-effect blue-grey darken-2" href="/logout" ><i class="material-icons">power_settings_new</i></a></li>
                        </ul>
                    </div>
                    <!-- Navigation Mobile View -->
                    <ul class="side-nav" id="mobile-demo">
                        <li>
                        </li>
                        <li>
                            <a href="/admin/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                        </li>
                        <li>
                            <a href="/admin/announcements" class="waves-effect"><i class="material-icons">error_outline</i> Announcements</span></a>
                        </li>
                        <li>
                            <a href="/admin/child" class="waves-effect"><i class="material-icons">recent_actors</i> Child </a>
                        </li>
                        <li>
                            <a href="/admin/messages" class="waves-effect"><i class="material-icons">forum</i> Messages </a>
                        </li>
                        <li>
                            <a href="/admin/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i> Appointment </a>
                        </li>
                        <li>
                            <a href="/admin/history" class="waves-effect"><i class="material-icons">toll</i> History </a>
                        </li>
                        <li>
                            <a href="/admin/settings" class="waves-effect"><i class="material-icons">settings</i> Settings </a>
                        </li>
                        <li>
                            <a href="{{url('logout')}}" class="waves-effect blue-grey darken-2"><i class="material-icons">power_settings_new</i> Logout </a>
                        </li>
                    </ul>
                    <!-- /. Navigation Mobile View -->
                </div>
            </nav>
