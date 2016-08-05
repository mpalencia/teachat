<script src="{{ asset('functions_js/incubixSocket.js') }}"></script>
<script type="text/javascript">

        var socket = new IncubixSocket('https://floox.com','pb9PsESMdOApPlrNDuhXiQX1','570c65afd87694a60e12211b','{{ $user }}');

        socket.call();
    </script>