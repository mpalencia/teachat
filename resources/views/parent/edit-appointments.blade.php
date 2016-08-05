@extends('layouts.master')

@section('page_title', 'Create Appointment')

@section('body_content')

	<div class="row btn-thing">
        <h4>Appointment</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" >
                    <div class="table-header blue-grey lighten-5">Edit Appointment</div>
                    <div class="div_notif notif"></div>
                    <form method="PUT" id="form_edit_appointment" accept-charset="utf-8" class="row form_edit_appointment" style="padding: 10px">
                       <div class="input-field col s12 m12">
                       <input type="hidden" name="teacher_id" value="{{$appointment->teacher_id}}">
                            <input id="parent_id" type="text" readonly="" required="" class=""  value="{{ucfirst($appointment->teacher->first_name)}} {{ucfirst($appointment->teacher->last_name)}}">
                            <label for="parent_id">Teacher</label>
                        </div>
                       <div class="input-field col s12 m4">
                            <input id="appointment_date" value="{{$appointment->appt_date}}" type="text" readonly="" required="" class="" name="appt_date">
                            <label for="appointment_date">Appointment Date</label>
                        </div>
                        <div id="appoinment_time">
                            <div class="input-field col s12 m4">
                                <input placeholder="Appointment Start Time" value="{{$appointment->appt_stime}}" id="appointment_stime" type="text" name="appt_stime" class="time start" required="">
                                <label for="appointment_stime">Appointment Start Time</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input placeholder="Appointment End Time" value="{{$appointment->appt_etime}}" id="appointment_etime" type="text" name="appt_etime" class="time end" required="">
                                <label for="appointment_etime">Appointment End Time</label>
                            </div>
                        </div>
                        <div class="input-field col s12 m12">
                            <input id="appointment_title" value="{{$appointment->title}}" type="text" class="validate" required="" name="title">
                            <label for="appointment_title">Appointment Title</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="appointment_description" class="materialize-textarea" required="" name="description">{{$appointment->description}}</textarea>
                            <label for="appointment_description">Appointment Description</label>
                        </div>

                        <div class="input-field col s12 m5 l4">
                            <button data-appointment-id="{{$appointment->id}}" class="btn waves-effect btn-large btn-block waves-light">Update
                                <i class="material-icons right">perm_contact_calendar</i>
                            </button>
                        </div>
                        <div class="input-field col s12 m5 l4">
                            <a href="/teacher/appointments" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
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
<script src="{{ asset('teachatv3/teachers/appointments.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

<script type="application/javascript">
    $(document).ready(function() {
        $('.parent_select').select2();//Initialize Select2 Elements
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
    /*var dateOnlyExampleEl = document.getElementById('dateOnlyExample');
    var dateOnlyDatepair = new Datepair(dateOnlyExampleEl);*/
</script>

@include('teacher.floox-script')

@stop
