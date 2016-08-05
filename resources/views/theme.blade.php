<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>
    <head>
        @yield('title_tag')

        @include('includes.header')

        @yield('additional_headtag')
    </head>

    <body>
        <main>
            @yield('body_content')
        </main>
        @include('includes.footer')
    </body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-73718517-1', 'auto');
        ga('send', 'pageview');
        $(".button-collapse").sideNav();
        //HTTPS AND HTTP
        /*$(document).ready(function (){
            if (window.location.protocol != "https:") {
                window.location = 'https://' + window.location.hostname + window.location.pathname + window.location.hash;
            }
        });*/
    </script>
    @yield('additional_bodytag')
</html>
