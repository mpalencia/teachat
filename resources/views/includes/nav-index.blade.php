    <div class="se-pre-con">
        <div id="loader"></div>
        <div id="txt">Loading ...</div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- Dropdown -->
    <ul id="dp_started" class="dropdown-content">
        <li><a href="/login" class="modal-trigger">Log in</a></li>
        <li><a href="/registration">Register</a></li>
    </ul>
    <ul id="dp_started_m" class="dropdown-content">
        <li><a href="/login" class="modal-trigger">Log in</a></li>
        <li><a href="/registration">Register</a></li>
    </ul>
    <?php
        if(\Auth::check()){
            switch (\Auth::user()->role_id) {
                case 1:
                    $role_type = 'admin';
                    break;

                case 2:
                    $role_type = 'teacher';
                    break;

                case 3:
                    $role_type = 'parent';
                    break;

                case 4:
                    $role_type = 'school-admin';
                    break;
            }
        }
    ?>

    <!-- Dropdown -->
    <nav class="blue-grey darken-4">
        <div class="container">
            @if(\Auth::check())
            <div class="nav-wrapper">
                <a href="{{$role_type}}/dashboard" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

                <ul class="right" id="mobile-demo">
                    <li class="hide-on-med-and-down"><a href="{{$role_type}}/dashboard" class="waves-effect"><i class="material-icons">dashboard</i></a></li>
                    <li class="hide-on-med-and-down"><a href="javascript:void(0)" class="waves-effect help-toggle"><i class="material-icons">help_outline</i></a></li>
                    <li><a class="waves-effect blue-grey darken-2" href="/logout" ><i class="material-icons">power_settings_new</i></a></li>
                </ul>
            </div>
            @else
            <div class="nav-wrapper">
                <a href="/" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat.co"></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <!-- <li><a href="/#services">Services</a></li> -->
                    <li><a href="/#works">How it works</a></li>
                    <li><a href="/#about">About</a></li>
                    <li><a href="/#why">Why Teachat?</a></li>
                    <li><a class="dropdown-button waves-effect blue-grey darken-2" href="#" data-activates="dp_started">Get Started</a></li>
                </ul>
            </div>
            <!-- Navigation Mobile View -->
            <ul class="side-nav" id="mobile-demo">
                <!-- <li><a href="/#services">Services</a></li> -->
                <li><a href="/#works">How it works</a></li>
                <li><a href="/#about">About</a></li>
                <li><a href="/#why">Why Teachat?</a></li>
                <li><a class="dropdown-button waves-effect blue-grey darken-2" href="#" data-activates="dp_started_m">Get Started</a></li>
            </ul>
            <!-- /. Navigation Mobile View -->
            @endif


        </div>
    </nav>