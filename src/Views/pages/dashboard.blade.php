@extends('caravel::master')

@section('title', 'Dashboard')

@section('container')

    <!-- Dashboard -->
    <div class="row">

        <!-- Welcome Card -->
        <div class="col-md-6">
            <div class="card card-block m-b-2">
                <h3 class="card-title">Welcome</h3>
                <p class="card-text">Welcome to your website administration control panel! Here you can manage your website content and view analytics. Thank you for choosing This Vessel!</p>
                <p class="card-text version">Installed Version: 2.0.0-beta</p>
            </div>
        </div>

        <!-- Analytics Card -->
        <div class="col-md-6">
            <div class="card card-block m-b-2">
                <h3 class="card-title">Visitor Analytics</h3>
                <p class="card-text"></p>
                <button class="btn btn-secondary-outline">Coming soon!</a>
            </div>
        </div>

    </div>

@endsection
