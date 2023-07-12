<head>
    <style>
        .no-hover{
            color: white;
            border: none;
            outline: none;
        }
        .no-hover:hover{
            color: white;
            border: none;
            outline: none;
        }
        .no-hover:focus{
            color: white;
            border: none;
            outline: none;
        }
        .no-hover:active{
            color: white;
            border: none;
            outline: none;
        }

        /* Set navbar to fixed position */
        .navbar{
            /* overflow: hidden; */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        .dropdown {
            z-index: 1001; /* Menambahkan z-index yang lebih tinggi */
        }
    </style>
</head>
<header>
    <nav class="navbar p-3 bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="#"><img style="width: 30px;" class="me-3"
                    src="https://www.freeiconspng.com/thumbs/logo-design/blank-bird-logo-design-idea-png-15.png"
                    alt="">KUB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                    {{auth()->user()->name}}
                    <li class="nav-item">
                        <a id="dashboard" class="nav-link" aria-current="page" href="{{ url('/') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="cashier" href="{{ url('/cashier/cashier-home') }}" class="nav-link">
                            Kasir
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="userManagement" href="{{ url('/user-management/user-management') }}" class="nav-link">
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="product" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Produk
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/product/product-list') }}">Daftar Produk</a>
                            </li>
                            <li>
                                <hr class="my-1">
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/product/product-stock') }}">Manajemen Stok
                                    Produk</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="report" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/report/report-page') }}">Laporan rugi laba</a>
                            </li>
                            <li>
                                <hr class="my-1">
                            </li>
                            <li><a class="dropdown-item" href="#">Laporan detail penjualan produk</a></li>
                        </ul>
                    </li>
                    @endauth
                </ul>
                <div class="float-start my-2">
                    @auth
                    {{auth()->user()->name}}
                    <div class="dropdown">
                        <button class="btn btn-transparent dropdown-toggle no-hover" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->username }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('logout.perform') }}" class="dropdown-item">Keluar</a></li>
                        </ul>
                    </div>
                    @endauth

                    @guest
                    <div class="text-end">
                        <a href="{{ route('login.perform') }}" class="btn btn-outline-light">Login</a>
                        <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>
<br><br><br>


<script>
$(document).ready(function() {
    let currUrl = window.location.href;

    if (currUrl.includes('dashboard')) {
        $('#dashboard').addClass('active fw-semibold');
    } else if (currUrl.includes('product')) {
        $('#product').addClass('active fw-semibold');
    } else if (currUrl.includes('cashier')) {
        $('#cashier').addClass('active fw-semibold');
    } else if (currUrl.includes('report')) {
        $('#report').addClass('active fw-semibold');
    } else if (currUrl.includes('user-management')) {
        $('#userManagement').addClass('active fw-semibold');
    }
});
</script>