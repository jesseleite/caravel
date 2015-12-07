@extends('caravel::master')

@section('container')

    <table id="caravel-list-resource">
        <tr>
            <th>ID</th>
            <th>Actions</th>
            @foreach ($model::getCrudFields() as $field)
                <th>{{ $field->label }}</th>
            @endforeach
        </tr>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <a href="{{ $resource }}/{{ $item->id }}/edit">Edit</a>
                    <a href="{{ $resource }}/{{ $item->id }}/delete">Delete</a>
                </td>
                @foreach ($model::getCrudFields() as $field)
                    <td>{{ str_limit($item->$field, 25) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>

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
