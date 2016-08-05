<div class="row" xmlns="http://www.w3.org/1999/html">
        <h4>History</h4>
        <span class="divider"></span>
        <div class="qa-message-list" id="history">

            @foreach($History as $history)
                <div class="message-item hvr-float" id="m16">
                    <div class="message-inner">
                        <div class="message-head clearfix">
                        @if($history->profile_img !== 'dp.png')
                            <div class="avatar pull-left" style="background-image: url('https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $history->profile_img  }}')"></div>
                        @else
                            <div class="avatar pull-left" style="background-image: url('{{ asset('/images/dp.png') }}')"></div>
                        @endif
                            
                            <div class="user-detail">
                                <h5 class="handle">Video chat with {{ $history->name_prefix  }} {{ $history->first_name  }} {{ $history->last_name  }} on </h5>
                                <div class="post-meta">
                                    <div class="asker-meta">
                                        <span class="qa-message-what"></span>
                                        <span class="qa-message-when">
                                            <span class="qa-message-when-data">{{ $history->date }} {{ $history->time }}</span>
                                        </span>
                                        <span class="qa-message-who">
                                            <span class="qa-message-who-data {{ $history->duration }}">{{ $history->duration }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>