@extends('layouts.master')

@section('page_title', 'Create School')

@section('body_content')
<div class="profile-content">
    <div class="row">
        <h4>Add School</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
    </div>
    <div class="div_notif notif"></div>
    <div class="row">
        @if(session('message'))

        <ul class="input-field col s12 m12 green lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">check</i> {{session('message')}} </h6></li></ul>

        @endif

        @if(session('error'))
        <ul class="input-field col s12 m12 red lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">error_outline</i> {{session('error')}} </h6></li></ul>

        @endif
        <form id="form_add_school" file="true" enctype="multipart/form-data" class="row form_add_school">
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" class="select_country" name="country_id" onchange="changeCountry(this)">
                  <option value="" disabled selected>-- Choose a Country --</option>
                  <option value="1">United States</option>
                  <option value="2">Philippines</option>
                </select>
            </div>
            <div class="input-field col s12 m6">
                <select class="icons select_state" aria-required="true" id="state_id" name="state_id" required="" >
                    <option value="" disabled selected>-- Choose a State --</option>
                </select>
            </div>
            <div class="input-field col s12 m12">
                <input id="school_name" type="text" name="school_name" class="validate" required="" aria-required="true">
                <label for="school_name">School Name</label>
            </div>
            <div class="input-field col s12 m12">
                <div class="file-field input-field">
                  <div class="btn">
                    <span>File</span>
                    <input type="file" class="validate" required="required" id="image_inputs" name="school_logo" accept="image/*">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="School logo or badge">
                  </div>
                </div>
            </div>

            <div class="input-field col s12 m12 l6">
                <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
                    <i class="material-icons">person_add</i>
                </button>
            </div>
            <div class="input-field col s12 m5 l6">
                <a href="{{url('admin/schools')}}" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
            </div>
        </form>

    </div>
</div>
@stop

@section('custom-scripts')
        <link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
        <script src="{{ asset('select/select2.full.min.js')}}"></script>
        <script src="{{ asset('teachatv3/admin/school.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('select').material_select();
            });

            function changeCountry(country) {
                $.get('/admin/states/'+country.value, function(data){
                    var model = $('#state_id');
                        model.empty();
                        model.append("<option disabled selected>-- Choose a State --</option>");


                        var output = [];

                        $.each(data.states, function(key, value){

                                model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

                        });
                        model.material_select();
                });
            }


        </script>

@stop
