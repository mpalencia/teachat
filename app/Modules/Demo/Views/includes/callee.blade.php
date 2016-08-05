<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.6/socket.io.min.js"></script>
<script src="http://10.10.0.195:1338/adapter.js"></script>
<script src="http://10.10.0.195:1338/kurento-utils.js"></script>
<script src="http://10.10.0.195:1338/IncubixSocket.js"></script>

<script type="text/javascript">
    var caller;
    var socket = new IncubixSocket('http://10.10.0.195:1338','Kg9m7QUHVblyaeYAFbXtUVIe','5742b703c60856fc3c688ec3','{{ $user->id }}');
    socket.connect(function(){
        socket.onIncomingCall(function(data){
            caller = data.user_id;
            showIncommingCall(data.user_id);
            $('#ringtoneSignal')[0].play();
        })
    });

    function showIncommingCall(caller){

            $('#incoming_call .online').prop('style','background-image:url('+image+')');
            $('#incoming_call .truncate').html(caller+' is calling..');
            //$('#incoming_call .accept_btn').prop('href','#').attr('onClick','rejectIncommingCall();');
            //$('#incoming_call .btn_reject').attr('onClick','rejectIncommingCall();');
            $('#incoming_call').openModal({
                dismissible: false
            });
        }
    function rejectIncommingCall(){

        socket.accept(function () {
            window.location.href = '/Demo/videoCall/accept/'+caller;
        });
    }

    function functionCall(user){
         socket.call(user,function(){
            socket.onAccept(function(){
                 window.location.href = '/Demo/videoCall/call/'+user;
            });
        });
    }
</script>
