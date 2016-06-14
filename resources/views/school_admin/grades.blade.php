@extends('layouts.master')

@section('page_title', 'Grades')

@section('body_content')
    <div class="row btn-thing">
        <h4>Grades</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" >
                    <div class="table-header blue-grey lighten-5">
                        Add Grade
                    </div>
                    <div class="div_notif notif"></div>

                    <form id="form_add_grades" accept-charset="utf-8" class="row" style="padding: 10px">
                        <div class="input-field col s12 m9">
                            <input id="grade" type="text" name="description" class="validate" required="" aria-required="true">
                            <label for="grades">Grade</label>
                        </div>

                        <div class="input-field col s12 m3">
                            <button id="btn-add-grades" class="btn waves-effect btn-large btn-block waves-light">Add <i class="material-icons right">add</i></button>
                        </div>
                    </form>
                </div>
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Grades
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <div class="ddiv_notif notif"></div>
                    <table class="responsive-table" id="grades"></table>
                </div>
            </div>
        </div>
    </div>
    <div id="edit-grades" class="modal edit-grades">
        <div class="modal-content">
            <h5>Edit Grade</h5>
            <div class="ediv_notif notif"></div>
            <form id="form_edit_grades" accept-charset="utf-8" class="row form_edit_grades" >
                <div class="input-field col s12 m12">
                    <input id="egrade_id" type="hidden" name="grade_id" class="validate" required="" aria-required="true">
                    <input id="egrade" type="text" name="description" class="validate" required="" aria-required="true">
                    <label for="grades">Grade</label>
                </div>
                <div class="pull-right">
                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat freakin-modal">Close</a>
                    <button class="modal-action btn waves-effect waves-light btn-update-grades">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-grades" class="modal">
        <div class="modal-content">
            <h5>Delete Grade</h5>
            Do you want to delete this grade?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-grades">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>


@stop

@section('custom-scripts')

    <link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
    <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
    <script src="{{ asset('teachatv3/school-admin/grades.js')}}"></script>

@stop
