@extends('layouts.master')

@section('page_title', 'Manage Locations')

@section('body_content')
<div class="profile-content">
    <div class="row">
        <h4>Manage Locations</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div class="row hide" id="add_location">
                <form id="add-new_state" accept-charset="utf-8">
                    <div class="input-field col s12 m4">
                        <select name="country_id" required="required" onchange="changeCountry(this)">
                            <option value="" disabled selected>Country</option>
                            @foreach($country as $country_)
                                <option value="{{ $country_['id'] }}">{{ $country_['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="state_region" type="text" class="validate" required="required" name="state_name">
                        <label id="state_add" for="state_region">Region / State</label>
                    </div>

                    <div id="code_add" class="input-field col s12 m4">
                        <input id="state_code" type="text" class="validate" name="state_code">
                        <label for="state_code">State Code</label>
                    </div>

                    <div class="input-field col s12 m4">
                        <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Add
                            <i class="material-icons right">add</i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="row hide" id="edit_location">
                <form id="edit_location_form" accept-charset="utf-8">
                    <div class="input-field col s12 m4">
                        <select id="count" name="country_id" required="required" class="chosen-select" onchange="changeCountryEdit(this)">
                            @foreach($country as $country_)
                                <option value="{{ $country_['id'] }}">{{ $country_['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="state_region_edit" type="text" class="validate" required="required" name="state_name">
                        <label id="state_edit" for="state_region_edit">Region / State</label>
                    </div>

                    <div id="code_edit" class="input-field col s12 m4">
                        <input id="state_code_edit" type="text" class="validate" name="state_code">
                        <label for="state_code_edit">State Code</label>
                    </div>

                    <input type="hidden" name="id" id="editing_id">
                    <div class="input-field col s12 m4">
                        <button class="btn waves-effect btn-large btn-block waves-light orange" type="submit">Save
                            <i class="material-icons right">check</i>
                        </button>
                    </div>
                </form>
            </div>


            <div id="location" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">
                        <!-- <div class="actions">
                            <a href="{{url('admin/school-admin/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add School">Add <i class="material-icons">playlist_add</i></a>
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div> -->
                    </div>
                    <table id="locations" class="responsive-table">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Delete -->
    <div id="delete_location_modal" class="modal delete_location_modal">
        <div class="modal-content">
            <center>
                <h5 class="child_name" id="state_n">Name of Child here.</h5>
                <div class="divider"></div>
                <h5>Will be deleted from the entries.</h5>
                <h5>Are you sure?</h5>
            </center>
            <div class="row">
                <div class="input-field col s12 m4 offset-m2">
                    <a href="" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete" id="del">Yes <i class="material-icons right">check</i></a>
                </div>
                <div class="input-field col s12 m4">
                    <a href="" class= "btn waves-effect btn-large btn-block waves-light red modal-action modal-close">Cancel</a>
                </div>
            </div>
        </div>
    </div>

@stop

@section('custom-scripts')

<link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables_.css')}}">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>
<script src="{{ asset('teachatv3/admin/location.js')}}"></script>
<script type="text/javascript">
    $('select').material_select();
    $('#add_location').removeClass("hide");
</script>
@stop
