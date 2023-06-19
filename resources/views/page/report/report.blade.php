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

                            <h3 class="fw-bold text-primary mb-0">Rp.
                                {{ number_format($totalIncome -> total_income, 2, ',', '.') }}</h3>
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
                            <h3 class="fw-bold text-danger mb-0">Rp.
                                {{ number_format($totalOutcome -> total_outcome, 2, ',', '.') }}</h3>
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
                            <h3 class="fw-bold text-warning mb-0">{{ $totalProduct }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row px-2">
        <div class="col border border-tertiary rounded p-4">
            <h3 class="fw-semibold mb-4">Diagram data rugi laba tahun {{ date('Y') }}</h3>
            <canvas id="chartTarget"></canvas>
        </div>
    </div>
</div>



<script>
var months = {!!json_encode($months) !!};
var incomeData = {!!json_encode($incomeData) !!};
var outcomeData = {!!json_encode($outcomeData) !!};

var ctx = document.getElementById('chartTarget').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
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