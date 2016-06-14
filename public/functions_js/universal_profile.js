$(document).ready(function(){
  $('.profile_upload').on('change',function(){
        $('#form_profile').submit();
    });

  $('.nav_').on('change',function(){
        $('#form_profile_nav').submit();
    });

    $('.frm_profileUpload').on('submit',function(e){
      e.preventDefault();
      var param = new FormData(this);
      console.log(param);
      var url = '/profile/v2/process/uploadProfileImage';
        $.ajax({
            type: "POST",
            url: url,
            processData:false,
            contentType:false,
            cache:false,
            data: param,
            success: function (data) {
                var json = $.parseJSON(data);
                $('.profile-userpic').css('background-image','url(' + json.data + ')');
            }
        });
    });

    $('#form_profile_nav').on('submit',function(e){
      e.preventDefault();
      var param = new FormData(this);
      console.log(param);
      var url = '/profile/v2/process/uploadProfileImage';
        $.ajax({
            type: "POST",
            url: url,
            processData:false,
            contentType:false,
            cache:false,
            data: param,
            success: function (data) {
                var json = $.parseJSON(data);
                $('.profile-userpic').css('background-image','url(' + json.data + ')');
            }
        });
    });
});