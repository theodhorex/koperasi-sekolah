<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Black.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-BlackItalic.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Bold.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-BoldItalic.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Italic.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Light.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-LightItalic.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-Thin.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Lato';
        src: url('/storage/fonts/Lato/Lato-ThinItalic.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    * {
        font-family: 'Lato', sans-serif;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    /* tr:nth-child(even) {
        background-color: #dddddd;
    } */

    .report{
        font-size: 10px;
    }
    </style>
    <title>Document</title>
</head>

<body>
    <h4 style="text-align: center; text-transform: uppercase;">
        Laporan hasil penjualan <b>Koperasi Usaha Bersama</b>
        <br>
        {{ date('d m Y') }}
    </h4>

    <table class="report">
        <thead>
            <tr>
                <th>Tanggal: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">{{ date('d m Y') }}</p>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="background-color: lightgrey; text-transform: uppercase;">Pemasukan</th>
                <!-- <th></th> -->
            </tr>
            <tr>
                <th>Hari ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">
                        @if(isset($totalIncomeToday -> total_income))
                        Rp. {{ number_format($totalIncomeToday -> total_income, 2, ',', '.') }}
                        @else
                        Rp. 0
                        @endif
                    </p>
                </th>
            </tr>
            <tr>
                <th>Bulan ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">Rp. {{ number_format($totalIncomeThisMonth -> total_income, 2, ',', '.') }}</p>
                </th>
            </tr>
            <tr>
                <th>Tahun ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">Rp. {{ number_format($totalIncomeThisYear -> total_income, 2, ',', '.') }}</p>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="background-color: lightgrey; text-transform: uppercase;">Pengeluaran</th>
                <!-- <th></th> -->
            </tr>
            <tr>
                <th>Hari ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">Rp. {{ number_format($totalOutcomeThisYear -> total_outcome, 2, ',', '.') }}</p>
                </th>
            </tr>
            <tr>
                <th>Bulan ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">Rp. {{ number_format($totalOutcomeThisYear -> total_outcome, 2, ',', '.') }}</p>
                </th>
            </tr>
            <tr>
                <th>Tahun ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">Rp. {{ number_format($totalOutcomeThisYear -> total_outcome, 2, ',', '.') }}</p>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="background-color: lightgrey; text-transform: uppercase;">Laporan penjualan</th>
                <!-- <th></th> -->
            </tr>
            <tr>
                <th>Hari ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">{{ $totalSoldProductToday -> count() }}</p>
                </th>
            </tr>
            <tr>
                <th>Bulan ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">{{ $totalSoldProductThisMonth -> count() }}</p>
                </th>
            </tr>
            <tr>
                <th>Tahun ini: </th>
                <th>
                    <p style="float: right; padding: 0; margin: 0;">{{ $totalSoldProductThisYear -> count() }}</p>
                </th>
            </tr>
        </thead>
    </table>

    <br>

    <h4 style="text-transform: uppercase;">Data produk yang terjual hari ini</h4>
    <table class="report">
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
        </tbody>
    </table>

    <br>

    <h4 style="text-transform: uppercase;">Data produk yang paling diminati sejauh ini</h4>
    <table class="report">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Terjual</th>
            </tr>
        </thead>
        <tbody>
            @php
            $num = 1;
            @endphp
            @foreach($mostPopularProductSoFar as $mostPopularProductSoFars)
            <tr>
                <th class="nowrap" scope="row">{{ $num++ }}</th>
                <td>{{ $mostPopularProductSoFars -> product_code }}</td>
                <td>{{ $mostPopularProductSoFars -> product_name }}</td>
                <td>Rp. {{ number_format($mostPopularProductSoFars -> price, 2, ',', '.') }}</td>
                <td>{{ $mostPopularProductSoFars -> total_sold }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>