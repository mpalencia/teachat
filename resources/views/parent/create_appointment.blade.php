@extends('layouts.master')

@section('page_title', 'Create Appointment')

@section('body_content')
    
    <div class="col s12 m12 19">
    <div class="row btn-thing">
        <h4>Appointment</h4>

        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" >
                    <div class="table-header blue-grey lighten-5">Create Appointment</div>
                    <div class="input-field col s12 m12">
                        <select class="teacher_select validate" required=""  name="teacher_id" onchange="checkTeacherSchedule(this)">
                            <option value="4" selected>-- Choose a Teacher -- </option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher['teacher']['id'] }}">{{ $teacher['teacher']['first_name'] }} {{ $teacher['teacher']['last_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="calendar_view" class="col s12">
                        <br/>
                        <div id="teacher-calendar" class="teacher-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
     <!-- <div id="view_appointment" class="modal view_appointment">
        <div class="modal-content">
            <h5>Appointments for <span class="date_selected"></span></h5>
            <div class="divider"></div>
            <form id="form_add_appointment" accept-charset="utf-8" class="row form_add_appointment" style="padding: 10px">
            <input type="hidden" readonly="" name="teacher_id" value="" id="teacherId">
                <div class="input-field col s12 m4">
                    <input id="appointmentDate" type="text" readonly="" required="" class="" name="appt_date">
                    <label for="appointment_date">Appointment Date</label>
                </div>
                <div id="appoinment_time">
                    <div class="input-field col s12 m4">
                        <input placeholder="Appointment Start Time" id="appointment_stime" type="text" name="appt_stime" class="time start" required="">
                        <label for="appointment_stime">Appointment Start Time</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input placeholder="Appointment End Time" id="appointment_etime" type="text" name="appt_etime" class="time end endtime" required="">
                        <label for="appointment_etime">Appointment End Time</label>
                    </div>
                </div>
                <div class="input-field col s12 m12">
                    <input id="appointment_title" type="text" class="validate" required="" name="title">
                    <label for="appointment_title">Appointment Title</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="appointment_description" class="materialize-textarea" required="" name="description"></textarea>
                    <label for="appointment_description">Appointment Description</label>
                </div>

                <div class="input-field col s12 m5 l4">
                    <button class="btn waves-effect btn-large btn-block waves-light">Add
                        <i class="material-icons right">perm_contact_calendar</i>
                    </button>
                </div>
            </form>
        </div>
    </div> -->

    <div id="view_appointment" class="modal view_appointment">
        <div class="modal-content">
            <h5>Appointments for <span class="date_selected"></span></h5>
            <div class="divider"></div>
           <form id="form_add_appointment" accept-charset="utf-8" class="row form_add_appointment" style="padding: 10px">
                    <input id="created_by" type="hidden" name="created_by" value="3"> 
                       <div class="input-field col s12 m4">
                            <input id="appointment_date" type="text" readonly="" required="" class="" name="appt_date">
                            <label for="appointment_date">Appointment Date</label>
                        </div>
                        <div id="appoinment_time">
                            <div class="input-field col s12 m4">
                                <input placeholder="Appointment Start Time" id="appointment_stime" type="text" name="appt_stime" class="time start" required="">
                                <label for="appointment_stime">Appointment Start Time</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input placeholder="Appointment End Time" id="appointment_etime" type="text" name="appt_etime" class="time end" required="">
                                <label for="appointment_etime">Appointment End Time</label>
                            </div>
                        </div>
                        <div class="input-field col s12 m12">
                            <input id="appointment_title" type="text" class="validate" required="" name="title">
                            <label for="appointment_title">Appointment Title</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="appointment_description" class="materialize-textarea" required="" name="description"></textarea>
                            <label for="appointment_description">Appointment Description</label>
                        </div>

                        <div class="input-field col s12 m5 l4">
                            <button class="btn waves-effect btn-large btn-block waves-light">Add
                                <i class="material-icons right">perm_contact_calendar</i>
                            </button>
                        </div>
                        <div class="input-field col s12 m5 l4">
                            <a href="/teacher/students" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
                        </div>
                    </form>
        </div>
    </div>
