<fieldset class="form-group {{ $errors->has($field->name) ? 'has-error' : '' }}">
    <label for="{{ $field }}">{{ $field->label }}</label>
    <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" value="{{ old($field->name) }}">
    @if ($errors->has($field->name))
        <small class="help-block">{{ $errors->first($field->name, ':message') }}</small>
    @elseif (isset($field->help))
        <small class="text-muted">{{ $field->help }}</small>
    @endif
</fieldset>
