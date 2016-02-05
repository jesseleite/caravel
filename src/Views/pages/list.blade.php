@extends('caravel::master')

@section('title', ucfirst($resource))

@inject('drawbridge', '\ThisVessel\Caravel\Helpers\Drawbridge')

@section('container')

    @include('caravel::components.alert')

    <!-- Resource List -->
    <div class="row">
        <div class="col-md-12">
            @if ($items->count() > 0)
                <div class="pull-right">
                    @include('caravel::components.pagination')
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            @foreach ($fields as $field)
                                @if ($field->listable())
                                    <th>{{ $field->label }}</th>
                                @endif
                            @endforeach
                            <th class="actions">
                                @if ($drawbridge::allows('create', $newInstance))
                                    <a href="{{ route('caravel::' . $resource . '.create') }}" class="btn btn-sm btn-primary-outline pull-right"><i class="fa fa-file-o"></i></a>
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                @foreach ($fields as $field)
                                    @if ($field->listable())
                                        <td>{{ str_limit($item->$field, 25) }}</td>
                                    @endif
                                @endforeach
                                <td class="actions">
                                    @if ($drawbridge::allows('update', $item))
                                        <a href="{{ route('caravel::' . $resource . '.edit', $item) }}"class="btn btn-warning-outline btn-sm" role="button">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endif
                                    @if ($drawbridge::allows('delete', $item))
                                    <a href="{{ route('caravel::' . $resource . '.destroy', $item) }}" class="btn btn-danger-outline btn-sm delete" role="button" data-toggle="modal" data-target=".bd-example-modal-sm">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    @include('caravel::components.pagination')
                </div>
            @else
                <div class="card card-block">
                    <h3 class="card-title">Nothing to see here!</h3>
                    <p class="card-text">Ready to get started?  It's easy!  Create your first {{ str_singular($resource) }} now...</p>
                    <a href="{{ route('caravel::' . $resource . '.create') }}" class="btn btn-primary-outline"><i class="fa fa-file-o"></i> Create {{ ucfirst(str_singular($resource)) }}</a>
                </div>
            @endif
        </div>
    </div>

    @include('caravel::components.modals.delete')

@endsection
