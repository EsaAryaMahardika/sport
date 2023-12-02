<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') - Admin ERP</title>
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
                <a href="/product">
                    <i class="fa fa-cogs fa-2x"></i>
                    <span class="nav-text"> Produk</span>
                </a>
                <ul>
                    <li><a href="/category">Kategori</a></li>
                    <li><a href="/factory">Pabrik</a></li>
                    <li><a href="/materials">Bahan Baku</a></li>
                    <li><a href="/component">Komposisi</a></li>
                </ul>
            </li>
            <li class="has-subnav"><a href="/production"><i class="fa fa-industry fa-2x"></i><span class="nav-text">
                        Produksi</span></a></li>
            <li class="has-subnav"><a href="/vendor"><i class="fa fa-address-book fa-2x"></i><span class="nav-text">
                        Vendor</span></a></li>
            <li class="has-subnav"><a href="/purchase"><i class="fa fa-shopping-cart fa-2x"></i><span class="nav-text">
                        Pembelian</span></a></li>
            <li class="has-subnav"><a href="/customer"><i class="fa fa-users fa-2x"></i><span class="nav-text">
                        Pelanggan</span></a></li>
            <li class="has-subnav"><a href="/selling"><i class="fa fa-money fa-2x"></i><span class="nav-text">
                        Penjualan</span></a></li>
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
    @stack('script')
</body>

</html>