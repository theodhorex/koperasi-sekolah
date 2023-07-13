@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <h3 class="fw-semibold mb-4">
        <a onClick="history.back()" style="cursor: pointer;" class="fw-semibold text-dark text-decoration-none">
            <span class="material-icons align-items-center">
                arrow_back
            </span>
        </a>
        Data produk yang terjual di bulan {{ date('F') }}
    </h3>

    <!-- Table Data -->
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
            $thisMonthTotalSubtotal = 0;
            @endphp
            @foreach($totalSoldProductThisMonth as $totalProductSoldThisMonths)
            @php
            $subtotal = $totalProductSoldThisMonths->total_sold * $totalProductSoldThisMonths->price;
            $thisMonthTotalSubtotal += $subtotal;
            @endphp
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
            <tr>
                <th colspan="5">Total Subtotal:</th>
                <td>Rp. {{ number_format($thisMonthTotalSubtotal, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection