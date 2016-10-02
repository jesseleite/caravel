<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin - @yield('title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    @include('caravel::shame.css')
    @stack('stylesheets')

</head>
<body>
    <div class="container">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="display-4">Caravel Admin</h1>
            <p class="lead">Powered by This Vessel</p>
        </div>

        <!-- Page Wrapper -->
        <div class="row">

            <!-- Navigation -->
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="nav-item">
                        <a href="{{ route('caravel::dashboard') }}" class="nav-link {{ !isset($resource) ? 'active' : '' }}">Dashboard</a>
                    </li>
                    @inject('drawbridge', '\ThisVessel\Caravel\Helpers\Drawbridge')
                    @foreach (config('caravel.resources') as $uri => $model)
                        @if ($drawbridge::allows('manage', new $model))
                            <li class="nav-item">
                                <a href="{{ route('caravel::' . $uri . '.index') }}" class="nav-link {{ isset($resource) && $resource == $uri ? 'active' : '' }}">{{ ucwords(implode(' ', explode('-', $uri))) }}</a>
                            </li>
                        @endif
                    @endforeach
                    @if (config('caravel.auth.logout'))
                        <li class="nav-item">
                            @if (substr(config('caravel.auth.logout'), 0, 1) == '/')
                                <a href="{{ config('caravel.auth.logout') }}" class="nav-link m-t-1 logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a>
                            @else
                                <a href="/{{ config('caravel.auth.logout') }}" class="nav-link m-t-1 logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Container -->
            <div class="col-md-9">
                @yield('container')
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js"></script>
    @include('caravel::shame.js')
    @stack('scripts')

</body>
</html>
