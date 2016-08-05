@extends('layouts.master')

@section('page_title', 'Settings')

@section('body_content')
<h4>History</h4>
<span class="divider"></span>

<div class="qa-message-list" id="history">
    @foreach($appointments as $appointment)
    <div class="message-item hvr-float" id="m16">
        <div class="message-inner">
            <div class="message-head clearfix">
                @if($appointment['teacher']['profile_img'] == null || $appointment['teacher']['profile_img'] == '')
                <div class="avatar pull-left" style="background-image: url('https://dev3.teachat.co/images/dp.png')"></div>
                @else
                <div class="avatar pull-left" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{$appointment['teacher']['profile_img']}}')"></div>
                @endif
                <div class="user-detail">
                    <h5 class="handle">Video chat with {{$appointment['teacher']['first_name']}} {{$appointment['teacher']['last_name']}} on </h5>
                    <div class="post-meta">
                        <div class="asker-meta">
                            <span class="qa-message-what"></span>
                            <span class="qa-message-when">
                                <span class="qa-message-when-data">{{date_format(date_create($appointment['appt_date']), 'M d, Y D')}}</span>
                            </span>
                            <!-- <span class="qa-message-who">
                                <span class="qa-message-who-data 00:12:33">00:12:33</span>
                            </span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<link rel="stylesheet" href="{{asset('css/timeline.css')}}">
@stop

@section('custom-scripts')

    @include('parent.floox-script')

@stop
