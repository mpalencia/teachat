@extends('layouts.master')

@section('page_title', 'Dashboard')

@section('body_content')
<div class="profile-content">
    <div class="row">
    	<h4>Dashboard</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>

        <div class="col m6 s12 padding_adjust">
            <div class="info-box">
                <span class="info-title grey lighten-3"> Schools <span class="right">Total: {{count($schools_count)}}</span></span>
                    <span class="info-box-icon grey lighten-4 dash_container" style="padding: 5px;">
                    @foreach($schools as $school)
                        <div class="dash_tile">
                            <span class="pull-right">{{ $school['country']['name'] }}</span>
                            <span class="title_tile">{{ $school['school_name'] }}</span>
                            <small>{{date_format(date_create($school['created_at']), 'd-M-Y')}}</small>
                        </div>
                    @endforeach
                    </span>
            </div>
        </div>

        <div class="col m3 s12 padding_adjust">
            <span class="info-box-icon mint">
                <br/><span class="desc">Date</span><br/><br/><br/>
                <span class="day_" id="day_"></span>
                <span class="year_" id="year_"></span>
            </span>
        </div>

        <div class="col m3 s12 padding_adjust">
            <span class="info-box-icon orange darken-3">
                <br/><span class="desc">Time</span><br/><br/><br/>
                <span class="day_"><span id="time"></span></span>
                <span class="year_"><span id="ampm"></span></span>
            </span>
        </div>

    </div>
</div>
@stop
@section('custom-scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
<script type="text/javascript">
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
        document.getElementById('time').innerHTML = h + ":" + m;
        document.getElementById('ampm').innerHTML = ampm;
        t = setTimeout(function () {
            startTime()
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
            weekday[0]=  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

        var M = month[today.getMonth()];
        var d = today.getDate();
        var Y = today.getFullYear();
        var D = weekday[today.getDay()];

        document.getElementById('day_').innerHTML = M + " " + d;
        document.getElementById('year_').innerHTML = Y + " " + D;
    }
    showDate();
</script>
@stop
