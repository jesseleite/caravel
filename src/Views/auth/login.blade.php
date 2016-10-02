<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    @include('caravel::shame.css')

</head>
<body>
    <div class="container">

        <!-- Login Form -->
        <div class="col-md-6 col-md-offset-3">
            <h1 class="display-4">Caravel Admin</h1>
            <p class="lead">Powered by This Vessel</p>
            @inject('bootForm', 'bootform')
            {!! $bootForm->open()->action(config('caravel.auth.login')) !!}
                {!! $bootForm->email('Email', 'email')->autofocus() !!}
                {!! $bootForm->password('Password', 'password') !!}
                {!! $bootForm->submit('Login')->addClass('btn-primary m-t-1') !!}
            {!! $bootForm->close() !!}
        </div>

    </div>
</body>
</html>
