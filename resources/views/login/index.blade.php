@extends('layouts.login')

@section('page_title', 'Login')

@section('body_content')

<div class="container top-margin">
    <div class="row">
        <div class="col s12 push-m2 m10 push-l2 l8">
            <div class="card hoverable">
                <div class="card-image">
                    <img src="{{asset('images/schools/bg.jpg')}}" alt="Plain BG">
                    <span class="card-title">Login to Teachat</span>
                </div>
                <div class="card-content black-text blue-grey lighten-5">
                    <div class="row">



                        <!-- <form class="col s12" id="form-login"> -->
                        {!! Form::open(array('url' => '#', 'class' => 'col s12', 'id' => 'form_login')) !!}

                            <div class="div_notif"></div>
                            <div class="row">
                                <div class="input-field col s12 m12">
                                  <input id="email" type="email" class="validate" required="required" aria-required="true" name="email">
                                  <label for="email" data-error="Invalid">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <input id="password" type="password" required="required" aria-required="true" name="password" minlength="8">
                                    <label for="password">Password</label>
                                </div>
                            </div>
      <!--                       <div class="row">
                                <div class="input-field col s12 m12">
                                    <input type="hidden" required="required" aria-required="true" name="school_id">
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="input-field col s12 m12 l12">
                                    <button class="btn waves-effect btn-large btn-block waves-light" id="btn-login-submit">Login</button>
                                </div>
                                <div class="input-field col s12 m12">
                                    <a href="#forgot_password_modal" class="waves-effect waves-white btn-flat right modal-trigger">Forgot Password</a>
                                </div>
                            </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div id="forgot_password_modal" class="modal forgot_password_modal">
    <div class="modal-content">
        <!-- <form id="forgot_password_form" class="col s12"> -->
        {!! Form::open(array('url' => '#', 'class' => 'col s12', 'id' => 'form_forgot_password')) !!}

            <div class="div_notif"></div>
            <div class="row">
                <h4>Forgot Password?</h4>
                <div class="input-field col s12 m12">
                  <input id="email" type="email" class="validate" required="required" name="email" aria-required="true">
                  <label for="email" data-error="Invalid">Enter Email</label>
                </div>
            </div>

                <div class="input-field col s12 m6 offset-m3">
                    <button class="waves-effect waves-light btn btn-large btn-block deep-orange accent-3" id="btn-reset-password">Reset</button>
                </div>
                <div class="input-field col s12 m12">
                    <a href="#" class="waves-effect waves-white btn-flat modal-action modal-close right freakin-modal">Close</a>
                </div>
            </div>

        {!! Form::close() !!}

    </div>
</div>
@stop

@section('custom-scripts')

    <script type="text/javascript" src="{{asset('teachatv3/login/login.js')}}"></script>


@if(session('account_activated'))
    <script type="text/javascript">

        $(document).ready(function(){
            Materialize.toast('Hooray! Your account is now activated.', 12000);
        });

    </script>
@endif

@if(session('account_activated_already'))

    <script type="text/javascript">

        $(document).ready(function(){
            Materialize.toast('Oops! Your account is already activated.', 12000);
        });

    </script>

@endif
@stop
