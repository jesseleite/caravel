@extends('caravel::master')

@section('container')

    <div class="row">
        <div class="col-md-12">
            <table id="caravel-list-resource" class="table">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <th>{{ $field->label }}</th>
                        @endforeach
                        <th class="actions">
                            <a href="{{ $prefix }}/{{ $resource }}/create" class="btn btn-sm btn-primary-outline pull-right"><i class="fa fa-file-o"></i></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            @foreach ($fields as $field)
                                <td>{{ str_limit($item->$field, 25) }}</td>
                            @endforeach
                            <td class="actions">
                                <a href="{{ $prefix }}/{{ $resource }}/{{ $item->id }}/edit" class="btn btn-warning-outline btn-sm" ole="button"><i class="fa fa-pencil"></i></a>
                                <a href="{{ $prefix }}/{{ $resource }}/{{ $item->id }}/delete" class="btn btn-danger-outline btn-sm" ole="button"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
