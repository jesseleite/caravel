<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    @include('caravel::shame.css')

</head>
<body>

    <div class="container">

        <div class="page-header">
            <h1>Caravel Admin</h1>
            <p class="lead">Powered by This Vessel</p>
        </div>

        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="nav-item">
                        <a href="{{ route('caravel::dashboard') }}" class="nav-link {{ !isset($resource) ? 'active' : '' }}">Dashboard</a>
                    </li>
                    @foreach (config('caravel.resources') as $uri => $model)
                        <li class="nav-item">
                            <a href="{{ route('caravel::' . $uri . '.index') }}" class="nav-link {{ isset($resource) && $resource == $uri ? 'active' : '' }}">{{ ucfirst($uri) }}</a>
                        </li>
                    @endforeach
                    @if (config('caravel.logout'))
                        <li class="nav-item">
                            @if (substr(config('caravel.logout'), 0, 1) == '/')
                                <a href="{{ config('caravel.logout') }}" class="nav-link m-t logout"><i class="fa fa-sign-out">&nbsp;&nbsp;Logout</i></a>
                            @else
                                <a href="/{{ config('caravel.logout') }}" class="nav-link m-t logout"><i class="fa fa-sign-out">&nbsp;&nbsp;Logout</i></a>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-9">
                @yield('container')
            </div>
        </div>

    </div>

    @yield('scripts')

</body>
</html>
