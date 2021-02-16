@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Staff Appraisal Window</h1>
        </div>
    </div>
    @include("notification")
    <!-- /.row -->
    <div class="row">
        <form role="form" action="{{ route('entries.store') }}" method="POST">
            @csrf
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Staff Information
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" value="{{ auth()->user()->name}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" value="{{ auth()->user()->email }}"  class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input name="phone" value="{{ auth()->user()->phone }}"  class="form-control" type="number" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department_id" onchange="loadDepartmentEntry(this)">
                                        <option value="">-- Select Department --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" @if (strtolower(Request::get('department')) == strtolower($department->name) || old('department_id') == $department->id) selected @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Staff Appraisal Score Sheet
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- <form role="form"> --}}
                                <div class="col-md-6">
                                    @php $fields = ['punctuality', 'professionalism', 'innovation', 'respect', 'communication',]@endphp
                                    @foreach ($fields as $field)
                                        
                                        <div class="form-group">
                                            <label>{{ ucfirst($field) }}</label>
                                            <select class="form-control" name="{{ $field }}" required>
                                                <option value="">Select Score</option>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <option value="{{ $i }}" @if (!empty($entry) && $entry->$field == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    @php $fields = ['management', 'leadership', 'delivery', 'inclusiveness', 'appearance',]@endphp
                                    @foreach ($fields as $field)
                                        
                                        <div class="form-group">
                                            <label>{{ ucfirst($field) }}</label>
                                            <select class="form-control" name="{{ $field }}" required>
                                                <option value="">Select Score</option>
                                                @for ($i = 1; $i < 6; $i++)
                                                <option value="{{ $i }}" @if (!empty($entry) && $entry->$field == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary"> @if(!empty($entry)) Update @else Submit @endif </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection

@section('js')
    <script>
        function loadDepartmentEntry(e) {
            if (e.value == '') return false;
            var department = e.options[e.selectedIndex].text.toLowerCase();
            
            window.location.replace(`create?department=${department}`);
        }
    </script>
@endsection