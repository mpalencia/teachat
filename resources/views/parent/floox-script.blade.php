<!-- Modal Structure -->
<div id="modal_messageModal" class="modal">
    <div class="modal-content">
        <h5 align="center" id="modal_messageHeader">Modal Header</h5>
        <p align="center" id="modal_messageText">A bunch of text</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat red white-text">close</a>
        <a href="{{url('parent/messages')}}" class="waves-effect waves-green btn-flat green white-text left">go to messages</a>
    </div>
</div>
<input type="hidden" id="user_id" value="{{\Auth::user()->id}}">
<script type="text/javascript">
	<?php
$appointments_today = Teachat\Models\Appointments::with(['teacher'])->where(['parent_id' => \Auth::user()->id, 'appt_date' => Carbon\Carbon::now()->toDateString()])->orderBy('appt_date', 'ASC')->get()->toArray();

$teachers = \DB::table('users')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.profile_img', 'students.parent_id', 'students.teacher_id', 'students.school_id')
            ->leftJoin('students', 'users.id', '=', 'students.teacher_id')
            ->orderBy('users.first_name')
            ->where(['users.role_id' => 2, 'students.parent_id' => \Auth::user()->id])
            ->groupBy('students.teacher_id')
            ->get();

?>

	var flooxParams = {
    	accessToken:"JZu7WnX14jA1z0M7ytaf43xc",
    	appID:"5799b1d7ef84b7801e10e94e",
    	userID:$('#user_id').val()
    };
    var floox = new Floox(flooxParams);
    floox.connect(function(){

    	var arrayOfUserId = [];
        //PHP CODE//
        @foreach($appointments_today as $app)
            arrayOfUserId.push("{{ $app['teacher_id'] }}");
        @endforeach

        @foreach($teachers as $t)
            arrayOfUserId.push("{{ $t->id }}");
        @endforeach

        //PHP CODE//

        floox.getLoggedInUsers(arrayOfUserId, function(users){
            for (var i = users.length - 1; i >= 0; i--) {
                $('.video_'+users[i].user_id).removeClass('offline');
                $('.video_'+users[i].user_id).removeClass('disabled');
                $('#'+users[i].user_id+' .contact_status').html('<i class="fa fa-fw fa-circle online"></i> <span class="textStatus">Online</span>');
            }
        });

        floox.subscribeToUsers(arrayOfUserId);

        floox.onUserStateChange(function(user, state){
            console.log(state);
            switch(state) {
                case Floox.States.UserStates.LOGGED_IN:
                    $('.video_'+user.user_id).removeClass('offline');
                    $('.video_'+user.user_id).removeClass('disabled');
                    $('#'+user.user_id+' .contact_status').html('<i class="fa fa-fw fa-circle online"></i> <span class="textStatus">Online</span>');
                break;
                case Floox.States.UserStates.LOGGED_OUT:
                    $('.video_'+user.user_id).addClass('offline');
                    $('.video_'+user.user_id).addClass('disabled');
                    $('#'+user.user_id+' .contact_status').html('<i class="fa fa-fw fa-circle offline"></i> <span class="textStatus">Offline</span>');
                break
            }
        });

        //VARIABLE FOR SESSION
        var session = '';

    	floox.onCallStateChange(function(state, data){
            console.log(state);
            console.log(data);
            switch(state) {
                case Floox.States.CallStates.RINGING:
                    $('#incoming_call .truncate').html(data.data.additional_data.first_name+' '+data.data.additional_data.last_name);
                    $('#incoming_call').openModal({
                        dismissible: false
                    });
                break;
                case Floox.States.CallStates.CALLING:
                    session = data.session;
                    $('.calling .truncate').html(data.data.additional_data.first_name+' '+data.data.additional_data.last_name);
                    $('.calling').openModal({
                        dismissible: false
                    });
                break;
                case Floox.States.CallStates.REJECTED:
                    $('.calling').closeModal();
                    $('#incoming_call').closeModal();
                    alert("CALL HAS BEEN REJECTED");
                break;
                case Floox.States.CallStates.CANCELLED:
                    $('.calling').closeModal();
                    $('#incoming_call').closeModal();
                    alert("CALL HAS BEEN CANCELLED");
                break;
                case Floox.States.CallStates.ACCEPTED:
                	console.log(data);
                	$('.calling').closeModal();
                	$('#incoming_call').closeModal();
                	window.location.href="{{url('/')}}/parent/videocall/"+data.userType+"/"+$('#user_id').val()+"/"+data.session;

                break;
                case Floox.States.CallStates.USER_OFFLINE:

                break;
            }
        });

        $('.callTeacher').click(function(){
            floox.call($(this).attr('data-teacher-id'));

        });

        $('.accept_btn').click(function(){
          floox.accept();
        });

        $('.btn_reject').click(function(){
          floox.reject();
        });

        $('.btn_cancel').click(function(){
          floox.cancelCall(session);
        });

        floox.messageReceived(function(data){
            if(window.location.pathname == '/parent/messages'){
                showMessage(data, true);
            } else {
                //$('#modal_messageHeader').html('Message from ' + data.from);
                //$('#modal_messageText').html(data.message);
                //$('#modal_messageModal').openModal();
                console.log(data);
                $('#messages').empty();
                var message = '';
                var createdAt = formatAMPM(new Date(data.createdAt));
                message += '<li class="collection-item avatar"><a href="/parent/messages"><span class="title truncate">'+data.from.additional_data.first_name+' '+data.from.additional_data.last_name+'</span><p class="truncate">'+data.message+'</p><small>'+createdAt+'</small></a></li>';
                $('#messages').append(message);
                $('#message_unread').removeClass('hide');
            }
        });

        floox.onNotificationReceived(function(data){

        });

        floox.getNotifications(null, null, null, null, function(data){
            var data = '';
            for(i=0;i<data.length;i++){
                data += '<li class="collection-item avatar"><span class="title truncate">'+data.name+'</span><p class="truncate">'+data.message+'</p><small>'+data.createdAt+'</small></li>';
            }
            $('#messages').append(data);
        });
    });

    function formatAMPM(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = month + '-' + day + '-' + year + '@' + hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }

    $(document).ready(function(){
        $('#message_notifier').click(function(){
            $('#message_unread').addClass('hide');
        });
    });
</script>