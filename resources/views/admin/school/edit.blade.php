@extends('layouts.master')

@section('page_title', 'Edit School')

@section('body_content')
<div class="profile-content">
    <div class="row">
        <h4>Edit School</h4>
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
        <form id="form_edit_school" file="true" enctype="multipart/form-data" class="row form_edit_school">
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" class="select_country" name="country_id" onchange="changeCountry(this)">
                @foreach($country as $c)
                <option value="{{$c['id']}}" <?php if ($school['country_id'] == $c['id']): ?> selected <?php endif;?> >{{$c['name']}}</option>
                @endforeach

                </select>
            </div>
            <div class="input-field col s12 m6">
                <select class="icons select_state" aria-required="true" id="state_id" name="state_id" required="" >
                    @foreach($states as $state)
                    <option value="{{$state['id']}}" <?php if ($state['id'] == $school['state_id']): ?> selected <?php endif;?>>{{$state['state_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col s12 m12">
                <input id="school_name" type="text" name="school_name" value="{{$school['school_name']}}" class="validate" required="" aria-required="true">
                <label for="school_name">School Name</label>
            </div>
            <div class="input-field col s12 m10">
                <div class="file-field input-field">
                  <div class="btn">
                    <span>File</span>
                    <input type="file" class="validate" name="school_logo_temp" id="image_inputsedit" accept="image/*">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="School logo or badge">
                  </div>
                </div>
            </div>
            <div class="col s2 m2">
                <small style="margin-top: -5px !important; display: block;">Current Badge</small>
                <figure class="school_badge" style="background-image: url('{{asset('/images/school_badges')}}/{{ $school['school_logo']  }}'); width: 70px; height: 70px;"></figure>
            </div>
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" class="select_active" name="active")">
                    <option value="1" <?php if ($school['active'] == 1): ?> selected <?php endif;?>>Active</option>
                    <option value="0" <?php if ($school['active'] == 0): ?> selected <?php endif;?>>Inactive</option>
                </select>
            </div>
            <div class="input-field col s12 m12">
            </div>
            <div class="input-field col s12 m12 l6">
                <button class="btn waves-effect btn-large btn-block waves-light" data-id="{{$school['id']}}" type="submit">Update
                    <i class="material-icons">edit</i>
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
                    $('option', '#state_id').remove();
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
