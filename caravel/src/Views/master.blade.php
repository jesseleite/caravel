<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <style>

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul>
                    @foreach (config('caravel.resources') as $resource => $model)
                        <li>{{ ucfirst($resource) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9">
                @yield('container')
            </div>
        </div>
    </div>
</body>
</html>
