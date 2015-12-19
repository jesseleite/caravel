<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caravel Admin</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    @include('caravel::shame.css')

</head>
<body>
    <div class="container">

        <!-- Login Form -->
        <div class="col-md-6 col-md-offset-3">
            <h1 class="display-4">Caravel Admin</h1>
            <p class="lead">Powered by This Vessel</p>
            {!! BootForm::open()->action('/auth/login') !!}
                {!! BootForm::email('Email', 'email')->autofocus() !!}
                {!! BootForm::password('Password', 'password') !!}
                {!! BootForm::submit('Login')->addClass('btn-primary m-t-1') !!}
            {!! BootForm::close() !!}
        </div>

    </div>
</body>
</html>
