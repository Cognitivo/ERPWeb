<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="ERP" name="description" />
        <meta content="Cognitivo Paraguay" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url()}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{url()}}/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{url()}}/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{url()}}/assets/layouts/normal/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/layouts/normal/css/themes/light2.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{url()}}/assets/layouts/normal/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="{{url()}}/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">
    </head>
    <!-- END HEAD -->
    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER MENU -->
                        <div class="page-header-menu">
                            <div class="container">
                                <!-- BEGIN HEADER SEARCH BOX -->
                                <form class="search-form" action="page_general_search.html" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="query">
                                        <span class="input-group-btn">
                                            <a href="javascript:;" class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </a>
                                        </span>
                                    </div>
                                </form>
                                <!-- END HEADER SEARCH BOX -->
                                <div class="hor-menu  ">
                                    <ul class="nav navbar-nav">
                                        <li>
                                            <img height="38px" src="{{url()}}/assets/global/img/CognitivoLogo.png"
                                                 alt="logo" class="logo-default" style="vertical-align:center; margin-top:5px;" >
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown active">
                                            <a href="javascript:;"> Dashboard
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class=" active">
                                                    <a href="{{url('/')}}" class="nav-link  active">
                                                        <i class="icon-bar-chart"></i> Launch
                                                        <span class="badge badge-success">1</span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="{{url('managecomponents')}}" class="nav-link  ">
                                                        <i class="icon-bulb"></i> Manage </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown  ">
                                            <a href="javascript:;"> Statistics
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left" style="min-width: 710px" id="components">

                                            </ul>
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                            <a href="javascript:;"> Commercial
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class="">
                                                    <a href="{{url()}}/customers" class="nav-link">Customers</a>
                                                </li>
                                                <li class="">
                                                    <a href="{{url()}}/suppliers" class="nav-link">Suppliers</a>
                                                </li>

                                                <hr/>

                                                <li class="">
                                                    <a href="{{ route('contacts.index') }}" class="nav-link">Contacts</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <!-- END MEGA MENU -->
                            </div>
                        </div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container">
                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title">
                                        <h1>@yield('Title')</h1>
                                    </div>
                                    <!-- END PAGE TITLE -->
                                    <!-- BEGIN PAGE TOOLBAR -->
                                    <div class="page-toolbar">

                                    </div>
                                    <!-- END PAGE TOOLBAR -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">
                                    <!-- BEGIN PAGE BREADCRUMBS -->
                                    <ul class="page-breadcrumb breadcrumb">
                                        <li>
                                            <a href="index.html">Home</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <span>@yield('Title')</span>
                                        </li>
                                    </ul>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->

                                    <div class="page-content-inner">
                                      @section('innercontent')
                                      @show
                                       @yield('content')
                                    </div>

                                    <!-- END PAGE CONTENT INNER -->
                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->
                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>
            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                    <!-- BEGIN FOOTER -->

                    <!-- END PRE-FOOTER -->
                    <!-- BEGIN INNER FOOTER -->
                    <div class="page-footer">
                        <div class="container"> 2016 &copy; Cognitivo</div>
                    </div>
                    <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                    </div>
                    <!-- END INNER FOOTER -->
                    <!-- END FOOTER -->
                </div>
            </div>
        </div>
        <!--[if lt IE 9]>
<script src="{{url()}}/assets/global/plugins/respond.min.js"></script>
<script src="{{url()}}/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{url()}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->


        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url()}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        {{-- <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> --}}
         {{-- chart js --}}
         <script src="{{url()}}/assets/global/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/chartjs/Chart.bundle.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{url()}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url()}}/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/pages/scripts/add-dashboard-components.js" type="text/javascript"></script>
        <script src='{{url()}}/assets/pages/scripts/components-date-time-pickers.js' type="text/javascript"></script>
        @section('pagescripts')
        @show
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{url()}}/assets/layouts/normal/scripts/layout.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/layouts/normal/scripts/demo.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="{{url()}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->

        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url()}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
</body>


</html>
