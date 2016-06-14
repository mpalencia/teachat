<!DOCTYPE html>
<html>
    <head>

        @include('layouts.header')
        @include('layouts.teachat-css')
        @include('layouts.teachat-js')
    </head>

    <body>
        <main>
            @include('layouts.loader')
            @if(! \Auth::check())
                @include('layouts.navigations.homepage')
            @else
                @include('layouts.navigations.master')
            @endif
<div class="container">
                <div class="row profile">
                    <div class="col s12 m12 l3 hide-on-med-and-down">
                        <div class="profile-sidebar">
                            @if(\Auth::user()->role_id == 1)

                            @elseif(\Auth::user()->role_id == 2)

                            @include('layouts.sidebars.teachers')

                            @elseif(\Auth::user()->role_id == 3)

                            @include('layouts.sidebars.parent')

                            @else

                            @include('layouts.sidebars.school-admin')

                            @endif
                        </div>
                    </div>
                    <div class="col s12  m12 l9">
                        @yield('body_content')
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.footer')
    </body>

    @yield('custom-scripts')
    <script type="text/javascript" src="{{asset('teachatv3/teachatv3.js')}}"></script>

</html>
