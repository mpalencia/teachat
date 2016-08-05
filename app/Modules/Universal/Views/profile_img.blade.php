
  @if($profile[0]['profile_img'] !== 'dp.png')
    <div class="profile-userpic" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $profile[0]['profile_img'] }}')">
  @else
    <div class="profile-userpic" style="background-image: url('{{ asset('/images/profile/dp.png') }}')">
  @endif
  
    <span>
      <form id="form_profile" class="frm_profileUpload">
        <input type="file" class="profile_upload" name="profile_" id="image_input" accept="image/*">
        <span class="hover_dp" onClick="onClickCamera();return;"><i class="fa fa-camera fa-fw fa-2x"></i> Upload Picture</span>
      </form>
    </span>
  </div>
  <div class="profile-usertitle">
    <div class="profile-usertitle-name">
        {{ $profile[0]['first_name'] }} {{ $profile[0]['last_name'] }}
    </div>
    <div class="profile-usertitle-job">
      @if( $profile[0]['role_id'] == 2)
        Teacher
      @else
        Parent
      @endif
    </div>
  </div>

