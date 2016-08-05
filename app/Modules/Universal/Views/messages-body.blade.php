
        <div class="profile-content msgs">
            <div class="row" style="position: relative;">
                <h4>
                    @if($profile[0]['role_id'] == 3)
                        <span>Select Teacher to chat</span>
                    @else
                        <span>Select Parent to chat</span>
                    @endif
                </h4>
                <span class="divider"></span>
                <div class="divider"></div><br/>
                <div class="loading_hover">
                    <p><i class="fa fa-fw fa-spinner fa-spin"></i> <spabn id="loading_status">Connecting to chat server</span> <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>
                </div>
                <div class="col s12 m4 l4 white-text contact_names">
                    <div class="msg_header blue-grey darken-4">
                        <form>
                            <div class="row">
                                <div class="input-field col s12 m12 white-text">
                                  <input id="searchString" type="text">
                                  <label for="text" data-error="wrong" data-success="right">Search</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="contact_content blue-grey darken-1">
                        <ul>
                            @foreach($messageOpponent as $user)
                                @if(isset($user['appointment']))
                                    <li class="c_content waves-effect msg_select_user" id="" onclick="timerCheckerRedirectVideoChat('123', {{ $user['appointment']->Appt_id }});" >
                                @else
                                    <li class="c_content waves-effect msg_select_user" id="" onclick="timerCheckerRedirectVideoChat();">
                                @endif
                                    @if($user['active'] == 0)
                                        @if($user['profile_img'] !== 'dp.png')
                                            <figure class="offline userProfileimg" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $user['profile_img'] }}')"><span class="unread hide">0</span></figure>
                                        @else
                                            <figure class="offline userProfileimg" style="background-image: url('{{ asset('images/profile') }}/{{ $user['profile_img'] }}')"><span class="unread hide">0</span></figure>
                                        @endif
                                    @else
                                        @if($user['profile_img'] !== 'dp.png')
                                            <figure class="online userProfileimg" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $user['profile_img'] }}')"><span class="unread hide">0</span></figure>
                                        @else
                                            <figure class="online userProfileimg" style="background-image: url('{{ asset('images/profile') }}/{{ $user['profile_img'] }}')"><span class="unread hide">0</span></figure>
                                        @endif
                                    @endif
                                <span class="contact_name truncate"> {{ $user['first_name'] }} {{ $user['last_name'] }} </span>
                                <span class="contact_status" id="">
                                    @if($user['active'] == 0)
                                        <i class="fa fa-fw fa-circle offline"></i> <span class="textStatus">Offline</span>
                                    @else
                                        <i class="fa fa-fw fa-circle online"></i> <span class="textStatus">Online</span>
                                    @endif
                                    @if(isset($user['appointment']))
                                        <span class="date_tile hide" id="{{ $user['appointment']->Appt_id }}"><small>{{ $user['appointment']->appt_date }} <span class="time_only">{{ $user['appointment']->appt_stime }}</span> - <span class="time_end">{{ $user['appointment']->appt_etime }}</span></small></span>
                                    @endif
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col s12 m8 l8 contact_msgs">
                    <div class="msg_header grey lighten-2">

                    </div>
                    <div class="msg_body grey lighten-3" id="message_msgPanel">
                        <!--<center><h3 class="engraved"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading ... </h3></center>
                        <div class="right">
                            <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                            <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!
                                <a href="#!"><i class="material-icons tiny">attach_file</i> File Attached.</a></p>
                        </div>
                        <div class="left">
                            <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                            <p class="callout position-left">Your Favourite HTML,CSS,JS Playground!</p>
                        </div>
                        <div class="right">
                            <p class="callout position-left"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Uploading <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>
                        </div>
                        <div class="right">
                            <small><a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a> Jan 12, 2016</small>
                            <p class="callout position-right">Your Favourite HTML,CSS,JS Playground!</p>
                        </div>
                        <div class="left">
                            <small>Jan 12, 2016 <a href="#!" class="del_msg"><i class="fa fa-fw fa-times"></i></a></small>
                            <p class="callout position-left">
                                Your Favourite HTML,CSS,JS Playground!
                                <a href="#!"><i class="material-icons tiny">attach_file</i> File Attached.</a>
                            </p>
                        </div>-->
                        <center><img src="{{asset('images/tutorial.jpg')}}" alt="Tutorial" width="100%" ></center>
                    </div>
                    <div class="msg_txtarea">
                        <div class="row grey lighten-2">
                            <form id="messages_submit" accept-charset="utf-8" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="Message_msgbody" class="materialize-textarea" rows="2" required autofocus placeholder="Write a message ..."></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s8 m9">
                                        @if($upload === 1)
                                            <span class="upload_icon">
                                                <input type="file" name="" id="file_chat">
                                                <i class="material-icons waves-effect">present_to_all</i> <span id="file_name"> Upload a file</span>
                                            </span>
                                        @else
                                            <span class="upload_icon" style="display: none;">
                                                <input type="file" name="" id="file_chat">
                                                <i class="material-icons waves-effect">present_to_all</i> <span id="file_name"> Upload a file</span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col s4 m3">
                                        <button class="btn waves-effect btn-block waves-light" type="submit" name="action">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('functions_js/message_functions.js') }}"></script>
    <script src="{{ asset('functions_js/timer.js') }}"></script>
    <script type="text/javascript">
        var iamOnvideoPanel = true;
        $('#Message_msgbody').trigger('autoresize')
    </script>
