@extends('caravel::master')

@section('container')

    <div class="row">
        <div class="col-md-12">
            {!! BootForm::open()->action($action)->addClass('caravel-form') !!}
                @if (isset($model))
                    {!! BootForm::bind($model) !!}
                    {!! BootForm::hidden('_method')->value('PUT') !!}
                @endif
                @foreach ($fields as $field)
                    @include('caravel::fields.' . $field->type, ['field' => $field])
                @endforeach
                {!! BootForm::submit('Save')->addClass('btn-primary m-t') !!}
            {!! BootForm::close() !!}
            {{-- <form action="{{ $prefix }}/{{ $resource }}" method="POST" class="caravel-form">
                @foreach ($fields as $field)
                    @include('caravel::fields.' . $field->type, ['field' => $field])
                @endforeach
                <button type="submit" class="btn btn-primary m-t">Save</button>
            </form> --}}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.min.js"></script>
    <script>
        new Vue({
            el: '#caravel-list-resource',
            ready: function() {
                console.log('list loaded');
            }
        });
    </script>

@endsection
