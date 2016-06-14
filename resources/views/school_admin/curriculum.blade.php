@extends('layouts.master')

@section('page_title', 'Curriculum')

@section('body_content')
<div class="row btn-thing">
    <h4>School Curriculum</h4>
    <span class="divider"></span>
    <div class="divider"></div><br/>
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table" >
                <div class="table-header blue-grey lighten-5">
                    Add Curriculum
                </div>
                <div class="div_notif notif"></div>
                <form id="form_add_curriculum" accept-charset="utf-8" class="row" style="padding: 10px">
                    <div class="input-field col s12 m6">
                        <select required="" aria-required="true" name="grade_id" id="grade_id">
                            <option value="0" disabled selected>-- Choose a Grade --</option>
                            @foreach($grades as $g)
                                <option value="{{$g['id']}}">{{$g['description']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <select required="" aria-required="true" name="subject_category_id" id="subject_category_id">
                            <option value="0" disabled selected>-- Choose a Subject Category --</option>
                            @foreach($subjectCategory as $s)
                                <option value="{{$s['id']}}">{{$s['description']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m12">
                        <input type="text" name="subject" id="subject" class="validate" required="" aria-required="true">
                        <label for="subject">Subject</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <button id="btn-add-curriculum" class="btn waves-effect btn-large btn-block waves-light">Add <i class="material-icons right">add</i></button>
                    </div>
                </form>
            </div>
            <div class="card material-table">
                <div class="table-header blue-grey lighten-5">List of Curriculum
                    <div class="actions">
                        <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                    </div>
                </div>
                <div class="ddiv_notif notif"></div>
                <table class="responsive-table" id="curriculum"></table>
            </div>
        </div>
    </div>
</div>
<div id="edit-curriculum" class="modal edit-curriculum">
    <div class="modal-content">
        <h5>Edit Curriculum</h5>
        <div class="div_notif notif"></div>
        <form id="form_edit_curriculum" accept-charset="utf-8" class="row form_edit_curriculum" >
        	<input type="hidden" class="data_curriculum_id" name="curriculum_id">
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" name="grade_id" id="egrade_id">
                    <option value="" disabled selected>-- Choose a Grade --</option>
                    @foreach($grades as $g)
                        <option value="{{$g['id']}}">{{$g['description']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col s12 m6">
                <select required="" aria-required="true" name="subject_category_id" id="esubject_category_id">
                    <option value="" disabled selected>-- Choose a Subject Category --</option>
                    @foreach($subjectCategory as $s)
                        <option value="{{$s['id']}}">{{$s['description']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-field col s12 m12">
                <input id="esubject" type="text" name="subject" class="validate" required="" aria-required="true">
                <label for="subject">Subject</label>
            </div>
            <div class="pull-right">
            	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat freakin-modal">Close</a>
        		<button class="modal-action btn waves-effect waves-light btn-update-curriculum">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-curriculum" class="modal">
    <div class="modal-content">
        <h5>Delete Subject</h5>
        Do you want to delete this subject?
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-curriculum">Yes</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
    </div>
</div>
@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/school-admin/curriculum.js')}}"></script>

@stop
