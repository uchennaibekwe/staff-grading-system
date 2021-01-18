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
                return 'c';
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
                                    <th>User</th>
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
                                        <td>{{ $entry->user->name }}</td>
                                        @foreach ($fields as $field)
                                            <td class="center">{{ $entry->$field }}</td>
                                        @endforeach
                                        {{-- <td class="center">{{ $entry->punctuality }}</td>
                                        <td class="center">1.5</td>
                                        <td class="center">4.5</td> --}}
                                        <td class="center">{{ $entry->total}}</td>
                                        <td class="center">{{ $entry->average}}</td>
                                        <td class="center">{{ $entry->percentage}}%</td>
                                        <td class="center">{{ $entry->grade }}</td>
                                    </tr>
                                @endforeach
                                {{-- <tr class="gradeA">
                                    <td>Obinna</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">4.5</td>
                                    <td class="center">12%</td>
                                    <td class="center">A</td>
                                </tr>
                                <tr class="gradeA">
                                    <td>Chinedu</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">4.5</td>
                                    <td class="center">12%</td>
                                    <td class="center">A</td>
                                </tr>
                                <tr class="gradeA">
                                    <td>Chika</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">1.5</td>
                                    <td class="center">4.5</td>
                                    <td class="center">12%</td>
                                    <td class="center">A</td>
                                </tr> --}}
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
    @endif
@endsection