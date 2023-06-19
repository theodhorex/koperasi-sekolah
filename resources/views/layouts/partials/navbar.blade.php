<header>
    <nav class="navbar p-3 bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="#">Koperasi Usaha Bersama</a>
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
                        <a id="dashboard" class="nav-link" aria-current="page"
                            href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="cashier" href="{{ url('/cashier/cashier-home') }}" class="nav-link">
                            Kasir
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
                            <li><hr class="my-1"></li>
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

                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> -->
                </ul>
                <div class="float-start my-2">
                    @auth
                    {{auth()->user()->name}}
                    <div class="text-end">
                        <a href="{{ route('logout.perform') }}" class="btn btn-outline-light">Logout</a>
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
    }
});
</script>