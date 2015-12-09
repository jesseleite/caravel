{{-- <fieldset class="form-group {{ $errors->has($field->name) ? 'has-error' : '' }}">
    <label for="{{ $field }}">{{ $field->label }}</label>
    <textarea id="{{ $field }}" name="{{ $field }}" class="form-control" rows="5">{{ old($field->name) }}</textarea>
    @if ($errors->has($field->name))
        <small class="help-block">{{ $errors->first($field->name, ':message') }}</small>
    @elseif (isset($field->help))
        <small class="text-muted">{{ $field->help }}</small>
    @endif
</fieldset> --}}

{{-- {!! BootForm::textarea($field->label, $field) !!} --}}
{!! $app['bootform']->textarea($field->label, $field) !!}
