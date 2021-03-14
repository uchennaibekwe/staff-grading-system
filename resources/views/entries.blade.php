@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Staff Appraisal Summary</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @include('notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Search Appraisal Entries by Department
                </div>
                <!-- /.panel-heading -->
                <form action="{{ route('entries.index') }}" method="get" class="form-inline">
                    <div class="panel-body text-center">
                        <div class="center">
                            <div class="form-group">
                                {{-- <label> Select Department: </label> --}}
                                <select class="form-control col-md-6" name="department" required>
                                    <option value="">-- Select a Department --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->name }}" @if(Request::get('department') == $department->name) selected @endif>{{ $department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Search Department</button>
                        </div>
                    </div>
                </form>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->
    @if (null !== Request::get('department'))

    @php
        function computeGrade($average) {
            if ($average >= 80)
                return 'A';
            else if ($average >= 65)
                return 'B';
            else if ($average >= 55)
                return 'C';
            else if ($average >= 40)
                return 'D';
            else if ($average >= 30)
                return 'E';
            else 
                return 'F';
        }
    @endphp 
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $entries->count()}}</div>
                            <div>Total Users</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">No of users in {{ Request::get('department') }} department</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-circle fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $entries->sum('total')}}</div>
                            <div>Grand Total</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Overall total obtained</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-percent fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $average = $entries->sum('total') == 0  ? 0 : $entries->sum('percentage') / $entries->count() }}%</div>
                            <div>Percentage</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Overall percentage obtained</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-graduation-cap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ computeGrade($average) }}</div>
                            <div>Grade</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Average Grade</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Overview of <b>{{ Request::get('department') }}</b> Department
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        @php $fields = ['punctuality', 'professionalism', 'innovation', 'respect', 'communication', 'management', 'leadership', 'delivery', 'inclusiveness', 'appearance',]@endphp
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>User</th>
                                    <th>Status</th>
                                        @foreach ($fields as $field)
                                            <th>{{ ucfirst($field) }}</th>
                                        @endforeach
                                    <th>Total</th>
                                    <th>Avg</th>
                                    <th>%</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr class="gradeA">
                                        <td>
                                            <a href="{{ route('entries.create', ['user' => $entry->user, 'department' => Request::get('department')]) }}">
                                                <i class="btn btn-primary fa fa-pencil"></i>
                                            </a>
                                            <i class="btn btn-success fa fa-check" data-toggle="modal" data-target="#modalId" onclick="markAsClose({{ $entry }})"></i>
                                        </td>
                                        <td>{{ $entry->user->name }}</td>
                                        <td class="{{ $entry->closed ? 'bg-success' : 'bg-danger'}}">{{ $entry->closed ? 'done' : 'ongoing' }}</td>
                                        @foreach ($fields as $field)
                                            <td class="center">{{ $entry->$field }}</td>
                                        @endforeach
                                        <td class="center">{{ $entry->total}}</td>
                                        <td class="center">{{ $entry->average}}</td>
                                        <td class="center">{{ $entry->percentage}}%</td>
                                        <td class="center">{{ $entry->grade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="modal fade" id="modalId">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Comment [<i id="selectedUser"></i>]</h5>
            </div>
            <form action="{{ route('entries.closed') }}" method="post">
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="selectedEntryId">
                    <textarea name="comment" id="comment" placeholder="Enter comment" class="form-control" rows=""cols="30" rows="30"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      1
      
    @endif
@endsection

@section('js')
    <script>
        function markAsClose(entry) {
            console.log(entry);
            document.getElementById('selectedEntryId').value = entry.id;
            document.getElementById('selectedUser').innerHTML = entry.user.name;
            document.getElementById('comment').innerHTML = entry.comment;
        }
    </script>
@endsection