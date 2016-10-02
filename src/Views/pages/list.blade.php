@extends('caravel::master')

@section('title', ucfirst($resource))

@inject('drawbridge', '\ThisVessel\Caravel\Helpers\Drawbridge')

@inject('form', 'adamwathan.form')
@inject('bootForm', 'bootform')

@section('container')

    @include('caravel::components.alert')

    <!-- Resource List -->
    <div class="row">
        <div class="col-md-12">
            @if ($items->count() > 0 || $search)

                <!-- Resource List Top Toolbar -->
                <div class="list-toolbar row">
                    @if ($searchable)
                        <div class="col-md-6">
                            @if ($search)
                                <a href="{{ route('caravel::' . $resource . '.index') }}" class="btn btn-link pull-right btn-close"><i class="fa fa-times-circle"></i></a>
                            @endif
                            {!! $bootForm->open()->get() !!}
                                {!! $bootForm->inputGroup('Search', 'search')
                                             ->hideLabel()
                                             ->placeholder('Search ' . ucwords(implode(' ', explode('-', $resource))))
                                             ->beforeAddon('<i class="fa fa-search"></i>')
                                             ->value($search) !!}
                            {!! $bootForm->close() !!}
                        </div>
                    @endif
                    <div class="{{ $searchable ? 'col-md-6' : 'col-md-12' }}">
                        <div class="pull-right m-l-1">
                            @include('caravel::components.pagination')
                        </div>
                        <div class="pull-right m-l-1">
                            @include('caravel::components.advanced-dropdown')
                        </div>
                    </div>
                </div>

                <!-- Resource List Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                @foreach ($fields as $field)
                                    @if ($field->listable())
                                        <th>{{ $field->label }}</th>
                                    @endif
                                @endforeach
                                <th class="text-xs-right text-nowrap">
                                    @if ($drawbridge::allows('create', $newInstance))
                                        <a href="{{ route('caravel::' . $resource . '.create') }}" class="btn btn-outline-primary btn-sm pull-right"><i class="fa fa-file-o"></i></a>
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr class="{{ $softDeletes && ! is_null($item->{$softDeletes}) ? 'table-danger' : null }}">
                                    @foreach ($fields as $field)
                                        @if ($field->listable())
                                            @unless ($field->relation)
                                                <td>{{ $field->listAccessor ? $item->{$field->listAccessor} : str_limit($item->$field, 40) }}</td>
                                            @else
                                                <td>{{ $field->listAccessor ? $item->{$field->relation}->{$field->listAccessor} : str_limit($item->$field, 40) }}</td>
                                            @endunless
                                        @endif
                                    @endforeach
                                    <td class="text-xs-right text-nowrap">
                                        @unless ($drawbridge::allows('delete', $item) && $softDeletes && ! is_null($item->{$softDeletes}))
                                            @if ($drawbridge::allows('update', $item))
                                                <a href="{{ route('caravel::' . $resource . '.edit', $item) }}" class="btn btn-outline-warning btn-sm" role="button">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endif
                                            @if ($drawbridge::allows('delete', $item))
                                                <a href="{{ route('caravel::' . $resource . '.destroy', $item) }}" class="btn btn-outline-danger btn-sm" role="button" data-toggle="modal" data-target="#modal-delete">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            @endif
                                        @else
                                            {!! $form->open()->action(route('caravel::' . $resource . '.restore', $item))!!}
                                                {!! $form->submit('<i class="fa fa-undo"></i>')->addClass('btn btn-outline-danger btn-sm') !!}
                                            {!! $form->close() !!}
                                        @endunless
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($fields) }}">
                                        No {{ implode(' ', explode('-', $resource)) }} were found!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Resource List Bottom Toolbar -->
                <div class="list-toolbar row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            @include('caravel::components.pagination')
                        </div>
                    </div>
                </div>

            @else

                <!-- No Resources Card -->
                <div class="card card-block">
                    <h3 class="card-title">Nothing to see here!</h3>
                    <p class="card-text">Ready to get started?  It's easy!  Create your first {{ str_singular($resource) }} now...</p>
                    <a href="{{ route('caravel::' . $resource . '.create') }}" class="btn btn-outline-primary"><i class="fa fa-file-o"></i> Create {{ ucfirst(str_singular($resource)) }}</a>
                </div>

            @endif
        </div>
    </div>

    @include('caravel::components.modals.delete')

@endsection
