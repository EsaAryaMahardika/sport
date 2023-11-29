<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') - Admin RusakApa</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" href="css/datatables.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <nav class="main-menu">
        <ul>
            <li class="has-subnav"><a href="/dashboard"><i class="fa fa-laptop fa-2x"></i><span class="nav-text">
                        Dashboard</span></a></li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fa-map fa-2x"></i>
                    <span class="nav-text"> Lokasi</span>
                </a>
                <ul>
                    <li><a href="/provinsi">Provinsi</a></li>
                    <li><a href="/kabupaten">Kabupaten</a></li>
                </ul>
            </li>
            <li class="has-subnav"><a href="/crash"><i class="fa fa-bug fa-2x"></i><span class="nav-text">
                        Kerusakan</span></a></li>
            <li class="has-subnav"><a href="/gejala"><i class="fa fa-tasks fa-2x"></i><span class="nav-text">
                        Gejala</span></a></li>
            <li class="has-subnav"><a href="/report"><i class="fa fa-book fa-2x"></i><span class="nav-text">
                        Laporan</span></a></li>
            <li class="has-subnav"><a href="/rule"><i class="fa fa-map-signs fa-2x"></i><span class="nav-text">
                        Aturan</span></a></li>
            <li class="has-subnav"><a href="/tutorial"><i class="fa fa-cogs fa-2x"></i><span class="nav-text">
                        Tutorial</span></a></li>
            <li class="has-subnav"><a href="/engineer"><i class="fa fa-wrench fa-2x"></i><span class="nav-text">
                        Teknisi</span></a></li>
            <li class="has-subnav"><a href="/user"><i class="fa fa-address-card fa-2x"></i><span class="nav-text">
                        User</span></a></li>
        </ul>
        <ul class="logout">
            <li><a href="#"><i class="fa fa-power-off fa-2x"></i><span class="nav-text"> Logout</span></a></li>
        </ul>
    </nav>
    <div class="header">
        <h1>@yield('title')</h1>
    </div>
    <div class="content">
        @if(Session::has('success'))
        <div class="alert success-alert">
            <h3>{{ Session::get('success') }}</h3>
            <a class="close">&times;</a>
        </div>
        @endif
        @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/fc-4.2.2/fh-3.3.2/r-2.4.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/admin.js"></script>
    <script src="js/ajax.js"></script>
</body>

</html>