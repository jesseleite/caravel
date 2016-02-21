@foreach ($fields as $field)
    @include('caravel::components.field', compact($field))
@endforeach
