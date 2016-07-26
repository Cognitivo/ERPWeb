<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Cognitivo | Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
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
        <link href="{{url()}}/assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url()}}/assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{url()}}/assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
                            <div class="container">
                                <!-- BEGIN LOGO -->
                                <div class="page-logo">
                                    <a href="#">
                                        <img style="padding-bottom:10px" height="50px" src="{{url()}}/assets/global/img/CognitivoLogo.png" alt="logo" class="logo-default">
                                    </a>
                                </div>
                                <!-- END LOGO -->
                                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <a href="javascript:;" class="menu-toggler"></a>
                                <!-- END RESPONSIVE MENU TOGGLER -->
                                <!-- BEGIN TOP NAVIGATION MENU -->
                                <div class="top-menu">
                                    <ul class="nav navbar-nav pull-right">
                                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                                        <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="icon-bell"></i>
                                                <span class="badge badge-default">7</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="external">
                                                    <h3>You have
                                                        <strong>12 pending</strong> tasks</h3>
                                                    <a href="app_todo.html">view all</a>
                                                </li>
                                                <li>
                                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">just now</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-success">
                                                                        <i class="fa fa-plus"></i>
                                                                    </span> New user registered. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">3 mins</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </span> Server #12 overloaded. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">10 mins</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-warning">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </span> Server #2 not responding. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">14 hrs</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </span> Application error. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">2 days</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </span> Database overloaded 68%. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">3 days</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </span> A user IP blocked. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">4 days</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-warning">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </span> Storage Server #4 not responding dfdfdfd. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">5 days</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </span> System Error. </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="time">9 days</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </span> Storage server failed. </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END NOTIFICATION DROPDOWN -->
                                        <!-- BEGIN TODO DROPDOWN -->
                                        <li class="dropdown dropdown-extended dropdown-tasks dropdown-dark" id="header_task_bar">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="icon-calendar"></i>
                                                <span class="badge badge-default">3</span>
                                            </a>
                                            <ul class="dropdown-menu extended tasks">
                                                <li class="external">
                                                    <h3>You have
                                                        <strong>12 pending</strong> tasks</h3>
                                                    <a href="app_todo_2.html">view all</a>
                                                </li>
                                                <li>
                                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">New release v1.2 </span>
                                                                    <span class="percent">30%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">40% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">Application deployment</span>
                                                                    <span class="percent">65%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">65% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">Mobile app release</span>
                                                                    <span class="percent">98%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">98% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">Database migration</span>
                                                                    <span class="percent">10%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">10% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">Web server upgrade</span>
                                                                    <span class="percent">58%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">58% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">Mobile development</span>
                                                                    <span class="percent">85%</span>
                                                                </span>
                                                                <span class="progress">
                                                                    <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">85% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <span class="task">
                                                                    <span class="desc">New UI release</span>
                                                                    <span class="percent">38%</span>
                                                                </span>
                                                                <span class="progress progress-striped">
                                                                    <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">38% Complete</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END TODO DROPDOWN -->
                                        <li class="droddown dropdown-separator">
                                            <span class="separator"></span>
                                        </li>
                                        <!-- BEGIN INBOX DROPDOWN -->
                                        <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <span class="circle">3</span>
                                                <span class="corner"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="external">
                                                    <h3>You have
                                                        <strong>7 New</strong> Messages</h3>
                                                    <a href="app_inbox.html">view all</a>
                                                </li>
                                                <li>
                                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                        <li>
                                                            <a href="#">
                                                                <span class="photo">
                                                                    <img src="{{url()}}/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                    <span class="from"> Lisa Wong </span>
                                                                    <span class="time">Just Now </span>
                                                                </span>
                                                                <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span class="photo">
                                                                    <img src="{{url()}}/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                    <span class="from"> Richard Doe </span>
                                                                    <span class="time">16 mins </span>
                                                                </span>
                                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span class="photo">
                                                                    <img src="{{url()}}/assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                    <span class="from"> Bob Nilson </span>
                                                                    <span class="time">2 hrs </span>
                                                                </span>
                                                                <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span class="photo">
                                                                    <img src="{{url()}}/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                    <span class="from"> Lisa Wong </span>
                                                                    <span class="time">40 mins </span>
                                                                </span>
                                                                <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <span class="photo">
                                                                    <img src="{{url()}}/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                    <span class="from"> Richard Doe </span>
                                                                    <span class="time">46 mins </span>
                                                                </span>
                                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END INBOX DROPDOWN -->
                                        <!-- BEGIN USER LOGIN DROPDOWN -->
                                        <li class="dropdown dropdown-user dropdown-dark">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <img alt="" class="img-circle" src="{{url()}}/assets/layouts/layout3/img/avatar9.jpg">
                                                <span class="username username-hide-mobile">{{$username}}</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-default">
                                                <li>
                                                    <a href="page_user_profile_1.html">
                                                        <i class="icon-user"></i> My Profile </a>
                                                </li>
                                                <li>
                                                    <a href="app_calendar.html">
                                                        <i class="icon-calendar"></i> My Calendar </a>
                                                </li>
                                                <li>
                                                    <a href="app_inbox.html">
                                                        <i class="icon-envelope-open"></i> My Inbox
                                                        <span class="badge badge-danger"> 3 </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="app_todo_2.html">
                                                        <i class="icon-rocket"></i> My Tasks
                                                        <span class="badge badge-success"> 7 </span>
                                                    </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="page_user_lock_1.html">
                                                        <i class="icon-lock"></i> Lock Screen </a>
                                                </li>
                                                <li>
                                                    <a href="{{url('auth/logout')}}">
                                                        <i class="icon-key"></i> Log Out </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END USER LOGIN DROPDOWN -->
                                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                                        <li class="dropdown dropdown-extended quick-sidebar-toggler">
                                            <span class="sr-only">Toggle Quick Sidebar</span>
                                            <i class="icon-logout"></i>
                                        </li>
                                        <!-- END QUICK SIDEBAR TOGGLER -->
                                    </ul>
                                </div>
                                <!-- END TOP NAVIGATION MENU -->
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
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
                                <!-- BEGIN MEGA MENU -->
                                <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                                <div class="hor-menu  ">
                                    <ul class="nav navbar-nav">
                                        <li class="menu-dropdown classic-menu-dropdown active">
                                            <a href="javascript:;"> Dashboard
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class=" active">
                                                    <a href="index.html" class="nav-link  active">
                                                        <i class="icon-bar-chart"></i> Default Dashboard
                                                        <span class="badge badge-success">1</span>
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="dashboard_2.html" class="nav-link  ">
                                                        <i class="icon-bulb"></i> Dashboard 2 </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="dashboard_3.html" class="nav-link  ">
                                                        <i class="icon-graph"></i> Dashboard 3
                                                        <span class="badge badge-danger">3</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown mega-menu-dropdown  ">
                                            <a href="javascript:;"> Estadisticas
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="min-width: 710px">
                                                <li>
                                                    <div class="mega-menu-content">
                                                        <div class="row" id="components">

                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                            <a href="javascript:;"> Layouts
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class=" ">
                                                    <a href="layout_mega_menu_light.html" class="nav-link  "> Light Mega Menu </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_top_bar_light.html" class="nav-link  "> Light Top Bar Dropdowns </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_fluid_page.html" class="nav-link  "> Fluid Page </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_top_bar_fixed.html" class="nav-link  "> Fixed Top Bar </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_mega_menu_fixed.html" class="nav-link  "> Fixed Mega Menu </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_disabled_menu.html" class="nav-link  "> Disabled Menu Links </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="layout_blank_page.html" class="nav-link  "> Blank Page </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown mega-menu-dropdown  mega-menu-full">
                                            <a href="javascript:;"> Components
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="min-width: ">
                                                <li>
                                                    <div class="mega-menu-content">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <ul class="mega-menu-submenu">
                                                                    <li>
                                                                        <h3>Components 1</h3>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_date_time_pickers.html"> Date & Time Pickers </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_color_pickers.html"> Color Pickers </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_select2.html"> Select2 Dropdowns </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_select.html"> Bootstrap Select </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_multi_select.html"> Multi Select </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="mega-menu-submenu">
                                                                    <li>
                                                                        <h3>Components 2</h3>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_select_splitter.html"> Select Splitter </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_typeahead.html"> Typeahead Autocomplete </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_tagsinput.html"> Bootstrap Tagsinput </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_switch.html"> Bootstrap Switch </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_maxlength.html"> Bootstrap Maxlength </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="mega-menu-submenu">
                                                                    <li>
                                                                        <h3>Components 3</h3>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_fileinput.html"> Bootstrap File Input </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_bootstrap_touchspin.html"> Bootstrap Touchspin </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_form_tools.html"> Form Widgets & Tools </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_context_menu.html"> Context Menu </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_editors.html"> Markdown & WYSIWYG Editors </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="mega-menu-submenu">
                                                                    <li>
                                                                        <h3>Components 4</h3>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_code_editors.html"> Code Editors </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_ion_sliders.html"> Ion Range Sliders </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_noui_sliders.html"> NoUI Range Sliders </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="components_knob_dials.html"> Knob Circle Dials </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                            <a href="javascript:;"> More
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-settings"></i> Form Stuff
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="form_controls.html" class="nav-link "> Bootstrap Form
                                                                <br>Controls </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_controls_md.html" class="nav-link "> Material Design
                                                                <br>Form Controls </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_validation.html" class="nav-link "> Form Validation </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_validation_states_md.html" class="nav-link "> Material Design
                                                                <br>Form Validation States </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_validation_md.html" class="nav-link "> Material Design
                                                                <br>Form Validation </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_layouts.html" class="nav-link "> Form Layouts </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_input_mask.html" class="nav-link "> Form Input Mask </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_editable.html" class="nav-link "> Form X-editable </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_wizard.html" class="nav-link "> Form Wizard </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_icheck.html" class="nav-link "> iCheck Controls </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_image_crop.html" class="nav-link "> Image Cropping </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_fileupload.html" class="nav-link "> Multiple File Upload </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="form_dropzone.html" class="nav-link "> Dropzone File Upload </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-briefcase"></i> Tables
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="table_static_basic.html" class="nav-link "> Basic Tables </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="table_static_responsive.html" class="nav-link "> Responsive Tables </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="table_bootstrap.html" class="nav-link "> Bootstrap Tables </a>
                                                        </li>
                                                        <li class="dropdown-submenu ">
                                                            <a href="javascript:;" class="nav-link nav-toggle"> Datatables
                                                                <span class="arrow"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="">
                                                                    <a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_scroller.html" class="nav-link "> Scroller Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_responsive.html" class="nav-link "> Responsive Extension </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_editable.html" class="nav-link "> Editable Datatables </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="?p=" class="nav-link nav-toggle ">
                                                        <i class="icon-wallet"></i> Portlets
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="portlet_boxed.html" class="nav-link "> Boxed Portlets </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="portlet_light.html" class="nav-link "> Light Portlets </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="portlet_solid.html" class="nav-link "> Solid Portlets </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="portlet_ajax.html" class="nav-link "> Ajax Portlets </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="portlet_draggable.html" class="nav-link "> Draggable Portlets </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="?p=" class="nav-link nav-toggle ">
                                                        <i class="icon-settings"></i> Elements
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="elements_steps.html" class="nav-link "> Steps </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="elements_lists.html" class="nav-link "> Lists </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="elements_ribbons.html" class="nav-link "> Ribbons </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="elements_overlay.html" class="nav-link "> Overlays </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="elements_cards.html" class="nav-link "> User Cards </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-bar-chart"></i> Charts
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="charts_amcharts.html" class="nav-link "> amChart </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="charts_flotcharts.html" class="nav-link "> Flot Charts </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="charts_flowchart.html" class="nav-link "> Flow Charts </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="charts_google.html" class="nav-link "> Google Charts </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="charts_echarts.html" class="nav-link "> eCharts </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="charts_morris.html" class="nav-link "> Morris Charts </a>
                                                        </li>
                                                        <li class="dropdown-submenu ">
                                                            <a href="javascript:;" class="nav-link nav-toggle"> HighCharts
                                                                <span class="arrow"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="">
                                                                    <a href="charts_highcharts.html" class="nav-link " target="_blank"> HighCharts </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="charts_highstock.html" class="nav-link " target="_blank"> HighStock </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="charts_highmaps.html" class="nav-link " target="_blank"> HighMaps </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                            <a href="javascript:;">
                                                <i class="icon-briefcase"></i> Pages
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-basket"></i> eCommerce
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="ecommerce_index.html" class="nav-link ">
                                                                <i class="icon-home"></i> Dashboard </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="ecommerce_orders.html" class="nav-link ">
                                                                <i class="icon-basket"></i> Orders </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="ecommerce_orders_view.html" class="nav-link ">
                                                                <i class="icon-tag"></i> Order View </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="ecommerce_products.html" class="nav-link ">
                                                                <i class="icon-graph"></i> Products </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="ecommerce_products_edit.html" class="nav-link ">
                                                                <i class="icon-graph"></i> Product Edit </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-docs"></i> Apps
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="app_todo.html" class="nav-link ">
                                                                <i class="icon-clock"></i> Todo 1 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="app_todo_2.html" class="nav-link ">
                                                                <i class="icon-check"></i> Todo 2 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="app_inbox.html" class="nav-link ">
                                                                <i class="icon-envelope"></i> Inbox </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="app_calendar.html" class="nav-link ">
                                                                <i class="icon-calendar"></i> Calendar </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="app_ticket.html" class="nav-link ">
                                                                <i class="icon-notebook"></i> Support </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-user"></i> User
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="page_user_profile_1.html" class="nav-link ">
                                                                <i class="icon-user"></i> Profile 1 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_user_profile_1_account.html" class="nav-link ">
                                                                <i class="icon-user-female"></i> Profile 1 Account </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_user_profile_1_help.html" class="nav-link ">
                                                                <i class="icon-user-following"></i> Profile 1 Help </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_user_profile_2.html" class="nav-link ">
                                                                <i class="icon-users"></i> Profile 2 </a>
                                                        </li>
                                                        <li class="dropdown-submenu ">
                                                            <a href="javascript:;" class="nav-link nav-toggle">
                                                                <i class="icon-notebook"></i> Login
                                                                <span class="arrow"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="">
                                                                    <a href="page_user_login_1.html" class="nav-link " target="_blank"> Login Page 1 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_user_login_2.html" class="nav-link " target="_blank"> Login Page 2 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_user_login_3.html" class="nav-link " target="_blank"> Login Page 3 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_user_login_4.html" class="nav-link " target="_blank"> Login Page 4 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_user_login_5.html" class="nav-link " target="_blank"> Login Page 5 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_user_login_6.html" class="nav-link " target="_blank"> Login Page 6 </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_user_lock_1.html" class="nav-link " target="_blank">
                                                                <i class="icon-lock"></i> Lock Screen 1 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_user_lock_2.html" class="nav-link " target="_blank">
                                                                <i class="icon-lock-open"></i> Lock Screen 2 </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-social-dribbble"></i> General
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="page_general_about.html" class="nav-link ">
                                                                <i class="icon-info"></i> About </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_contact.html" class="nav-link ">
                                                                <i class="icon-call-end"></i> Contact </a>
                                                        </li>
                                                        <li class="dropdown-submenu ">
                                                            <a href="javascript:;" class="nav-link nav-toggle">
                                                                <i class="icon-notebook"></i> Portfolio
                                                                <span class="arrow"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="">
                                                                    <a href="page_general_portfolio_1.html" class="nav-link "> Portfolio 1 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_portfolio_2.html" class="nav-link "> Portfolio 2 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_portfolio_3.html" class="nav-link "> Portfolio 3 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_portfolio_4.html" class="nav-link "> Portfolio 4 </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="dropdown-submenu ">
                                                            <a href="javascript:;" class="nav-link nav-toggle">
                                                                <i class="icon-magnifier"></i> Search
                                                                <span class="arrow"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="">
                                                                    <a href="page_general_search.html" class="nav-link "> Search 1 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_search_2.html" class="nav-link "> Search 2 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_search_3.html" class="nav-link "> Search 3 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_search_4.html" class="nav-link "> Search 4 </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="page_general_search_5.html" class="nav-link "> Search 5 </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_pricing.html" class="nav-link ">
                                                                <i class="icon-tag"></i> Pricing </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_faq.html" class="nav-link ">
                                                                <i class="icon-wrench"></i> FAQ </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_blog.html" class="nav-link ">
                                                                <i class="icon-pencil"></i> Blog </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_blog_post.html" class="nav-link ">
                                                                <i class="icon-note"></i> Blog Post </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_invoice.html" class="nav-link ">
                                                                <i class="icon-envelope"></i> Invoice </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_general_invoice_2.html" class="nav-link ">
                                                                <i class="icon-envelope"></i> Invoice 2 </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu ">
                                                    <a href="javascript:;" class="nav-link nav-toggle ">
                                                        <i class="icon-settings"></i> System
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li class=" ">
                                                            <a href="page_system_coming_soon.html" class="nav-link " target="_blank"> Coming Soon </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_system_404_1.html" class="nav-link "> 404 Page 1 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_system_404_2.html" class="nav-link " target="_blank"> 404 Page 2 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_system_404_3.html" class="nav-link " target="_blank"> 404 Page 3 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_system_500_1.html" class="nav-link "> 500 Page 1 </a>
                                                        </li>
                                                        <li class=" ">
                                                            <a href="page_system_500_2.html" class="nav-link " target="_blank"> 500 Page 2 </a>
                                                        </li>
                                                    </ul>
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
                                        <h1>Dashboard
                                            <small>Data & Statistics</small>
                                        </h1>
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
                                            <span>Dashboard</span>
                                        </li>
                                    </ul>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div id="dashboard">
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
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN CONFIG COMPONENTS-->
        <script src="{{url()}}//assets/global/plugins/components/components.js" type="text/javascript"></script>
        <!-- END CONFIG COMPONENTS-->
        <!-- BEGIN RAZORFLOW STATIC LINKS-->
        <link rel="stylesheet" href="{{url()}}//assets/global/plugins/razorflow/css/razorflow.min.css"/>
        <script src="{{url()}}//assets/global/plugins/razorflow/js/razorflow.min.js" type="text/javascript"></script>
        <script src="{{url()}}//assets/global/plugins/razorflow/js/razorflow.devtools.min.js" type="text/javascript"></script>
        <script src="{{url()}}//assets/global/plugins/razorflow/js/dashboard_app.js" type="text/javascript"></script>
        <!-- END RAZORFLOW STATIC LINKS-->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{url()}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url()}}/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{url()}}/assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
        <script src="{{url()}}/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NGFVTN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NGFVTN');</script>
<!-- End Google Tag Manager -->
</body>


</html>