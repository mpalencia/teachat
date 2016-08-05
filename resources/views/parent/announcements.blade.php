@extends('layouts.master')

@section('page_title', 'Announcements')

@section('body_content')
	<div class="row btn-thing">
        <h4>Announcements</h4>
        <span class="divider"></span>
        <div class="divider"></div><br/>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="table-header blue-grey lighten-5">List of Announcement
                        <div class="actions">
                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                        </div>
                    </div>
                    <table class="responsive-table" id="announcements"></table>
                </div>
            </div>
        </div>
    </div>

    <div id="view-announcements" class="modal">
        <div class="modal-content">
            <h5>Announcement</h5>

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

@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/parents/announcements.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

@include('parent.floox-script')

@stop
