@extends('layouts.login')

@section('page_title', 'Registration')

@section('body_content')
    <div class="container top-margin">
        <div class="row">
            <div class="col s12 push-m2 m10 push-l2 l8">
                <div class="card hoverable">
                    <div class="card-image">
                        <img src="{{asset('images/schools/bg.jpg')}}">
                        <span class="card-title">Register</span>
                    </div>
                    <div class="card-content black-text blue-grey lighten-5">
                        <div class="row">

                            <form class="col s12 form_registration" id="form_registration">
                                <div class="row">
                                    <div class="input-field col l6 m6 s12">
                                        <select class="icons" required="required" aria-required="true" name="role_id" id="role_id">
                                            <option value="3" data-icon="{{asset('images/img_parent.png')}}" class="left circle">Parent</option>
                                            <option value="2" data-icon="{{asset('images/img_teacher.png')}}" class="left circle">Teacher</option>
                                        </select>
                                        <label>Choose type</label>
                                    </div>
                                    <div class="input-field col l6 m6 s12">
                                        <select required="" aria-required="true" name="gender">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="input-field col l3 m3 s12">
                                        <select required="" aria-required="true" name="title">
                                            <option value="" disabled selected>Select Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                    <div class="input-field col l3 m3 s12">
                                        <input id="f_name" type="text" class="validate" required="" aria-required="true" name="first_name">
                                        <label for="f_name">First Name</label>
                                    </div>
                                    <div class="input-field col l3 m3 s12">
                                        <input id="m_name" type="text" name="middle_name">
                                        <label for="m_name">Middle Name (Optional)</label>
                                    </div>
                                    <div class="input-field col l3 m3 s12">
                                        <input id="l_name" type="text" class="validate" required="" aria-required="true" name="last_name">
                                        <label for="l_name">Last Name</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input type="text" id="address_one" name="address_one" class="validate" required="" aria-required="true">
                                        <label for="address_one">Address 1</label>
                                    </div>

                                    <div class="input-field col s12 m12">
                                        <input type="text" id="address_two" name="address_two">
                                        <label for="address_two">Address 2 (Optional)</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <select id="country_id" class="icons" required="required" aria-required="true" name="country_id" onchange="changeCountry(this)">
                                            <option value="" disabled selected>Select Country</option>
                                            @foreach($country as $c)
                                                <option value="{{$c['id']}}">{{$c['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label>Choose Country</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select id="state_id" class="icons" required="required" aria-required="true" name="state_id">
                                            <option value="" disabled selected>Select State/Province</option>
                                           
                                        </select>
                                        <label>Choose State/Province</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="zip_code" type="text" class="validate" name="zip_code">
                                        <label for="zip_code">Zip Code</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <input id="city" type="text" class="validate" required="required" aria-required="true" name="city">
                                        <label for="city">City/Town</label>
                                    </div>
                                    <div class="input-field col s12 m12" id="select_school_id">
                                        <select id="school_id" class="icons" aria-required="true" name="school_id">
                                          <option value="" disabled selected>Select School</option>
                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input id="contact_mobile" type="text" class="validate" required="" aria-required="true" name="contact_cell">
                                        <label for="contact_mobile">Contact Mobile</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="contact_home" type="text" name="contact_home">
                                        <label for="contact_home">Contact Home (Optional)</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="contact_work" type="text" name="contact_work">
                                        <label for="contact_work">Contact Work (Optional)</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="email" type="email" class="validate" required="" aria-required="true" name="email">
                                        <label for="email" data-error="Invalid" data-success="Valid">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input id="password" type="password" required="" aria-required="true" name="password">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input id="confirm_password" type="password" required="" aria-required="true" name="password_confirmation">
                                        <label for="confirm_password">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m3">
                                        <input type="checkbox" name="agree" class="filled-in" id="terms" required="required" aria-required="true">
                                        <label for="terms">I Agree</label>
                                    </div>
                                    <div class="input-field col s12 m9">
                                        Do you agree to the Teachat <a href="#termscondition" onclick="termscondition()">Terms and Conditions</a> set out by this site, including our Cookie Use?
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m5 l4">
                                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Register
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                   <!--  <div class="input-field col s12 m5 l4">
                                        <a href="/" class="btn waves-effect btn-large btn-block waves-light red hide cancel">Close</a>
                                    </div> -->
                                </div>
                                <p>Have an account? <a href="/login">LOGIN</a> here.</p>
                                <div class="div_notif notif"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Terms and Condition Modal-->

<div class="modal fade" id="termscondition" tabindex="-1" role="dialog" aria-labelledby="termsconditionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
            </div>
            <div class="modal-body">
                
                <div class="container terms">
                <h4>Terms of Use</h4>
                <span class="divider"></span>
                <div class="divider"></div>
                <ol>
                <li>
                    <strong>Acceptance The Use Of TeaChat Terms and Conditions</strong><br/>
                    Your access to and use of TeaChat is subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using the Website you are fully accepting the terms, conditions and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.
                </li>
                <li>
                    <strong>CREDIT CARD DETAILS</strong><br/>
                    TeaChat will never ask for your credit card details and we advice our customers to not enter their credit cards details on TeaChat website or by submitting such details in any other form.
                </li>
                <li>
                    <strong>LEGAL ADVICE</strong><br/>
                    The contents of TeaChat website do not constitute advice and should not be relied upon in making or refraining from making, any decision.<br/>
                    All material contained on TeaChat is provided without any or warranty of any kind. You use the material on TeaChat at your own discretion
                </li>
                <li>
                    <strong>CHANGE OF USE</strong><br/>
                    TeaChat reserves the right to:
                    <ul>
                        <li>4.1. change or remove (temporarily or permanently) the Website or any part of it without notice and you confirm that TeaChat shall not be liable to you for any such change or removal and</li>
                        <li>4.2. change or remove (temporarily or permanently) the Website or any part of it without notice and you confirm that TeaChat shall not be liable to you for any such change or removal and.</li>
                    </ul>
                </li>
                <li>
                    <strong>Links to Third Party Websites</strong><br/>
                    TeaChat Website may include links to third party websites that are controlled and maintained by others. Any link to other websites is not an endorsement of such websites and you acknowledge and agree that we are not responsible for the content or availability of any such sites.
                </li>
                <li>
                    <strong>COPYRIGHT</strong><br/>
                    <ul>
                        <li>6.1. All copyright, trade marks and all other intellectual property rights in the Website and its content (including without limitation the Website design, text, graphics and all software and source codes connected with the Website) are owned by or licensed to TeaChat or otherwise used by TeaChat as permitted by law.</li>
                        <li>6.2. In accessing the Website you agree that you will access the content solely for your personal, non-commercial use. None of the content may be downloaded, copied, reproduced, transmitted, stored, sold or distributed without the prior written consent of the copyright holder. This excludes the downloading, copying and/or printing of pages of the Website for personal, non-commercial home use only.</li>
                    </ul>
                </li>
                <li>
                    <strong>LINKS TO AND FROM OTHER WEBSITES</strong>
                    <ul>
                        <li>7.1. Throughout this Website you may find links to third party websites. The provision of a link to such a website does not mean that we endorse that website. If you visit any website via a link on this Website you do so at your own risk.</li>
                        <li>
                            7.2. Any party wishing to link to this website is entitled to do so provided that the conditions below are observed:
                            <ol>
                                <li>(a) you do not seek to imply that we are endorsing the services or products of another party unless this has been agreed with us in writing;</li>
                                <li>(b) you do not misrepresent your relationship with this website; and</li>
                                <li>(c) the website from which you link to this Website does not contain offensive or otherwise controversial content or, content that infringes any intellectual property rights or other rights of a third party.</li>
                            </ol>
                        </li>
                        <li>7.3. By linking to this Website in breach of our terms, you shall indemnify us for any loss or damage suffered to this Website as a result of such linking.</li>
                    </ul>
                </li>
                <li>
                    <strong>DISCLAIMERS AND LIMITATION OF LIABILITY</strong>
                    <ul>
                        <li>8.1  The Website is provided on an AS IS and AS AVAILABLE basis without any representation or endorsement made and without warranty of any kind whether express or implied, including but not limited to the implied warranties of satisfactory quality, fitness for a particular purpose, non-infringement, compatibility, security and accuracy.</li>
                        <li>8.1  The Website is provided on an AS IS and AS AVAILABLE basis without any representation or endorsement made and without warranty of any kind whether express or implied, including but not limited to the implied warranties of satisfactory quality, fitness for a particular purpose, non-infringement, compatibility, security and accuracy.</li>
                        <li>8.3  TeaChat makes no warranty that the functionality of the Website will be uninterrupted or error free, that defects will be corrected or that the Website or the server that makes it available are free of viruses or anything else which may be harmful or destructive.</li>
                        <li>8.3  TeaChat makes no warranty that the functionality of the Website will be uninterrupted or error free, that defects will be corrected or that the Website or the server that makes it available are free of viruses or anything else which may be harmful or destructive.</li>
                    </ul>
                </li>
                <li>
                    <strong>IDENTITY</strong><br/>
                    You agree to indemnify and hold TeaChat and its employees and agents harmless from and against all liabilities, legal fees, damages, losses, costs and other expenses in relation to any claims or actions brought against TeaChat arising out of any breach by you of these Terms and Conditions or other liabilities arising out of your use of this Website.
                </li>
                <li>
                    <strong>SEVERANCE</strong><br/>
                    If any of these Terms and Conditions should be determined to be invalid, illegal or unenforceable for any reason by any court of competent jurisdiction then such Term or Condition shall be severed and the remaining Terms and Conditions shall survive and remain in full force and effect and continue to be binding and enforceable.
                </li>
                <li>
                    <strong>WAIVER</strong><br/>
                    If you breach these Conditions of Use and we take no action, we will still be entitled to use our rights and remedies in any other situation where you breach these Conditions of Use
                </li>
                <li>
                    <strong>GOVERNING LAW</strong><br/>
                    These Terms and Conditions shall be governed by and construed in accordance with the law of Philippines and you hereby submit to the exclusive jurisdiction of the Philippines courts.
                </li>
                <li>
                    <strong>OUR CONTACT DETAILS</strong><br/>
                    <address>
                        28th Floor Pacific Star Bldg., corner Buendia Avenue, <br/>Makati City, Makati City 1209<br/>Philippines<br/>
                    </address><br/>
                    <small>For any further information please email TeaChat (mailto:<a href="mailto:info@teachat.co">info@teachat.co</a>) Team</small>
                </li>
                </ol>
                </div>

            </div>
        </div>
    </div>
</div>


@stop
@section('custom-scripts')

    <script type="text/javascript" src="{{asset('teachatv3/registration/registration.js')}}"></script>

    <script type="text/javascript">
            $(document).ready(function() {

                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

            });



            function changeCountry(country) {

                $.get('/registration/country/'+country.value, function(data){
                    var model = $('#state_id');
                        model.empty();
                        model.append("<option disabled selected>Select State/Province</option>");

                    var models = $('#school_id');
                        models.empty();
                        models.append("<option disabled selected>Select School</option>");

                    if(data.result) {
                        var output = [];
                        
                        $.each(data.message, function(key, value){

                                model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

                        });
                        model.material_select();

                        $.each(data.messages, function(key, value){

                                models.append("<option value='"+ value.id +"'>" + value.school_name + "</option>");

                        });
                        models.material_select();
                                
                    }

                    else {
                        model.append("");
                        model.material_select();
                        Materialize.toast(data.message, 7000, "red");

                        models.append("");
                        models.material_select();
                        Materialize.toast(data.messages, 7000, "red");
                    }

                });
            }

            function termscondition() {
                $('#termscondition').openModal();
            }

        </script>


@stop
