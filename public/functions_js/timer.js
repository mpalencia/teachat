 var historyDate,globalHour,globalAmpm;       
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            var ampm = h >= 12 ? 'PM' : 'AM';
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            h = h % 12;
            h = h ? h : 12;
            h = checkTime(h);
            //document.getElementById('time').innerHTML = h + ":" + m;
            //document.getElementById('ampm').innerHTML = ampm;
            globalHour = h + ":" + m;
            globalAmpm = ampm;
            $('#time').html(h + ":" + m);
            $('#ampm').html(ampm);

            t = setTimeout(function () {
                startTime()
                changeIconOnloadOnNotIntime();
            }, 500);
        }
        startTime();

        function showDate() {
            var today = new Date();
            var month = new Array();
                month[0] = "Jan";
                month[1] = "Feb";
                month[2] = "Mar";
                month[3] = "Apr";
                month[4] = "May";
                month[5] = "Jun";
                month[6] = "Jul";
                month[7] = "Aug";
                month[8] = "Sept";
                month[9] = "Oct";
                month[10] = "Nov";
                month[11] = "Dec";
            var weekday = new Array();
                weekday[0]=  "Sun";
                weekday[1] = "Mon";
                weekday[2] = "Tue";
                weekday[3] = "Wed";
                weekday[4] = "Thu";
                weekday[5] = "Fri";
                weekday[6] = "Sat";

            var M = month[today.getMonth()];
            var d = today.getDate();
            var Y = today.getFullYear();
            var D = weekday[today.getDay()];

            //document.getElementById('day_').innerHTML = M + " " + d;
            //document.getElementById('year_').innerHTML = Y + " " + D;
            historyDate = M + " "+d+","+Y+" "+D;
            $('#day_').html(M + " " + d);
            $('#year_').html(Y + " " + D);
        }
        showDate();

        function timerCheckerRedirectVideoChat(id,uni){
            var time = $('#'+uni+' .time_only').text();
            var endTime = $('#'+uni+' .time_end').text();
            var hour = globalHour;//$('#time').html();
            var ampm = globalAmpm;//$('#ampm').html();
            var currentTime = hour+' '+ampm;
            //alert(hour);
            console.log(time + ' - ' + currentTime);
            console.log(endTime + ' - ' + currentTime);
            if(time <= currentTime && endTime >= currentTime){
                var videoTime =  TimeDurationCreator(time,endTime,currentTime);
                if(iamOnvideoPanel == true){
                    videoStatus = videoTime;
                }else{//"+id+"/"+videoTime;
                   window.location.href = "videochat";
                }
                //alert(videoTime);
            }else{
                videoStatus = false;
                Materialize.toast('Your video session will be available on your appointment time slot. Please try again later.', 5000, 'red');
            }
        }

        function TimeDurationCreator(start,end,current){
            //var start = TimeSpliter(start);
            var endHr = TimeSpliter(end);
            var currenthr = TimeSpliter(current);

            var endmin = TimeSpliterMin(end);
            var currentmin = TimeSpliterMin(current);
                var hrTosec = (endHr - currenthr) * 60 * 60;
                var minTisec = (endmin - currentmin) * 60;

                return hrTosec + minTisec;
        }

        function TimeSpliter(time){
            var time = time.split(" ")[0].split(":");
            var hour = parseInt(time[0]);
            //var min = parseInt(MinChanger(time[1])) * 60;

            return hour;
        }

        function TimeSpliterMin(time){
            var time = time.split(" ")[0].split(":");
            //var hour = parseInt(time[0]);
            var min = parseInt(MinChanger(time[1]));

            return min;
        }

        function MinChanger(min){
            if(min == 00 || min == 0){
                min = 60;
            }
            return min
        }

        function changeIconOnloadOnNotIntime(){
            $('.appointment').each(function(index){
                var id = $(this).attr('id');
                var time = $('#'+id+' .time_only').text();
                var endTime = $('#'+id+' .time_end').text();
                var hour = $('#time').html();
                var ampm = $('#ampm').html();
                var currentTime = hour+' '+ampm;
                    if(time <= currentTime && endTime >= currentTime){
                        $(this).find('.material-icons').addClass('disabled').html('videocam');
                    }else{
                        $(this).find('.material-icons').addClass('disabled').html('videocam_off');
                    }
                
            });
        }
