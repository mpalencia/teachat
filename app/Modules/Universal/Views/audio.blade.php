<audio id="callingSignal" loop>
	<source src="{{ asset('assets/audio/calling.ogg') }}"></source>
	<source src="{{ asset('assets/audio/calling.mp3') }}"></source>
</audio>

<audio id="ringtoneSignal" loop>
	<source src="{{ asset('assets/audio/ringtone.ogg') }}"></source>
	<source src="{{ asset('assets/audio/ringtone.mp3') }}"></source>
</audio>

<audio id="endCallSignal">
	<source src="{{ asset('assets/audio/end_of_call.ogg') }}"></source>
	<source src="{{ asset('assets/audio/end_of_call.mp3') }}"></source>
</audio>
 <div id="incoming_call" class="modal" data-backdrop="static">
        <div class="modal-content">
            <figure class="online" style="background-image: url('{{asset('images/profile/dp.png')}}')"></figure>
            <p class="truncate">Parent Name Surname</p>
            <p class="calling">is calling <span class="loader_dot">.</span><span class="loader_dot">.</span><span class="loader_dot">.</span></p>
            <div class="row">
                <div class="col m6 s6">
                    <button class="waves-effect waves-light btn btn-floating green hvr-float accept_btn"><i class="material-icons">phone_in_talk</i></button>
                </div>
                <div class="col m6 s6">
                    <button class="waves-effect waves-light btn btn-floating red modal-action modal-close hvr-float btn_reject"><i class="material-icons">call_end</i></button>
                </div>
            </div>
        </div>
    </div>
