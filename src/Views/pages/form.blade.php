@extends('caravel::master')

@section('title', ucfirst($resource))

@inject('form', 'adamwathan.form')
@inject('bootForm', 'bootform')

@section('container')

    <!-- Resource Form -->
    <div class="row">
        <div class="col-md-12">
            {!! $bootForm->open()->action($action)->multipart()->addClass('caravel-form') !!}
                @if ($model->getKey())
                    {!! $bootForm->bind($bindable) !!}
                    {!! $bootForm->hidden('_method')->value('PUT') !!}
                @endif
                @include('caravel::forms.' . $formPartial)
                {!! $bootForm->submit('Save')->addClass('btn-primary m-t-1') !!}
            {!! $bootForm->close() !!}
        </div>
    </div>

@endsection
