
    @extends('theme')
    @section('title_tag')
        <title>Contact Us</title>
        <meta name="robots" content="index, follow">
        <meta name="description" content="Contact Teachat for inquiries and other matters with regards to the site."/>
    @stop

    @section('additional_headtag')
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('html_element_captcha', {
                  'sitekey' : '6LefjhMTAAAAAC355zWHmyXeC25tiHhOLNTrQj34'
                });
            };
        </script>
    @stop

    @section('body_content')

        @include('includes.nav-index')

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="col m10 offset-m1">
                        <h4>Contact Us</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div class="row">
                            <div class="col m8">
                                <div id="log" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong id="log_type"></strong> <span id="message_log"></span>
                                </div>
                                <form id="contact-us_submit">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="full_name" type="text" name="full_name" class="validate" required="required">
                                            <label for="full_name">Full Name</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="email" type="email" class="validate" name="email" required="required">
                                            <label for="email">Email Address</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="number" type="text" class="validate" name="contact_no" required="required">
                                            <label for="number">Contact Number</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="city_province" type="text" class="validate" name="city" required="required">
                                            <label for="city_province">City</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea" name="message" required="required"></textarea>
                                            <label for="textarea1">Say Something ...</label>
                                        </div>
                                        <div class="col m7 s12">
                                            <div id='html_element_captcha'></div>
                                        </div>
                                        <div class="col m5 s12">
                                            <div class="form-group">
                                            <button class="btn waves-effect waves-light btn-large btn-block" type="submit">Submit
                                                <i class="material-icons right">send</i>
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col m4">
                                <aside>
                                    <strong>Office - Americas HQ</strong><br/>
                                    <i class="fa fa-fw fa-map-marker"></i>
                                    <span>8000 Towers Crescent Drive,<br/> Suite 1324 <br/>Vienna, VA 22182 USA</span>
                                    <br/>
                                    <i class="fa fa-fw fa-phone"></i>
                                    <span>+1-202-817-5139</span>
                                </aside><br/>
                                <div class="divider"></div><br/>
                                <aside>
                                    <strong>Office - Asia HQ</strong><br/>
                                    <i class="fa fa-fw fa-map-marker"></i>
                                    <span>28th Floor Pacific Star Bldg.,<br/> Makati Ave. corner Buendia Ave., Makati City,<br/>Philippines</span>
                                    <br/>
                                    <i class="fa fa-fw fa-phone"></i>
                                    <span>(632) 822 - 2755</span>
                                </aside><br/>
                                <div class="divider"></div><br/>
                                <aside>
                                    <i class="fa fa-fw fa-envelope"></i>
                                    <span>info<i class="fa fa-at"></i>teachat.co</span>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @stop

    @section('additional_bodytag')
    <script type="text/javascript">
        // The latitude and longitude of your business / place
        var position = [14.561249, 121.026996];
        function showGoogleMaps() {
            var latLng = new google.maps.LatLng(position[0], position[1]);
            var mapOptions = {
                zoom: 16, // initialize zoom level - the max value is 21
                streetViewControl: false, // hide the yellow Street View pegman
                scaleControl: true, // allow users to zoom the Google Map
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: latLng
            };
            map = new google.maps.Map(document.getElementById('googlemaps'),
                mapOptions);
            // Show the default red marker at the location
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: false,
                animation: google.maps.Animation.DROP
            });
        }
        google.maps.event.addDomListener(window, 'load', showGoogleMaps);

        $(document).ready(function(){
            $('#contact-us_submit').submit(function(e){
                e.preventDefault();
                //var param = $(this).serialize();
                var respose = grecaptcha.getResponse();

                if(respose === ''){
                    displayError('Captchat is empty');
                    return false;
                }

                var param = new FormData(this);
                console.log(param);
                var url = "/teachatco/api/v2/email/contact_us";
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
                                grecaptcha.reset();
                                $('#contact-us_submit')[0].reset();
                                displayOK('Message sent.');
                            }else{
                                
                            }
                        }
                    });
            });

            function displayError(msg){
                var error = '<div class="row">'+
                          '<div class="col s12 m12">'+
                            '<div class="card-panel red">'+
                              '<span class="white-text">'+msg+'</span>'+
                            '</div>'+
                          '</div>'+
                        '</div>';
                $('#contact-us_submit .row').append(error);
            }
            function displayOK(msg){
                var success = '<div class="row">'+
                              '<div class="col s12 m12">'+
                                '<div class="card-panel teal">'+
                                  '<span class="white-text">'+msg+'</span>'+
                                '</div>'+
                              '</div>'+
                            '</div>';
                $('#contact-us_submit .row').append(success);
            }
        });
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    @stop