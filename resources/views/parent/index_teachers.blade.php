@extends('layouts.master')

@section('page_title', 'List of Teacher')

@section('body_content')
                    <div class="row btn-thing">
                        <h4>Teachers of {{$child['first_name']}} {{$child['last_name']}}</h4>
                        <span class="divider"></span>
                        <div class="divider"></div><br/>
                        <div class="row">
                            <div id="admin" class="col s12">
                                <div class="card material-table">
                                    <div class="table-header blue-grey lighten-5">List of Teachers
                                        <div class="actions">
                                        
                                        <a href="{{url('parent/children/teachers/create'). '/' . $child['id']}}" class="waves-effect btn-flat nopadding tooltipped" data-position="left" data-tooltip="Add Teacher">Add <i class="material-icons">playlist_add</i></a>
                                            <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                                        </div>
                                    </div>
                                    <table class="responsive-table" id="teachers_subjects">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Subject Category</th>
                                                <th>Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teachers as $teacher)
                                            <tr class="child_on_list" id="{{ $teacher['id'] }}">
                                                <td>
                                                    @if($teacher['teacher']['profile_img'] == 'dp.png')
                                                        <img src="{{asset('/images/dp.png')}}" alt="" class="circle responsive-img" style="max-width: 40%">
                                                    @else
                                                        <img src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{$teacher['teacher']['profile_img']}}" alt="" class="circle responsive-img" style="max-width: 40%">
                                                    @endif
                                                </td>
                                                <td>{{$teacher['teacher']['first_name']}} {{$teacher['teacher']['last_name']}}</td>
                                                <td>{{$teacher['curriculum']['subject_category']['description']}}</td>
                                                <td>{{$teacher['curriculum']['subject']}}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="child_id" name="child_id" value="{{$child['id']}}" disabled="" required="" aria-required="true">
                                </div>
                            </div>
                        </div>
                    </div>



@stop

@section('custom-scripts')
    <link href="{{asset('dataTable/jquery.dataTables_.css')}}" rel="stylesheet">
    <script src="{{ asset('dataTable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('dataTable/jquery.dataTables_.min.js')}}"></script>
    <script src="{{ asset('teachatv3/parents/children.js')}}"></script>
    <script src="{{ asset('teachatv3/teachatv3.js')}}"></script>

    @include('parent.floox-script')

@stop
