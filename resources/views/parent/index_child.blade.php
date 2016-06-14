@extends('layouts.master')

@section('page_title', 'Child List')

@section('body_content')
                    <div class="profile-content">
                        <div class="row">
                            <h4>Child / Children</h4>
                            <span class="divider"></span>
                            <div class="divider"></div><br/>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header blue-grey lighten-5">
                                            <div class="actions">
                                                <a href="{{url('parent/child/create')}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Child">Add <i class="material-icons">playlist_add</i></a>
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Birthdate</th>
                                                    <th>Age</th>
                                                    <th>Grade / Section</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($children as $child)
                                                    <tr class="child_on_list" id="{{ $child['last_name'] }}" >
                                                        <td>{{ $child['first_name'] }} {{ $child['middle_name'] }} {{ $child['last_name'] }}</td>
                                                        <td title="System">{{ $child['birthdate'] }}</td>
                                                        <td>{{date('Y') - explode("-", $child['birthdate'])[0]}}</td>
                                                        <td> {{ $child['grade_id'] }} - {{ $child['section'] }}</td>
                                                        <td>
                                                            <a class="btn-flat dropdown-button waves-effect" data-beloworigin="true" href="javascript:void(0)" data-activates="{{ $child['id'] }}"><i class="large material-icons">settings</i></a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='{{ $child["id"] }}' class='dropdown-content'>
                                                                <li><a href="{{url('parent/child'). '/' . $child['id'] . '/edit'}}"><i class="material-icons">edit</i> Edit</a></li>
                                                                <li><a href="#delete_child_modal" class="waves-effect waves-light modal-trigger" data-id="{{ $child['id'] }}" data-name="{{ $child['first_name'] }} {{ $child['middle_name'] }} {{ $child['last_name'] }}" ><i class="material-icons">delete</i>Delete</a></li>
<!--                                                                 if($upload === 1)
                                                                    <li><a href="#file_upload" class="modal-trigger_ waves-effect waves-light teal white-text" data-id="{{ $child['id'] }}" data-name="{{ $child['first_name'] }} {{ $child['middle_name'] }} {{ $child['last_name'] }}" ><i class="material-icons">attach_file</i> Files</a></li>
                                                                endif -->
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div id="delete_child_modal" class="modal">
                        <div class="modal-content">
                            <center>
                                <h5 class="child_name">Name of Child here.</h5>
                                <div class="divider"></div>
                                <h5>Will be deleted from the entries.</h5>
                                <h5>Are you sure?</h5>
                            </center>
                            <div class="row">
                                <div class="input-field col s12 m4 offset-m2">
                                    <a href="#!" class="btn waves-effect btn-large btn-block waves-light btn_yes_delete">Yes <i class="material-icons right">check</i></a>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="#!" class="modal-action modal-close btn waves-effect btn-large btn-block waves-light red">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal For Attachemnt List-->
                    <div id="file_upload" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h5 class="child_name">( Name of Child here )</h5>
                            <ul class="collection with-header">
                                <li class="collection-item">
                                    <div>
                                        File Name
                                        <a href="#!" class="secondary-content btn_downloadFileById"><i class="material-icons waves-effect waves-green">system_update_alt</i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer teal darken-4">
                            <a href="#file_attach" class="waves-effect waves-light btn modal-action modal-close">Close</a>
                        </div>
                    </div>
@stop

@section('custom-scripts')

<link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
<script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
<script src="{{ asset('teachatv3/teachers/announcements.js')}}"></script>
<script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

@stop
