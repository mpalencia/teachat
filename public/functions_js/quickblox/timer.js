var duration, display, interval, diff;

function showTimer(){
	display = document.getElementById('videoTimer_js');
	display.textContent = '00:00'; 
}

function startTimer() {
	duration = 900;
    var start = Date.now(),
        minutes,
        seconds;
    function timer() {
        // get the number of seconds that have elapsed since 
        // startTimer() was called
        diff = duration - (((Date.now() - start) / 1000) | 0);

        // does the same job as parseInt truncates the float
        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds; 

        if (diff == 5) {
            // add one second so that the count down starts at the full duration
            // example 05:00 not 04:59
			//ALERT MODAL HERE ----
        } else if(diff == 0){
			stopTimer();
		}
    };
    // we don't want to wait a full second before the timer starts
    timer();
    interval = setInterval(timer, 1000);
}

function stopTimer(){
	clearInterval(interval);
    btn_end_call(data.user_id);
}

function resetTimer(){
	showTimer();
}

function getDuration(){
	return diff;
}