@stop

@section('custom-scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
<script src="{{ asset('select/select2.full.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}"></link>
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('time_picker/jquery.timepicker.min.js') }}"></script><!-- Time Picker -->
<link rel="stylesheet" href="{{ asset('time_picker/jquery.timepicker.css') }}"></link>
<script src="{{ asset('time_picker/datepair.min.js') }}"></script><!-- Date Picker -->
<script src="{{ asset('time_picker/jquery.datepair.min.js') }}"></script>
<script src="{{ asset('teachatv3/parents/appointments.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('zabuto_calendar/zabuto_calendar.css')}}">
<script src="{{ asset('zabuto_calendar/zabuto_calendar.min.js')}}"></script>
<script src="{{ asset('functions_js/appointment_parent.js') }}"></script>

<script type="application/javascript">
    $(document).ready(function() {
        $('.teacher_select').select();//Initialize Select2 Elements
        $('select').material_select();
        $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

    });
    /* Date Picker jQuery UI*/
    $(function() {
        $( "#appointment_date" ).datepicker({ minDate: 0,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: "Select date"
      });
    });
    /* Zabuto Calendar */
    function checkTeacherSchedule(teacher){
        var teacher_data = "";
        $('#teacherId').val(teacher.value);
        if(teacher.value != 0)
        {   $(".teacher-calendar").html('');
            $.get("/parent/appointments/getAllByTeacher/" + teacher.value, function(data){
                 $(".teacher-calendar").zabuto_calendar({
                    language: "en",
                    data: $.parseJSON(data),
                    cell_border: true,
                    today: true,
                    show_days: true,
                    weekstartson: 0,
                    show_previous : false,
                    nav_icon: {
                        prev: '<i class="fa fa-chevron-left"></i>',
                        next: '<i class="fa fa-chevron-right"></i>'},
                    action:function(){
                        return calendarClick(this.id, teacher.value);
                    },
                });

                /* Modal*/
                $('.modal-trigger').leanModal();
            });
        }
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
    // function timePicks(start, end)
    // {
    //     /* Time Picker */
    //     $('#appointment_stime').timepicker({
    //         'minTime': '7:00am',
    //         'maxTime': '7:00pm',
    //         'timeFormat': 'h:i A',
    //         'step': 15,
    //         'disableTimeRanges': start
    //     });

    //     $('#appointment_etime').timepicker({
    //         'minTime': '7:00am',
    //         'maxTime': '7:00pm',
    //         'timeFormat': 'h:i A',
    //         'step': 15,
    //         'disableTimeRanges': end
    //     });
    //     var appoinment_time = document.getElementById('appoinment_time');
    //     var timeOnlyDatepair = new Datepair(appoinment_time,{
    //         'defaultDateDelta': 0,      // days
    //         'defaultTimeDelta': 900000 // milliseconds
    //     });
    // }

   $(function() {
        $( "#appointment_date" ).datepicker({ minDate: 0,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: "Select date"
      });
    });
    /* Time Picker */
    $('#appoinment_time .time').timepicker({
        'minTime': '7:00am',
        'maxTime': '7:00pm',
        'timeFormat': 'h:i A',
        'step': 15,
        'disableTimeRanges': [
          ['12pm', '1pm']
        ]
    });

    var appoinment_time = document.getElementById('appoinment_time');
    var timeOnlyDatepair = new Datepair(appoinment_time,{
        'defaultDateDelta': 0,      // days
        'defaultTimeDelta': 900000 // milliseconds
    });

    $('#dateOnlyExample .date').datepicker({
        'format': 'yyyy-m-d',
        'autoclose': true
    });

</script>

@include('parent.floox-script')

@stop