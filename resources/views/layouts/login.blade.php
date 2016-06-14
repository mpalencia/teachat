<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page_title') | Teachat</title>
        <meta name="robots" content="index, follow">
        <meta name="description" content="Login to Teachat! You can login here weather you are a Teacher or A Parent."/>
        @include('layouts.header')
        @include('layouts.teachat-css')
        @include('layouts.teachat-js')
    </head>

    <body>
        <main class="register_page">

            @include('layouts.loader')

            @if(! \Auth::check())

                @include('layouts.navigations.homepage')

            @endif

            @yield('body_content')

        </main>

        @include('layouts.footer')

    </body>

    @yield('custom-scripts')
    <script type="text/javascript" src="{{asset('teachatv3/teachatv3.js')}}"></script>
</html>
