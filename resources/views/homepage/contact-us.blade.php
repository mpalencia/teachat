@extends('layouts.master')

@section('page_title', 'Contact Us')

@section('body_content')
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

                            {!! Form::open(array('url' => '#', 'class' => 'col s12', 'id' => 'form_contact_us')) !!}

                                <div class="div_notif"></div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="full_name" type="text" name="full_name" class="validate" required="required">
                                        <label for="full_name">Full Name</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="email" type="email" class="validate" name="email_user" required="required">
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
                            {!! Form::close() !!}
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
@section('custom-scripts')

    <script type="text/javascript" src="{{asset('teachatv3/contact-us/contact-us.js')}}"></script>

@stop
