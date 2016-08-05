
    @extends('theme')
    @section('title_tag')
        <title>Teacher : My Account</title>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @stop

    @section('additional_headtag')
        <!-- Scripts for Header -->
    @stop

    @section('body_content')

        @include('includes.nav-profile')

        <div class="container">
            <div class="row profile">
                <div class="col s12 m12 l3 hide-on-med-and-down">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        @include('Universal::profile_img')
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="nav_tab" id="dashboard">
                                    <a href="/teacher/dashboard" class="waves-effect"><i class="material-icons">dashboard</i> Dashboard </a>
                                </li>
                                <li class="active nav_tab" id="overview">
                                    <a href="javascript:void(0)" class="waves-effect"><i class="material-icons">perm_identity</i><span>My Account</span></a>
                                </li>
                                <li class="nav_tab" id="child">
                                    <a href="/teacher/students" class="waves-effect"><i class="material-icons">assignment_ind</i>Students </a>
                                </li>
                                <li class="nav_tab" id="msgs">
                                    <a href="/teacher/messages" class="waves-effect"><i class="material-icons">videocam</i>Video Chat / Messages</a>
                                </li>
                                <li class="nav_tab" id="appointment">
                                    <a href="/teacher/appointments" class="waves-effect"><i class="material-icons">perm_contact_calendar</i>Appointments </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/teacher/history" class="waves-effect"><i class="material-icons">toll</i>History </a>
                                </li>
                                <li class="nav_tab" id="settings">
                                    <a href="/teacher/settings" class="waves-effect"><i class="material-icons">settings</i>Settings </a>
                                </li>
                            </ul>
                        </div>
                      <!-- END MENU -->
                    </div>
                </div>
                <div class="col s12  m12 l9">
                    <div class="profile-content">
                        <div class="row">
                            <h4>Advisory</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <form id="frm_updateAdvisory">
                                <div class="row">
                                    <div class="input-field col s12 m9">
                                        <select required="required" aria-required="true" name="grade" id="advisory_grade">
                                          <option value="" disabled selected>-- Choose Grade --</option>
                                          <option value="Kinder">Kinder</option>
                                          <option value="Grade 1">Grade 1</option>
                                          <option value="Grade 2">Grade 2</option>
                                          <option value="Grade 3">Grade 3</option>
                                          <option value="Grade 4">Grade 4</option>
                                          <option value="Grade 5">Grade 5</option>
                                          <option value="Grade 6">Grade 6</option>
                                          <option value="Grade 7">Grade 7</option>
                                          <option value="Grade 8">Grade 8</option>
                                          <option value="Grade 9">Grade 9</option>
                                          <option value="Grade 10">Grade 10</option>
                                          <option value="Grade 11">Grade 11</option>
                                          <option value="Grade 12">Grade 12</option>
                                        </select>
                                        <label>Choose Grade</label>
                                    </div>

                                    <div class="input-field col s6 m3">
                                        <button class="btn waves-effect waves-light btn-block green darken-1" type="submit">Update
                                            <i class="material-icons right">add</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <h4>Subjects</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <form id="frm_addSubject">
                                <div class="row">
                                    <div class="input-field col s9">
                                        <input type="text" id="subject" name="subject"  class="validate" required="" aria-required="true">
                                        <label for="subject" data-error="wrong" data-success="right">Subject</label>
                                    </div>
                                    <div class="input-field col s3">
                                        <button class="btn waves-effect waves-light btn-block green darken-1" type="submit">Add
                                            <i class="material-icons right">add</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="row" id="subject_list">
                                @if(isset($subject))
                                    @foreach($subject as $subject)
                                        <div class="chip blue-grey darken-3 white-text">
                                            {{ $subject->subject_name }} <i class="material-icons" onClick="delelteSubject({{ $subject->id }})">close</i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('additional_bodytag')
        <script src="{{ asset('functions_js/teacher_myAccount.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });
        </script>
    @stop
