<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ Session::token() }}">
  <title>
    @yield('title')
  </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {{-- Layout SCSS --}}
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  {{-- Select 2 CSS --}}
  {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/scss/custom.scss"> --}}
  {{-- Local CSS --}}
  @yield('local-css')
</head>
<body class="hold-transition">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fad fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Vin Diesel
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>

          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fad fa-bell"></i>
          <span class="badge badge-primary navbar-badge">5</span>
        </a>
      </li>
      {{-- Language Dropdown --}}
      {{-- <li class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown">
            {{ Config::get('languages')[App::getLocale()] }}
        </a>
        <ul class="dropdown-menu">
          @foreach (Config::get('languages') as $lang => $language)
            @if ($lang != App::getLocale())
              <li>
                <a href="{{ route('lang.switch', $lang) }}" class="dropdown-header font-weight-bolder">{{$language}}</a>
              </li>
            @endif
          @endforeach
        </ul>
      </li> --}}
      {{-- Profile Dropdown --}}
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fad fa-user"></i><span class="ml-1"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          {{-- <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div> --}}
          <!-- Button trigger modal -->
          <a href="/profile">
            <span class="dropdown-header font-weight-bolder">
              {{-- @php
                  $name = ucwords(Auth::guard('employee')->User()->employee_name);
              @endphp
              {{$name}} --}}
            </span>
          </a>

          <a href="/doLogout" class="dropdown-item bg-danger">
            <center><i class="fad fa-sign-out-alt mr-2"></i>Logout</center>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-navy elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link navbar-light">
      <center>
          <img src="{{ asset('/assets/logo.png')}}" width="85%">
      </center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
            <li class="nav-item has-treeview menu-close">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-database"></i>
                  <p>
                  {{__('Data Master')}}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="/employee" class="nav-link">
                        <i class="fad fa-users nav-icon"></i>
                        <p>{{__('Employee')}}</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/salespoint" class="nav-link">
                        <i class="fad fa-globe-asia nav-icon"></i>
                        <p>{{__('Sales Point')}}</p>
                      </a>
                    </li>
                </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

    <div class="content-wrapper p-3">
        @if($errors->any())
            <div class="m-1 alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                 @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="m-1 alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="m-1 alert alert-danger alert-dismissible fade show" role="alert">
                {{Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Bootstrap 4.6 -->
<script src="/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>
{{-- Select 2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
{{-- Autonumeric --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>

<script src="{{ asset('/js/layout.js') }}"></script>

<!-- Local JS -->
@yield('local-js')
</body>
</html>
