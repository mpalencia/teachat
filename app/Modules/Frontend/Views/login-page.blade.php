<!DOCTYPE html>
<html>
    <head>
        @include('includes.header')
    </head>

    <body class="">
        <main class="register_page">

            @include('includes.nav-index')

            <div class="container top-margin">
                <div class="row">
                    <div class="col s12 push-m2 m10 push-l2 l8">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img src="{{asset('images/schools')}}/{{ $school[0]['school_logo'] }}">
                                <span class="card-title">Login to {{ $school[0]['school_name'] }}</span>
                            </div>
                            <div class="card-content black-text blue-grey lighten-5">
                                <div class="row">
                                    <form class="col s12" id="frm_login">
                                        <div class="div_notif">
                                            
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                              <input id="email" type="email" class="validate" required="required" aria-required="true" name="email">
                                              <label for="email" data-error="wrong" data-success="right">Email</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <input id="password" type="password" required="required" aria-required="true" name="password">
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <input type="hidden" required="required" aria-required="true" name="school_id" value="{{ $school[0]['id'] }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l12">
                                                <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Login</button>
                                            </div>
                                            <div class="input-field col s12 m12">
                                                <a href="#forgot_password_modal" class="waves-effect waves-white btn-flat right modal-trigger">Forgot Password</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Forgot Password Modal -->
            <div id="forgot_password_modal" class="modal" data-backdrop="static">
                <div class="modal-content">
                    <form id="forgot_password_form" class="col s12">
                        <div class="row">
                            <h4>Forgot Password?</h4>
                            <div class="input-field col s12 m12">
                              <input id="email" type="email" class="validate" required="required" name="email" aria-required="true">
                              <label for="email" data-error="wrong" data-success="right">Enter Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 offset-m3">
                                <button class="waves-effect waves-light btn btn-large btn-block deep-orange accent-3" type="submit" name="action">Reset</button>
                            </div>
                            <div class="input-field col s12 m12">
                                <a href="#forgot_password_modal" class="waves-effect waves-white btn-flat modal-action modal-close right">Close</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="div_notif_reset">
                                            
                </div>
            </div>
        </main>
    </body>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".button-collapse").sideNav();
            $(".dropdown-button").dropdown({
                hover: false,
                inDuration: 150,
                belowOrigin: true, // Displays dropdown below the button
            });

            $('#frm_login').on('submit',function(e){
                $('.card').append(loader);
                $(this).find(':submit').attr('disabled','disabled');
                e.preventDefault();
                    var param = new FormData(this);
                    var url = '/login/v2/process/login';
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
                                $('.div_notif').html('<ul class="input-field col s12 m12 green lighten-2 white-text ul_notif">'+
                                                        '<li>'+
                                                           '<h6><i class="material-icons tiny">check</i> '+json.message+'</h6>'+
                                                        '</li>'+
                                                    '</ul>');
                                window.location.href = "/Dashboard";
                            }else{
                                $('#frm_login').find(':submit').removeAttr('disabled');
                                $('.div_notif').html('<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif">'+
                                                        '<li>'+
                                                           ' <h6><i class="material-icons tiny">error_outline</i> '+json.message+'</h6>'+
                                                        '</li>'+
                                                    '</ul>');
                            }
                            $('.card').find('.progress').remove();
                        }
                    });
            });

            $('#forgot_password_form').on('submit',function(e){
                 $('#forgot_password_modal').append(loader);
                $(this).find(':submit').attr('disabled','disabled');
                e.preventDefault();
                    var param = new FormData(this);
                    var url = '/password/reset';
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
                                $('.div_notif_reset').html('<ul class="input-field col s12 m12 green lighten-2 white-text ul_notif">'+
                                                        '<li>'+
                                                           '<h6><i class="material-icons tiny">check</i> '+json.message+'</h6>'+
                                                        '</li>'+
                                                    '</ul>');
                                //window.location.href = "/Dashboard";
                            }else{
                                $('#forgot_password_form').find(':submit').removeAttr('disabled');
                                $('.div_notif_reset').html('<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif">'+
                                                        '<li>'+
                                                           ' <h6><i class="material-icons tiny">error_outline</i> '+json.message+'</h6>'+
                                                        '</li>'+
                                                    '</ul>');
                            }
                            $('#forgot_password_modal').find('.progress').remove();
                        }
                    });
            })

            var loader = '<div class="progress">'+
                                  '<div class="indeterminate"></div>'+
                            '</div>';
            
        });
    </script>
</html>