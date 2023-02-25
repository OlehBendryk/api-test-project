    <!DOCTYPE html>
<html lang="ua">
<head>
    <meta name="csrf-token" content="<?= csrf_token() ?>" />
    <meta name="csrf-param" content="_token" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--    <link rel="shortcut icon" href="{{ URL::asset('img/logo.png') }}" type="image/x-icon">--}}
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" >
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}">

</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
{{--    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('admin') }}">--}}
        <i class="fas fa-users-cog"> ApiTest</i>
        <p class="fs-6 text-muted">Dashboard

        </p>
{{--    </a>--}}
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>

<div class="container-fluid">
    <div class="row">

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <div>
                @yield('content')
            </div>

        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
        crossorigin="anonymous"></script>
<script src="{{ URL::asset('rails.js') }}"></script>
@yield('scripts')
</body>

</html>
