<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Startmin - Bootstrap Admin Theme</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="{{ asset('css/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="{{ asset('css/dataTables/dataTables.responsive.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/startmin.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Staff Grading</a>
                </div>

                {{-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> --}}

                <ul class="nav navbar navbar-top-links">
                    <li><a href="{{ route('departments.index') }}"><i class="fa fa-home fa-fw"></i> Departments </a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-pencil fa-fw"></i> Entries <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ route('entries.index') }}"><i class="fa fa-eye fa-fw"></i>View Entries</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ route('entries.create') }}"><i class="fa fa-plus fa-fw"></i> Add Entries</a>
                            </li>
                            {{-- <li class="divider"></li> --}}
                            {{-- <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li> --}}
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                {{-- <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                            </li>
                            <li>
                                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div> --}}
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper" style="margin:auto">
                <div class="container">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        
        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>
    </body>
</html>
