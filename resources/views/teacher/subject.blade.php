@extends('layouts.master')

@section('page_title', 'Subjects')

@section('body_content')
    <div class="row btn-thing">
        <h4>Subjects</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" >
                    <div class="table-header blue-grey lighten-5">Add Subject</div>
                    <div class="div_notif notif"></div>
                    <form id="form_add_subjects" accept-charset="utf-8" class="row" style="padding: 10px">
                       <div class="input-field col s12 m9">
                            <select required="" aria-required="true" name="subject_id" id="subject_id">
                                <option value="0" disabled selected>-- Choose a Subject --</option>
                                @foreach($subjects as $s)
                                    <option value="{{$s['id']}}">{{$s['grades']['description']}} - {{$s['subject_category']['description']}} - {{$s['subject']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-field col s12 m3">
                            <button id="btn-add-subjects" class="btn waves-effect btn-large btn-block waves-light">Add <i class="material-icons right">add</i></button>
                        </div>
                    </form>
                </div>
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Subjects
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <div class="ddiv_notif notif"></div>
                    <table class="responsive-table" id="subjects"></table>
                </div>
            </div>
        </div>
    </div>
    <div id="edit-subjects" class="modal edit-subjects">
        <div class="modal-content">
            <h5>Edit Subject</h5>
            <div class="ediv_notif notif"></div>
            <form id="form_edit_subjects" accept-charset="utf-8" class="row form_edit_subjects" >
                <div class="input-field col s12 m12">
                    <input id="esubject_id" type="hidden" name="subject_id" class="validate" required="" aria-required="true">
                    <input id="esubject" type="text" name="description" class="validate" required="" aria-required="true">
                    <label for="subjects">Subject</label>
                </div>
                <div class="pull-right">
                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat freakin-modal">Close</a>
                    <button class="modal-action btn waves-effect waves-light btn-update-subjects">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-subjects" class="modal">
        <div class="modal-content">
            <h5>Delete Subject</h5>
            Do you want to delete this subject?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-subjects">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>


@stop

@section('custom-scripts')

    <link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
    <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
    <script src="{{ asset('teachatv3/teachers/subjects.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
        $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
    });
</script>

@stop
