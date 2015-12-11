@extends('caravel::master')

@inject('form', 'adamwathan.form')
@inject('bootForm', 'bootform')

@section('container')

    <div class="row">
        <div class="col-md-12">
            {!! $bootForm->open()->action($action)->multipart()->addClass('caravel-form') !!}
                @if (isset($model->id))
                    {!! $bootForm->bind($model) !!}
                    {!! $bootForm->hidden('_method')->value('PUT') !!}
                @endif
                @foreach ($fields as $field)
                    @include('caravel::fields.' . $field->type, ['field' => $field])
                @endforeach
                {!! $bootForm->submit('Save')->addClass('btn-primary m-t') !!}
            {!! $bootForm->close() !!}
        </div>
    </div>

@endsection
