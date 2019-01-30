<!DOCTYPE html>
<head>

    <!-- WittyLight -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wittylight">

    <!-- Favicon icon & Title -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('imgs/favicon.png')}}">
    <title>@yield('title', 'Home') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Prompt:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    @yield('style')

</head>
<body>
<div id="main-wrapper">

    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="ti-menu ti-close"></i>
                </a>
                <div class="navbar-brand">
                    <a href="{{route('home')}}" class="logo">
                        <b class="logo-icon">
                            <img src="{{url('imgs/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <span class="logo-text">
                            <img src="{{url('imgs/logo-light-text.png')}}" class="light-logo" alt="homepage" />
                        </span>
                    </a>
                    <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                        <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                    </a>
                </div>

                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti-more"></i>
                </a>
            </div>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">

                <ul class="navbar-nav float-left mr-auto"></ul>
                <ul class="navbar-nav float-right">


                    <li class="nav-item dropdown border-right">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bell-outline font-22"></i>
                            <span class="badge badge-pill badge-info noti">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title bg-primary text-white">
                                        <h4 class="m-b-0 m-t-5">4 New</h4>
                                        <span class="font-light">Notifications</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center notifications">
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="fa fa-link"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Luanch Admin</h5>
                                                <span class="mail-desc">Just see the my new admin!</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle">
                                                    <i class="ti-calendar"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Event today</h5>
                                                <span class="mail-desc">Just a reminder that you have event</span>
                                                <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-info btn-circle">
                                                    <i class="ti-settings"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Settings</h5>
                                                <span class="mail-desc">You can customize this template as you want</span>
                                                <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-primary btn-circle">
                                                    <i class="ti-user"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5>
                                                <span class="mail-desc">Just see the my admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                        <strong>Check all notifications</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{url('imgs/'.Auth::user()->avatar)}}" alt="user" class="rounded-circle mr-2" width="40">
                            <span class="m-l-5 font-medium d-none d-sm-inline-block">{{Auth::user()->username}} <i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10 p-3">
                                <div class="">
                                    <img src="{{url('imgs/'.Auth::user()->avatar)}}" alt="user" class="rounded-circle mr-2" width="60">
                                </div>
                                <div class="m-l-10">
                                    <h4 class="m-b-0">{{Auth::user()->name}}</h4>
                                    <p class=" m-b-0">{{Auth::user()->email}}</p>
                                </div>
                            </div>
                            <div class="profile-dis scrollable">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>



    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Dashboard</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}" aria-expanded="false">
                            <i class="mdi mdi-cube-send"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-tune"></i>
                            <span class="hide-menu">Submenu Type </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="mdi mdi-view-quilt"></i>
                                    <span class="hide-menu"> Submenu 1 </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="mdi mdi-view-parallel"></i>
                                    <span class="hide-menu"> Submenu 2 </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="page-wrapper">
        @yield('content')


        <!-- footer -->
        <footer class="footer text-center">
            All Rights Reserved by WittyLight.
        </footer>
    </div>
</div>

<script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/app.min.js')}}"></script>
<script src="{{asset('js/app.init.js')}}"></script>
<script src="{{asset('js/app-style-switcher.js')}}"></script>
<script src="{{asset('libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('extra-libs/sparkline/sparkline.js')}}"></script>
<script src="{{asset('js/waves.js')}}"></script>
<script src="{{asset('js/sidebarmenu.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/pages/dashboards/dashboard1.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweetalert::alert')
@yield('script')

</body>