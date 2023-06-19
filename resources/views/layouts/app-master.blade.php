<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/chart js/chart.umd.min.js') }}"></script>
    <title>Dashboard</title>

    <!-- Material Icon -->
    <link rel="stylesheet" href="{{ asset('assets/icon/MaterialIcon.css') }}">
    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap"
        rel="stylesheet">

    <style>
    * {
        font-family: 'Nunito', sans-serif;
    }

    .nowrap {
        white-space: nowrap;
        width: 1%;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>


    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">
</head>

<body>

    @include('layouts.partials.navbar')

    <main class="container">
        @yield('content')
    </main>
 
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
   
</body>

</html>