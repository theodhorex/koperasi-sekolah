@extends('layouts.app-master')

@section('content')
<div class="py-5 rounded">
    @auth
    <h2 class="fw-semibold mb-4">Selamat datang {{ Auth::user()->username }}</h2>
    <div class="row">
        <div class="col">
            <h4>Laporan Bulan Ini</h4>
        </div>
        <div class="col">
            @if(Auth::user() -> role == 'admin')
            <h4 class="float-end"><a class="btn btn-primary fw-semibold" href="{{ url('/report/report-page') }}">Lihat
                    Selengkapnya</a></h4>
            @endif
        </div>
    </div>
    <canvas class="mb-5" id="chartTarget"></canvas>

    @if(Auth::user()->role=='petugas')
    <!-- Daily data -->
    <h4 class="fw-semibold mb-3">Data barang yang terjual hari ini</h4>
    <table class="table table-bordered mb-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Terjual</th>
                <th scope="col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $num = 1;
            @endphp
            @foreach($totalSoldProductToday as $totalSoldProductTodays)
            <tr>
                <th class="nowrap" scope="row">{{ $num++ }}</th>
                <td>{{ $totalSoldProductTodays -> product_code }}</td>
                <td>{{ $totalSoldProductTodays -> product_name }}</td>
                <td>Rp. {{ number_format($totalSoldProductTodays -> price, 2, ',', '.') }}</td>
                <td>{{ $totalSoldProductTodays -> total_sold }}</td>
                <td>Rp.
                    {{ number_format($totalSoldProductTodays -> total_sold * $totalSoldProductTodays -> price, 2, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Monthly data -->
    <h4 class="fw-semibold mb-3">Data barang yang terjual bulan {{ date('F') }}</h4>
    <table class="table table-bordered mb-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Terjual</th>
                <th scope="col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $num = 1;
            @endphp
            @foreach($totalSoldProductThisMonth as $totalProductSoldThisMonths)
            <tr>
                <th class="nowrap" scope="row">{{ $num++ }}</th>
                <td>{{ $totalProductSoldThisMonths -> product_code }}</td>
                <td>{{ $totalProductSoldThisMonths -> product_name }}</td>
                <td>Rp. {{ number_format($totalProductSoldThisMonths -> price, 2, ',', '.') }}</td>
                <td>{{ $totalProductSoldThisMonths -> total_sold }}</td>
                <td>Rp.
                    {{ number_format($totalProductSoldThisMonths -> total_sold * $totalProductSoldThisMonths -> price, 2, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @endauth


    <script>
    var months = {!!json_encode($months) !!};
    var incomeData = {!!json_encode($incomeData) !!};
    var outcomeData = {!!json_encode($outcomeData) !!};

    var ctx = document.getElementById('chartTarget').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                    label: 'Pemasukan',
                    data: incomeData,
                    backgroundColor: 'aqua',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Pengeluaran',
                    data: outcomeData,
                    backgroundColor: 'red',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</div>
@endsection

@guest
<div class="row py-5 px-5">
    <div class="col">
        <img style="width: 150px;" class="d-block mx-auto"
            src="https://www.freeiconspng.com/thumbs/logo-design/blank-bird-logo-design-idea-png-15.png" alt="">
        <h2 class="fw-bold text-center">Koperasi Usaha Bersama</h2>
        <form class="py-4 px-4 rounded-3" method="post" action="{{ route('login.perform') }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <h3 class="mb-3 fw-semibold text-center">Login</h3>


            <div class="row">
                <div class="col-4 d-block mx-auto">
                    @include('layouts.partials.messages')
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                            placeholder="Username" required="required" autofocus>
                        <label for="floatingName">Nama Pengguna</label>
                        @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                            placeholder="Password" required="required">
                        <label for="floatingPassword">Kata Sandi</label>
                        @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endguest