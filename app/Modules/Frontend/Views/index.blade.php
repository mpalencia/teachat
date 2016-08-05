
    @extends('theme')
    @section('title_tag')
        <title>Teachat: Parent-Teacher Conference</title>
        <link rel="canonical" href="https://dev2.teachat.co/"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}" media="print">
        <meta property="og:title" content="Welcome to Teachat"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="https://dev2.teachat.co/"/>
        <meta property="og:image" content="{{asset('images/teachat_og.png')}}"/>
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="315" />
        <meta property="og:site_name" content="TEACHAT"/>
        <meta name="twitter:title" content="Welcome to Teachat"/>
        <meta name="twitter:image" content="{{asset('images/teachat_og.png')}}"/>
        <meta name="twitter:url" content="https://dev2.teachat.co/"/>
        <meta name="twitter:site" content="https://dev2.teachat.co/"/>
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:description" content="The best teacher-parent conference online. Teachat allows you to talk online with your child’s school teacher,  and discuss your child’s performance." />
        <meta name="robots" content="index, follow">
        <meta name="description" content="The best teacher-parent conference online. Teachat allows you to talk online with your child’s school teacher,  and discuss your child’s performance."/>
    @stop

    @section('additional_headtag')
        <!-- Mail Chimp -->
        <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
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

        <section class="index">
            <div class="landing_page">
                <div class="container">
                    <div class="tx_holder">
                        <h1 class="tag_1">Video Chat with Teachat</h1><br/>
                        <h2 class="tag_2">Parent Teacher Conference made simple.</h2><br/>
                        <a class="waves-effect btn-large green darker-4" href="/registration">Register</a>
                        <a class="waves-effect btn-large blue darker-4" href="/login">Log in</a><br/>
                        <a class="waves-effect btn-large teal darker-4" href="/add-my-school">Add My School</a>
                    </div>
                </div>
            </div>
            <div id="works" class="how-it-works grey lighten-5">
                <div class="container">
                    <h4>HOW IT WORKS</h4>
                    <h5>Parent Teacher Conference made simple.</h5><br/><br/>
                    <div class="row">
                        <div class="col s12 m3 l2">
                            <img src="{{asset('images/how/register.png')}}" alt="Step 1"><br/><br/>
                        </div>
                        <div class="col s12 m3 l3 left-align"><br/>
                            <strong>1. REGISTER</strong>
                            <h6 class="green-text">Teacher</h6>
                            <p>Your profile is created when your school enrolls in Teachat</p>
                            <h6 class="blue-text">Parent</h6>
                            <p>Register through TeacChat and confirm via email</p>
                        </div>
                        <div class="col s12 m3 l2">
                            <img src="{{asset('images/how/login.png')}}" alt="Step 2"><br/><br/>
                        </div>
                        <div class="col s12 m3 l3 left-align"><br/>
                            <strong>2. LOGIN</strong>
                            <h6 class="green-text">Teacher</h6>
                            <p>Select your school on the TeaChat site and login.</p>
                            <h6 class="blue-text">Parent</h6>
                            <p>Register through TeaChat and confirm via email</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m3 l2 offset-l2">
                            <img src="{{asset('images/how/calendar.png')}}" alt="Step 3"><br/><br/>
                        </div>
                        <div class="col s12 m3 l3 left-align"><br/>
                            <strong>3. SCHEDULE</strong>
                            <h6 class="green-text">Teacher</h6>
                            <p>List available call hours and/or send invites to parents</p>
                            <h6 class="blue-text">Parent</h6>
                            <p>request a call and view call invites from teachers</p>
                        </div>
                        <div class="col s12 m3 l2">
                            <img src="{{asset('images/how/videochat.png')}}" alt="Step 4"><br/><br/>
                        </div>
                        <div class="col s12 m3 l3 left-align"><br/>
                            <strong>4. VIDEO CHAT</strong>
                            <h6 class="green-text">Teacher</h6>
                            <p>Select your school on the TeaChat site and login.</p>
                            <h6 class="blue-text">Parent</h6>
                            <p>Register through TeaChat and confirm via email</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="about" class="about blue-grey darken-1">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12 center-align">
                            <h5>About Teachat</h5>
                            <p class="lead">Our platform allows you to talk online with your child’s school teacher, access his/her school records and discuss your child’s performance at your own time - wherever you are! No more traffic to deal with. No more missed work.<br/> No more queuing up to see the teacher.<br/> Just login to the school portal at your scheduled time and chat away.</p>
                            <a class="waves-effect btn-large green" href="/registration">Register</a>
                        </div>
                        <div class="col s12 m12 l8 offset-l2 center-align">
                            <img src="{{asset('images/ipad.png')}}" alt="ipad">
                        </div>
                    </div>
                </div>
            </div>
            <div id="features" class="features">
                <div class="container">
                    <h4>Features</h4>
                    <p>
                        At its core TeaChat is a communications platform to facilitate and increase important information flow between Teachers and Parents. However, we thought why not add a few more features to make TeaChat an even more powerful and convinient tool.
                    </p><br/>
                    <div class="row">
                        <div class="col l4 m4 s12">
                            <img src="{{asset('images/features/web-development.png')}}" alt="features-img">
                            <h5>School Dashboard</h5>
                            <p class="lead">
                                In order for parent to stay up to date, we have created a school dashboard. This allows schools to share relevant news, updates and reminders for important events.
                            </p>
                        </div>
                        <div class="col l4 m4 s12">
                            <img src="{{asset('images/features/month-calendar.png')}}" alt="features-img">
                            <h5>Personalized Calendar</h5>
                            <p class="lead">
                                Teachers can share available time slots, organize meetings, and sen parents invites. Parents can request for a conference and review upcoming appointments.
                            </p>
                        </div>
                        <div class="col l4 m4 s12">
                            <img src="{{asset('images/features/video-call.png')}}" alt="features-img">
                            <h5>Communication Options</h5>
                            <p class="lead">
                                We feel that video calls are the best. Audio calls and chats are also available as backups, and offer preferential levels of communication.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l4 offset-l2 m4 offset-m2 s12">
                            <img src="{{asset('images/features/message-bubble.png')}}" alt="features-img">
                            <h5>Messaging & Reminders</h5>
                            <p class="lead">
                                Parents and teachers can send each-other instant messages to the platform. Further more we allow teachers to send one-way reminders to entire classrooms. E-mail notifications will be forwarded and in the app-version, the user will be engaged through push-notifications.
                            </p>
                        </div>
                        <div class="col l4 m4 s12">
                            <img src="{{asset('images/features/cloud-upload-signal.png')}}" alt="features-img">
                            <h5>Secure Data Transmission</h5>
                            <p class="lead">
                                Teachers can share student work and classroom documents with parents safely and securely. Parents have full access to their child’s documents in the cloud. Data transmission is protected through 256-bit SSL encryption.
                            </p>
                            <small class="green-text">* Optional: Available when in compliance with legislation concerning student data and parental consent</small>
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

    @section('additional_bodytag')
    <!-- Mail Chimp -->
    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
    <script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script><!-- /. Mail Chimp -->
    <script type="text/javascript">
        $('.materialboxed').materialbox();
    </script>
    @stop