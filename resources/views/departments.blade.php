@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Departments</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @include('notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Create Department
                </div>
                <!-- /.panel-heading -->
                <form action="{{ route('departments.store') }}" method="post" class="form-inline">
                    @csrf
                    <div class="panel-body text-center">
                        <div class="form-group">
                            {{-- <label>Department Name: </label> --}}
                            <input name="name" class="form-control col-md-6" placeholder="Department Name" autofocus required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create Department</button>
                    </div>
                </form>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    List of Departments
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>No. of Entries</th>
                                    <th>Created On</th>
                                    {{-- <th>No of Users</th> --}}
                                    <!-- <th>Over all grade</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr class="gradeA">
                                        <td>{{ $department->name }}</td>
                                        <td>{{ $department->entries->count() }}</td>
                                        <td class="center">{{ date('F d, Y', strtotime($department->created_at)) }}</td>
                                        <!-- <td class="center">A</td> -->
                                    </tr>
                                @endforeach
                                {{-- <tr class="gradeA">
                                    <td>Food</td>
                                    <td class="center">1.6</td>
                                    <!-- <td class="center">A</td> -->
                                </tr>
                                <tr class="gradeA">
                                    <td>Transport</td>
                                    <td class="center">1.7</td>
                                    <!-- <td class="center">B</td> -->
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
@endsection