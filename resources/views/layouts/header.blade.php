<!DOCTYPE html>
<head>

    <!-- WittyLight -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wittylight">

    <!-- Favicon icon & Title -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/Logofilepng/Logo_H_White.png')}}">
    <title>@yield('title', 'Home') | Handy Driver Assist</title>
    {{--script--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/addstyle.css')}}" rel="stylesheet">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    @yield('style')

</head>
<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper" data-header-position="fixed" data-sidebar-position="fixed">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="ti-menu ti-close"></i>
                </a>
                <div class="navbar-brand">
                    <a href="{{route('home')}}" class="logo">
                        <b class="logo-icon">
                            {{--<img src="{{url('imgs/logo-light-icon.png')}}" alt="homepage" class="light-logo" />--}}
                            <img src="{{asset('images/Logofilepng/Logo_H_White.png')}}" width="35px" height="35px" class="light-logo" alt="homepage" />
                        </b>
                        <span class="logo-text">
                            <img src="{{asset('images/Logofilepng/word.png')}}" style="width: 90px; height: 20px" class="light-logo" alt="homepage" />
                            {{--<span style="color: white;font-weight: bold">Handy</span>--}}
                        </span>
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
                    @auth
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

                    @endauth

                    @guest

                        <li class="nav-item dropdown">
                            <div class="nav-link  waves-effect waves-dark" aria-haspopup="true" aria-expanded="true">
                                <div class="btn-group">
                                    <a class="btn btn-info btn-rounded waves-light waves-effect" href="{{ route('login') }}">ลงชื่อเข้าใช้</a>
                                    <a class="btn btn-warning btn-rounded text-white waves-light waves-effect ml-3" href="{{ route('register') }}">สมัครสมาชิก</a>
                                </div>

                            </div>
                        </li>

                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{url('imgs/'.Auth::user()->avatar)}}" alt="user" class="rounded-circle mr-2" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block">{{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
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
                    @endguest
                </ul>
            </div>
        </nav>
    </header>



    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    @guest
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
{{--                        <li class="sidebar-item">--}}
{{--                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('home')}}">--}}
{{--                                <i class="mdi mdi-home"></i>--}}
{{--                                <span class="hide-menu">หน้าหลัก</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-phone"></i>
                                <span class="hide-menu">บริการรถยนต์</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="tel:1620" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">รถสไลด์/รถยก</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:0879084528" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">เปลี่ยนแบตเตอรี่</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1153" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">ยางรถยนต์</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-phone"></i>
                                <span class="hide-menu">ติดต่อประกัน</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="tel:1620" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">กรุงเทพประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1736" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">ทิพยประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1557" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">วิริยะประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1484" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">เมืองไทยประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1726" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">อาคเนย์ประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1596" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">สินมั่นคงประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1748" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">นวกิจประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:02-695-0700" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">ไทยวิวัฒน์ประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:+6628693333" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">เอเชียประกันภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1790" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">แอลเอ็มจีประกันภัย</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-phone"></i>
                                <span class="hide-menu">แจ้งเหตุฉุกเฉิน</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="tel:191" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">เหตุด่วนเหตุร้าย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1669" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">กู้ภัย</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1543" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">กู้ภัยทางหลวง</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1193" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">ตำรวจทางหลวง</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1155" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">ตำรวจท่องเที่ยว</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1146" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">กรมทางหลวงชนบท</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="tel:1192" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">แจ้งรถหาย</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
    @else
        @if( Auth::user()->role == 1)
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}" aria-expanded="false">
                                    <i class="mdi mdi-cube-send"></i>
                                    <span class="hide-menu">AdminDashboard</span>
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
            @endif
            @if (\Illuminate\Support\Facades\Auth::user()->role == 0)
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('fuellog.app.index')}}" aria-expanded="false">
                                        <i class="mdi mdi-gas-station"></i>
                                        <span class="hide-menu">myFuelLog</span>
                                    </a>
                                </li>
{{--                                <li class="sidebar-item">--}}
{{--                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">--}}
{{--                                        <i class="mdi mdi-tune"></i>--}}
{{--                                        <span class="hide-menu">Submenu Type </span>--}}
{{--                                    </a>--}}
{{--                                    <ul aria-expanded="false" class="collapse  first-level">--}}
{{--                                        <li class="sidebar-item">--}}
{{--                                            <a href="#" class="sidebar-link">--}}
{{--                                                <i class="mdi mdi-view-quilt"></i>--}}
{{--                                                <span class="hide-menu"> Submenu 1 </span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="sidebar-item">--}}
{{--                                            <a href="#" class="sidebar-link">--}}
{{--                                                <i class="mdi mdi-view-parallel"></i>--}}
{{--                                                <span class="hide-menu"> Submenu 2 </span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                        <i class="mdi mdi-phone"></i>
                                        <span class="hide-menu">บริการรถยนต์</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse  first-level">
                                        <li class="sidebar-item">
                                            <a href="tel:1620" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">รถสไลด์/รถยก</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:0879084528" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">เปลี่ยนแบตเตอรี่</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1153" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">ยางรถยนต์</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                        <i class="mdi mdi-phone"></i>
                                        <span class="hide-menu">ติดต่อประกัน</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse  first-level">
                                        <li class="sidebar-item">
                                            <a href="tel:1620" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">กรุงเทพประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1736" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">ทิพยประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1557" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">วิริยะประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1484" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">เมืองไทยประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1726" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">อาคเนย์ประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1596" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">สินมั่นคงประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1748" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">นวกิจประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:02-695-0700" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">ไทยวิวัฒน์ประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:+6628693333" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">เอเชียประกันภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1790" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">แอลเอ็มจีประกันภัย</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                        <i class="mdi mdi-phone"></i>
                                        <span class="hide-menu">แจ้งเหตุฉุกเฉิน</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse  first-level">
                                        <li class="sidebar-item">
                                            <a href="tel:191" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">เหตุด่วนเหตุร้าย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1669" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">กู้ภัย</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1543" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">กู้ภัยทางหลวง</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1193" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">ตำรวจทางหลวง</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1155" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">ตำรวจท่องเที่ยว</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1146" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">กรมทางหลวงชนบท</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="tel:1192" class="sidebar-link">
                                                <i class="mdi mdi-chevron-right"></i>
                                                <span class="hide-menu">แจ้งรถหาย</span>
                                            </a>
                                        </li>
                                    </ul>
                            </ul>
                        </nav>
                    </div>
                </aside>
            @endif
    @endguest



    <div class="page-wrapper">
        @yield('content')


        <!-- footer -->
        <footer class="footer text-center">
            <i class="far fa-copyright"></i> All Rights Reserved by Handy Driver Assist
        </footer>
    </div>
</div>

<script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/app.min.js')}}"></script>
<script src="{{asset('js/app.init.horizontal.js')}}"></script>
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