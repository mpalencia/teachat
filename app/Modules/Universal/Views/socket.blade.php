<script type="text/javascript">
var OnlineUsersID;
  $(document).ready(function(){
      loadlink();
       var host = "wss://ikonsulta.com:8080";
       var ws = new WebSocket(host);
       ws.onmessage = function (event) {
         console.log(event.data);
          OnlineUsersID = event.data;
          //statusChanger(event.data);
         //update the doctors to online status
         $.ajax({
                       type: "GET",
                       url: "https://dev2.teachat.co/user/v2/status/{{ $profile[0]['qbUserId'] }}/1",
                       //data: {},
                       cache: false,
                       success: function(data){
                               console.log(data);
                               alert(data);
                       }
               });

       }
       ws.onopen = function () {
         ws.send("{{ $profile[0]['qbUserId'] }}~dev2.teachat.co");
       };

  });

  function statusChanger(data){
      qb.broadcastMessage("{{ $profile[0]['qbUserId'] }}",data);
  }

  function loadlink(){
      $.ajax({
             type: "GET",
             url: "/user/v2/getUsersStatus",
             //data: {},
             cache: false,
             success: function(data){
                var json = JSON.parse(data);
                for(i = 0; i < json.length; i++){
                  if(json[i].active == 0){
                    //alert(json[i].qbUserId);
                    $('#'+json[i].qbUserId+' .contact_status').find('.fa-circle').removeClass('online').addClass('offline');
                    $('#'+json[i].qbUserId+' .contact_status').find('.textStatus').html('Offline');
                    $('#'+json[i].qbUserId+' .userProfileimg').removeClass('online').addClass('offline');

                    //alert(receivedMessage.extension.user);
                    $('.appt_class').each(function(index){
                      $(this).find('#'+json[i].qbUserId+' .material-icons').removeClass('online');
                      var id = $(this).find('a').attr('id');
                      //$(this).find('a').attr('onClick','timerCheckerRedirectVideoChat('+id+' , '+$(this).parent('div').attr('id')+');');
                    });
                  }
                }
             }
      });
  }

   // This will run on page load
  setInterval(function(){
      loadlink() // this will run after every 5 seconds
  }, 10000);



  </script>