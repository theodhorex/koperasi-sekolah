@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <h3 class="fw-semibold mb-4">
        <a onClick="history.back()" style="cursor: pointer;" class="fw-semibold text-dark text-decoration-none">
            <span class="material-icons align-items-center">
                arrow_back
            </span>
        </a>
        Data produk yang terjual di tahun {{ date('Y') }}
    </h3>

    <!-- Table Data -->
    <table class="table table-bordered">
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
            $thisYearTotalSubtotal = 0;
            @endphp
            @foreach($totalSoldProductThisYear as $totalSoldProductThisYears)
            @php
            $yearlySubtotal = $totalSoldProductThisYears->total_sold * $totalSoldProductThisYears->price;
            $thisYearTotalSubtotal += $yearlySubtotal;
            @endphp
            <tr>
                <th class="nowrap" scope="row">{{ $num++ }}</th>
                <td>{{ $totalSoldProductThisYears -> product_code }}</td>
                <td>{{ $totalSoldProductThisYears -> product_name }}</td>
                <td>Rp. {{ number_format($totalSoldProductThisYears -> price, 2, ',', '.') }}</td>
                <td>{{ $totalSoldProductThisYears -> total_sold }}</td>
                <td>Rp.
                    {{ number_format($totalSoldProductThisYears -> total_sold * $totalSoldProductThisYears -> price, 2, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="5">Total Subtotal:</th>
                <td>Rp. {{ number_format($thisYearTotalSubtotal, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection