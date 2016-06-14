@extends('layouts.master')

@section('page_title', 'Home')

@section('body_content')

    <section class="index">
        <div class="landing_page">
            <div class="container">
                <div class="tx_holder">
                    <h1 class="tag_1">Video Chat with Teachat</h1><br/>
                    <h2 class="tag_2">Parent Teacher Conference made simple.</h2><br/>
                    <a class="waves-effect btn-large green darker-4" href="/registration">Register</a>
                    <a class="waves-effect btn-large blue darker-4" href="/login">Log in</a>
                </div>
            </div>
        </div>
        <div id="services" class="services blue-grey lighten-5">
            <div class="container">
                <h4>Services</h4>
                <p>Parent Teacher Conference made simple.</p><br/><br/>
                <div class="row">
                    <div class="col s12 m2 l2">
                        <img src="{{asset('images/parent.png')}}" alt="Parent"><br/>
                        <p class="img_desc">Parent</p>
                    </div>
                    <div class="col s12 m3 l3">
                        <ul class="list-inline">
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                        </ul>
                    </div>
                    <div class="col s12 m2 l2">
                        <img src="{{asset('images/video_chat.png')}}" alt="Video Chat"><br/>
                        <p class="img_desc">Video Chat</p>
                    </div>
                    <div class="col s12 m3 l3">
                        <ul class="list-inline">
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                            <li><i class="fa fa-fw fa-circle fa-lg"></i></li>
                        </ul>
                    </div>
                    <div class="col s12 m2 l2">
                        <img src="{{asset('images/teacher.png')}}" alt="Parent"><br/>
                        <p class="img_desc">Teacher</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="about" class="about blue-grey darken-1">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <img src="{{asset('images/videocall-2.png')}}" alt="Video Chat">
                    </div>
                    <div class="col s12 m6 l6">
                        <h5>About Teachat</h5>
                        <p class="lead">Our platform allows you to talk online with your child’s school teacher, access his/her school records and discuss your child’s performance at your own time - wherever you are! No more traffic to deal with. No more missed work.<br/> No more queuing up to see the teacher.<br/> Just login to the school portal at your scheduled time and chat away.</p>
                        <a class="waves-effect btn-large green" href="/registration">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="works" class="how-it-works grey lighten-5">
            <div class="container">
                <h4>HOW IT WORKS</h4>
                <p>Parent Teacher Conference made simple.</p><br/><br/>
                <div class="row">
                    <div class="col s12 m3 l3">
                        <img src="{{asset('images/1.png')}}" alt="Step 1"><br/><br/>
                        <strong>Step 1</strong><br/>
                        <p class="text-muted">Simply register your initial information and wait for confirmation via email.</p>
                    </div>
                    <div class="col s12 m3 l3">
                        <img src="{{asset('images/2.png')}}" alt="Step 1"><br/><br/>
                        <strong>Step 2</strong><br/>
                        <p class="text-muted">Find your school and login to create your profile.</p>
                    </div>
                    <div class="col s12 m3 l3">
                        <img src="{{asset('images/3.png')}}" alt="Step 1"/><br/><br/>
                        <strong>Step 3</strong><br/>
                        <p class="text-muted">Teachers find Parents and schedule the appointment for the video chat.</p>
                    </div>
                    <div class="col s12 m3 l3">
                        <img src="{{asset('images/4.png')}}" alt="Step 1"><br/><br/>
                        <strong>Step 4</strong><br/>
                        <p class="text-muted">On your appointment date and time, start the Video Chat with your teacher from wherever you are.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="why" class="testimonials">
            <div class="row">
                <div class="col s12 m12 l12 testimonial">
                    <h4>Why Parents and Schools Love TeaChat</h4>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m6 l6"><br/>
                                <img src="{{asset('images/parent.jpg')}}" alt="Parents" class="materialboxed" data-caption="Parents">
                            </div>
                            <div class="col s12 m6 l6"><br/>
                                <img src="{{asset('images/teacher.jpg')}}" alt="Teachers" class="materialboxed" data-caption="Teachers">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="container why">
                            <h4>What people think about us</h4>
                            <span class="divider"></span>
                        <br/>
                        <div class="row">
                            <div class="col s12 m4">
                                <div class="item hvr-float">
                                    <p>
                                        "In families where there are multiple children, parents are really involved with first kid, but by the time #2, #3 etc. come around, parents are less likely to be as involved. So having the video option seems brilliant. Way less of a time commitment."
                                    </p><br/>
                                    <h6>-- <span>Liv</span>, Pre-K teacher Alexandria Va </h6>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="item hvr-float">
                                    <p>
                                        "I really believe that many parents need to be more involved in their children's scholastic studies and it seems like "TeaChat" could professionalize the communication between teachers and parents. It will also hold students more accountable in the sense that they are aware of this line of communication between the parent and teacher."
                                    </p>
                                    <h6>-- <span>Mike</span>,  2nd Grade teacher Alexandria Va</h6>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="item hvr-float">
                                    <p>
                                        "I definitely have some conferences that I can think back to where this would have been a great option for parents that were traveling or unable to get out of work. We also have parents from underrepresented groups that often say they just don't feel comfortable attending school events, conferences included."
                                    </p>
                                    <h6>-- <span>Jennifer S</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section col l12" id="index">
        <div class="row">
            <div class="col m4 offset-m4 s6 offset-s3">
                <form action="//teachat.us12.list-manage.com/subscribe/post?u=f90bbbb4a11f3c6d9bada38b7&amp;id=25e89fc8e7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <h5 class="center">Subscribe to our newsletter</h5>
                        <div class="input-group">
                            <div class="mc-field-group">
                                <input type="email" value="" name="EMAIL" class="required email form-control input-lg" id="mce-EMAIL" placeholder="Enter your email">
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-success input-lg" name="subscribe" id="mc-embedded-subscribe" type = "submit">
                                    <i class="material-icons right">mail</i> Subscribe
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_f90bbbb4a11f3c6d9bada38b7_25e89fc8e7" tabindex="-1" value=""></div>
                <!--div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div-->
            </div>
        </div>
    </div>

@stop
