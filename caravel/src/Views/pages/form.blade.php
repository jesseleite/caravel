@extends('caravel::master')

@inject('form', 'adamwathan.form')
@inject('bootForm', 'bootform')

@section('container')

    <div class="row">
        <div class="col-md-12">

            {!! $bootForm->open()->action($action)->addClass('caravel-form') !!}
                @if (isset($model))
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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.min.js"></script>
    <script>
        new Vue({
            el: '#caravel-list-resource',
            ready: function() {
                console.log('list loaded');
            }
        });
    </script> --}}

@endsection
