        <!-- Default JS of Teachat-->

        <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script><!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="{{asset('materialize/js/materialize.min.js')}}"></script><!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="{{asset('js/modernizr.js')}}"></script>
        <!-- <script type="text/javascript" src="{{asset('teachatv3/teachatv3.js')}}"></script> -->

        <script type="text/javascript">
            $(document).ready(function() {
                $(".button-collapse").sideNav();
                $(".dropdown-button").dropdown({
                    hover: false,
                    inDuration: 150,
                    belowOrigin: true, // Displays dropdown below the button
                });
            });
        </script>
        <script type="text/javascript">
            $(window).load(function() {
                // Animate loader off screen
                $(".se-pre-con").fadeOut("slow");

            });
        </script>
