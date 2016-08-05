@extends('layouts.master')

@section('page_title', 'Edit School Admin')

@section('body_content')
<div class="profile-content">
    <div class="row">
        <h4>Edit School Admin</h4>
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
        <form id="form_edit_principal" files="true" enctype="multipart/form-data" accept-charset="utf-8" class="row form_edit_principal" method="PUT">
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" class="select_country" name="country_id" onchange="changeCountry(this)">
                    <option value="" disabled selected>-- Choose a Country --</option>
                    @foreach($country as $c)
                    <option <?php if ($principal['country_id'] == $c['id']): ?> selected="selected" <?php endif;?> value="{{$c['id']}}">{{$c['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col s12 m6">
                <select class="icons select_state" aria-required="true" id="state_id" name="state_id" required="" onchange="changeState(this)">
                     @foreach($states as $state)
                    <option value="{{$state['id']}}" <?php if ($state['id'] == $principal['state_id']): ?> selected <?php endif;?>>{{$state['state_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col s12 m12">
                <input type="hidden" readonly="" value="{{$principal['id']}}" name="user_id">
                <select required="" aria-required="true" class="select_school" name="school_id")" id="school_id">
                    <option value="" disabled selected>-- Choose a School --</option>
                    @foreach($schools as $school)
                    <option <?php if ($principal['school_id'] == $school['id']): ?> selected="selected" <?php endif;?> value="{{$school['id']}}">{{$school['school_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col l4 m4 s12">
                <input value="4" type="hidden" class="validate" required="" aria-required="true" name="role_id">
                <input id="f_name" type="text" value="{{$principal['first_name']}}" class="validate" required="" aria-required="true" name="first_name">
                <label for="f_name">First Name</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input id="m_name" type="text" value="{{$principal['middle_name']}}" class="validate" name="middle_name">
                <label for="m_name">Middle Name</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input id="l_name" type="text" value="{{$principal['last_name']}}" class="validate" required="" aria-required="true" name="last_name">
                <label for="l_name">Last Name</label>
            </div>

            <div class="input-field col s12 m6">
                <input id="email" type="email" class="validate" value="{{$principal['email']}}" required="" aria-required="true" name="email">
                <label for="email">Email</label>
            </div>
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" class="select_active" name="active")">
                    <option value="1" <?php if ($principal['active'] == 1): ?> selected <?php endif;?>>Active</option>
                    <option value="0" <?php if ($principal['active'] == 0): ?> selected <?php endif;?>>Inactive</option>
                </select>
            </div>

            <div class="input-field col s12 m12 l6">
                <button class="btn waves-effect btn-large btn-block waves-light" data-principal-id="{{$principal['id']}}" type="submit">Edit
                    <i class="material-icons">update</i>
                </button>
            </div>
            <div class="input-field col s12 m5 l6">
                <a href="{{url('admin/school-admin')}}" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('custom-scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('select/select2.css')}}">
    <script src="{{ asset('select/select2.full.min.js')}}"></script>
    <script src="{{ asset('teachatv3/admin/principals.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });

        function changeCountry(country) {
            $.get('/admin/states/'+country.value, function(data){
                var model = $('#state_id');
                    $('#school_id').empty();
                    $('#school_id').append("<option disabled selected>-- Choose a School --</option>");
                    model.empty();
                    model.append("<option disabled selected>-- Choose a State --</option>");

                    var output = [];

                    $.each(data.states, function(key, value){

                        model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

                    });
                    model.material_select();
                    $('#school_id').material_select();
            });
        }

        function changeState(state) {
            $.get('/admin/schools/'+state.value, function(data){
                var model = $('#school_id');
                    model.empty();
                    model.append("<option disabled selected>-- Choose a School --</option>");

                    var output = [];

                    $.each(data.schools, function(key, value){

                        model.append("<option value='"+ value.id +"'>" + value.school_name + "</option>");

                    });
                    model.material_select();
            });
        }
    </script>

@stop
