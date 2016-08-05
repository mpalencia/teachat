@extends('layouts.master')

@section('page_title', 'Appointments')

@section('body_content')

    <div class="profile-content">
        <div class="row">
            <h4>Appointments</h4>
            <span class="divider"></span>
            <div class="divider"></div><br/>
            <a href="/parent/appointments/create" class="btn waves-effect waves-light teal" type="submit" name="action">REQUEST
                <i class="material-icons right">perm_contact_calendar</i>
            </a><br/><br/>

            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s6"><a href="#calendar_view" class="green-text">Calendar View</a></li>
                        <li class="tab col s6"><a href="#list_view" class="active green-text">List View</a></li>
                    </ul>
                </div>

                <div id="calendar_view" class="col s12">
                    <br/>
                    <div id="my-calendar"></div>
                </div>

                <div id="list_view" class="col s12">
                    <br/>
                    @foreach ($appointments as $appointment => $value)
                        <div id="appointment_listholder">
                            <ul class="appointment_list">
                            <li class="collection-header"><h5>{{ $appointment}}</h5></li>
                            @foreach($value as $item)
                                <li class="row">
                                    <div class="col s12 m8">

                                    <?php $amazon_profile_pic = "https://s3-ap-southeast-1.amazonaws.com/teachatco/images/" . $item['teacher']['profile_img'];?>
                                    @if($item['teacher']['profile_img'] == 'dp.png')
                                    <figure style='background-image: url(" . asset("/images/dp.png") . ")'></figure>
                                    @else
                                    <figure style='background-image: url({{$amazon_profile_pic}})'></figure>
                                    @endif

                                    <span class="appointment_title"> {{$item["teacher"]["first_name"]}} {{$item["teacher"]["last_name"]}} </span>
                                    <small>{{ $item['appt_stime'] }} {{ $item['appt_etime'] }}</small>
                                    </div>
                                    <div class="options_container">
                                        <div class="col s12 m4 options_btn">
                                            <div class="right">


                                            @if ($item['action'] === null || $item['action'] === '')
                                                <a class="waves-effect waves-light btn amber darken-3 tooltipped" onClick="functionViewDetail({{$item['id']}});" href="#appointment_details" data-position="left" data-tooltip="Waiting for Confirmation"><i class="material-icons">zoom_in</i></a>
                                            @elseif ($item['action'] === 'Accept')
                                                <a class="waves-effect waves-light btn darken-3 tooltipped" onClick="functionViewDetail({{$item['id']}});" href="#appointment_details" data-position="left" data-tooltip="Accepted"><i class="material-icons">zoom_in</i></a>
                                            @elseif ($item['action'] === 'Inperson')
                                                <a class="waves-effect waves-light btn  blue darken-3 tooltipped" onClick="functionViewDetail({{$item['id']}});" href="#appointment_details" data-position="left" data-tooltip="In person"><i class="material-icons">zoom_in</i></a>
                                            @endif


                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
            <br/>
            <!-- Modal Trigger For Todays Appointment
            <a class="waves-effect waves-light btn modal-trigger" href="#view_appointment">Modal</a>-->

            <!-- Modal Structure For Todays Appointment-->
            <div id="view_appointment" class="modal bottom-sheet">
                <div class="modal-content">
                    <h5>Appointments for <span class="date_selected"></span></h5>
                    <div class="divider"></div>
                    <ul class="appointment_list">


                    </ul>
                </div>
            </div>

            <!-- Modal Structure For Appointment Details-->
            <div id="appointment_details" class="modal">
                <div class="modal-content">
                   <center>
                       <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                              <div class="circle-clipper left">
                                <div class="circle"></div>
                              </div><div class="gap-patch">
                                <div class="circle"></div>
                              </div><div class="circle-clipper right">
                                <div class="circle"></div>
                              </div>
                            </div>
                        </div>
                   </center>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                </div>
            </div>

            <!-- Modal Structure For Declined Reason-->
            <div id="appointment_declined" class="modal">
                <div class="modal-content">
                    <h5>Reason why the parent Declined</h5>
                    <p id="area_reason_text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore hic, animi tempora corrupti obcaecati, cumque at. Odit expedita libero fugiat esse nihil autem cum, ducimus fugit provident veniam reiciendis nesciunt.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                </div>
            </div>
        </div>
    </div>

<input type="text" disabled="" id="parentId" value="{{\Auth::user()->id}}">
@stop

@section('custom-scripts')
        <link rel="stylesheet" type="text/css" href="{{ asset('zabuto_calendar/zabuto_calendar.css')}}">
        <script src="{{ asset('zabuto_calendar/zabuto_calendar.min.js')}}"></script>
        <script src="{{ asset('functions_js/appointment_parent.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function () {
              //var baseUrl = document.location.origin;//location.host;
                call_mycalendar();
            });

            /* Zabuto Calendar */
            function call_mycalendar(){
              //alert();
                $("#my-calendar").zabuto_calendar({
                    language: "en",
                  //data: eventData,
                    cell_border: true,
                    today: true,
                    show_days: true,
                    weekstartson: 0,
                    nav_icon: {
                        prev: '<i class="fa fa-chevron-left"></i>',
                        next: '<i class="fa fa-chevron-right"></i>'},
                    ajax: {
                        url: "/parent/appointments/getAllByParent",
                        modal: false
                    },
                    action:function(){calendarClick(this.id, $('#parentId').val());}
                });
                /* Modal*/
                $('.modal-trigger').leanModal();
            }

            /* Hide and Show Delete Btn*/
            function showDelete(id){
                $('#'+id).find('.confirm_delete').removeClass('hide');
                $('#'+id).find('.options_btn').addClass('hide');
            };

            function cancel_delete(id){
                $('#'+id).find('.confirm_delete').addClass('hide');
                $('#'+id).find('.options_btn').removeClass('hide');
            };
        </script>

        @include('parent.floox-script')
@stop

