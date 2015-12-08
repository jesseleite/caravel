@extends('caravel::master')

@section('container')

    <div class="row">
        <div class="col-md-12">
            <form action="{{ $prefix }}/{{ $resource }}" method="POST" class="caravel-form">
                {{ csrf_field() }}
                @foreach ($fields as $field)
                    @include('caravel::fields.' . $field->type, ['field' => $field])
                @endforeach
                <button type="submit" class="btn btn-primary m-t">Save</button>
            </form>
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
