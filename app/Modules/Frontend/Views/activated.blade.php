<!DOCTYPE html>
<html>
    <head>
        @section('title_tag')
            <title>Teachat: Success!</title>
            <meta name="robots" content="noindex">
            <meta name="googlebot" content="noindex">
        @stop
        @include('includes.header')
        <style type="text/css">
            .lean-overlay {
                opacity: .1 !important;
            }
        </style>
    </head>

    <body style="background-image: url('{{asset('images/activated_bg.png')}}'); background-repeat: no-repeat; background-size: 100%;">
        <main>
            <div id="congrats" class="modal" style="margin-top: 10%;">
                <div class="modal-content">
                    <center>
                        <h4 style="letter-spacing: 2px;">CONGRATULATIONS!</h4>
                        <p class="flow-text">
                            Welcome to Teachat! Your account was successfully activated.<br/> You will be redirected to login page.
                            Thank you!
                        </p>
                        <small>
                            If you were not redirected automatically, please click link below.<br/>
                            <a href="/login">go to login</a>
                        </small>
                    </center>
                </div>
            </div>
        </main>
    </body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-73718517-1', 'auto');
        ga('send', 'pageview');

        $('#congrats').openModal({dismissible: false});
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function() {
              window.location.href = '/login';
            }, 5000);
        });
    </script>
</html>