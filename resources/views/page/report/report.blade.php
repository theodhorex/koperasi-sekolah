@extends('layouts.app-master')
@section('content')

<div class="py-5 rounded">
    <div class="row mb-4">
        <h3 class="fw-bold">Laporan rugi laba tahun {{ date('Y') }}</h3>
    </div>
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-semibold">Filter</h4>
            <div class="row">
                <div class="col-md">
                    <select class="form-control" name="" id="">
                        <option value="">test</option>
                        <option value="">test</option>
                        <option value="">test</option>
                        <option value="">test</option>
                        <option value="">test</option>
                    </select>
                </div>
                <div class="col-md"></div>
                <div class="col-md"></div>
                <div class="col-md"></div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">Initial Capital</h5>
                    <div class="row">
                        <div class="col">
                            <h3 class="fw-bold text-info mb-0">Rp. 25.000.000,00</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">Total Pemasukan</h5>
                    <div class="row">
                        <div class="col">
                            @if(isset($totalIncome))
                            <h3 class="fw-bold text-primary mb-0">Rp. {{ number_format($totalIncome -> total_income, 2, ',', '.') }}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">Total Pengeluaran</h5>
                    <div class="row">
                        <div class="col">
                            @if(isset($totalOutcome))
                            <h3 class="fw-bold text-danger mb-0">Rp. {{ number_format($totalOutcome -> total_outcome, 2, ',', '.') }}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">Total Produk</h5>
                    <div class="row">
                        <div class="col">
                            @if(isset($totalProduct))
                            <h3 class="fw-bold text-warning mb-0">{{ $totalProduct }}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div id="target" class="row px-2">
        <div class="col border border-tertiary rounded p-4">
            <h3 class="fw-semibold mb-2">Diagram data rugi laba tahun {{ date('Y') }}</h3>
            <h5 class="fw-semibold mb-1">Cetak data</h5>
            <div class="row mb-4">
                <div class="col">
                    <a id="exportPdfButton" class="btn btn-danger fw-semibold" href="{{ url('/report/export/report-pdf') }}">PDF</a>
                    <a id="exportExcelButton" class="btn btn-success fw-semibold">Excel</a>
                </div>
            </div>
            <canvas class="mb-5" id="chartTarget"></canvas>

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
                    $todayTotalSubtotal = 0;
                    @endphp
                    @foreach($totalSoldProductToday as $totalSoldProductTodays)
                    @php
                    $todaySubtotal = $totalSoldProductTodays->total_sold * $totalSoldProductTodays->price;
                    $todayTotalSubtotal += $todaySubtotal;
                    @endphp
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
                    <tr>
                        <th colspan="5">Total Subtotal:</th>
                        <td>Rp. {{ number_format($todayTotalSubtotal, 2, ',', '.') }}</td>
                    </tr>
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
                        <td>Rp. {{ number_format($totalProductSoldThisMonths -> total_sold * $totalProductSoldThisMonths -> price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">Total Subtotal:</th>
                        <td>Rp. {{ number_format($thisMonthTotalSubtotal, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Yearly data -->
            <h4 class="fw-semibold mb-3">Data barang yang terjual di tahun {{ date('Y') }}</h4>
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
                        <td>Rp. {{ number_format($totalSoldProductThisYears -> total_sold * $totalSoldProductThisYears -> price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">Total Subtotal:</th>
                        <td>Rp. {{ number_format($thisYearTotalSubtotal, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
// $(document).ready(function(){
//     $('#exportPdfButton').click(function(){
//         var chart = document.getElementById('chartTarget');
//         html2canvas(chart).then(function(canvas){
//             var result = canvas.toDataURL('image/png');
//             $.ajax({
//                 type: 'GET',
//                 url: '/report/report-pdf',
//                 data: {
//                     image: result
//                 },
//                 success: function(data){
//                     window.location.href = '/report/load-report-pdf';
//                     // console.log(data)
//                     // console.log(result)
//                     // $('#target').html(
//                     //     `
//                     //     <img src="${result}">
//                     //     `
//                     // )
//                 },
//                 error: function(err){
//                     console.log(err);
//                 }
//             });
//         });
//     });
// });


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

@endsection