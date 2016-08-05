@extends('layouts.master')

@section('page_title', 'Announcements')

@section('body_content')
	<div class="row btn-thing">
        <h4>Announcements</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" >
                    <div class="table-header blue-grey lighten-5">
                        Create Announcement to Parents
                    </div>
                    <div class="div_notif notif"></div>
                    <form id="form_add_announcements" accept-charset="utf-8" class="row" style="padding: 10px">
                        <input id="announce_to" type="hidden" value="Parents" name="announce_to" class="validate" required="" aria-required="true">
                        <div class="input-field col s12 m12">
                            <input id="title" type="text" name="title" class="validate" required="" aria-required="true">
                            <label for="title">Title</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <textarea id="announcement" name="announcement" class="validate materialize-textarea" required="" aria-required="true"></textarea>
                            <label for="announcement">Announcment</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="publish_on" type="date" required="" name="publish_on" class="datepicker">
                            <label for="publish_on">Publish on</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="expiration_date" type="date" required="" name="expiration_date" class="datepicker">
                            <label for="expiration_date">Expiration Date</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <button id="btn-add-announcements" class="btn waves-effect btn-large btn-block waves-light">Add <i class="material-icons right">add</i></button>
                        </div>
                    </form>
                </div>
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Announcement
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <div class="ddiv_notif notif"></div>
                    <table class="responsive-table" id="announcements"></table>
                </div>
            </div>
        </div>
    </div>

    <div id="view-announcements" class="modal">
        <div class="modal-content">
            <h5>Announcement to <span id="view_announce_to"></span></h5>

            <div>Title: <span id="view_title"></span></div><br />
            <div>Date Created: <span id="view_created_at"></span></div><br />
            <div>Date of Publishing: <span id="view_publish"></span></div><br />
            <div>Date of Expiry: <span id="view_exp"></span></div><br />
            <div>From: <span id="view_from"></span> & <span id="view_school"></span></div><br />

            Announcement: <div id="view_announcement"></div>

        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
        </div>
    </div>

    <div id="edit-announcements" class="modal edit-announcements">
        <div class="modal-content">
            <h5>Edit Announcement</h5>
            <div class="div_notif notif"></div>
            <form id="form_edit_announcements" accept-charset="utf-8" class="row form_edit_announcements" >

                <div class="input-field col s12 m12">
                    <select name="announce_to" id="eannounce_to" class="eannounce_to">
                        <option id="0" value="0" disabled>-- Announce To --</option>
                        <option id="all" value="1">All</option>
                        <option id="teachers" value="2">Teachers</option>
                        <option id="parents" value="3">Parents</option>
                    </select>
                </div>
                <div class="input-field col s12 m12">
                    <input id="etitle" type="text" name="title" class="validate" required="" aria-required="true">
                    <label for="title">Title</label>
                </div>
                <div class="input-field col s12 m12">
                    <textarea id="eannouncement" name="announcement" class="validate materialize-textarea" required="" aria-required="true"></textarea>
                    <label for="announcement">Announcement</label>
                </div>

		        <div class="pull-right">
		            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat freakin-modal">Close</a>
		            <button class="modal-action btn waves-effect waves-light btn-update-announcements">Save</button>
		        </div>
		    </form>
	    </div>
    </div>

    <div id="delete-announcements" class="modal">
        <div class="modal-content">
            <h5>Delete Anouncement</h5>
            Do you want to delete this announcement?
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn waves-effect waves-light btn-delete-yes-announcements">Yes</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
        </div>
    </div>


@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/teachers/announcements.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
        $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
    });
</script>

@include('teacher.floox-script')

@stop
