<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 50px 0;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .nav {
            margin-bottom: 30px;
        }
        .version {
            color: #ccc;
        }
        th.actions,
        td.actions {
            text-align: right;
        }
        td.actions > a {
            /*margin-bottom: 7px; Fix this when collapsed for small screens. */
        }
        #confirm-delete {
            display: inline-block;
        }
    </style>
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
                        <a href="{{ $prefix }}/dashboard" class="nav-link {{ !isset($resource) ? 'active' : '' }}">Dashboard</a>
                    </li>
                    @foreach (config('caravel.resources') as $uri => $model)
                        <li class="nav-item">
                            <a href="{{ $prefix }}/{{ $uri }}" class="nav-link {{ isset($resource) && $resource == $uri ? 'active' : '' }}">{{ ucfirst($uri) }}</a>
                        </li>
                    @endforeach
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
