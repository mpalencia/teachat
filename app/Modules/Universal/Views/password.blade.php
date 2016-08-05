
    <form class="col s12" id="frm_settings_changePassword">
        <div class="input-field col s12">
            <input id="cureent_password" type="password" required="" aria-required="true" name="current_pass">
            <label for="icon_prefix">Current Password</label>
        </div>
        <div class="input-field col s6">
            <input id="new_password" type="password" required="" aria-required="true" min="8" name="new_pass">
            <label for="icon_prefix">New Password</label>
        </div>
        <div class="input-field col s6">
            <input id="re_password" type="password" required="" aria-required="true" min="8" name="confirm_pass">
            <label for="icon_prefix">Confirm Password</label>
        </div>
        <div class="input-field col s12 m4">
            <button class="btn waves-effect btn-large btn-block waves-light" type="submit" >Save</button>
        </div>
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#frm_settings_changePassword').on('submit',function(e){
                var param = new FormData(this);
                var url = "/settings/v2/process/changePassword";
                e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: url,
                        processData:false,
                        contentType:false,
                        cache:false,
                        data: param,
                        success: function (data) {
                            var json = $.parseJSON(data);
                            if(json.code == 1){
                                successToast(json.message);
                                $('#frm_settings_changePassword')[0].reset();
                            }else{
                                errorToast(json.message);
                            }
                        }
                    });
            });
        });

        function errorToast(message){
            Materialize.toast(''+message+'', 5000, 'red');
        }

        function successToast(message){
            Materialize.toast(''+message+'', 5000, 'green');
        }
    </script>