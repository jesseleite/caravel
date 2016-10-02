<!-- Checkbox Inputs -->
<div class="form-group {{ $errors->has($field->name) ? 'has-error' : '' }}">
    {!! $form->label($field->label) !!}
    @foreach ($model->{$field->typeParams[0]} as $value => $option)
        <div class="checkbox">
            <label>
                @if (count($model->{$field->typeParams[0]}) > 1)
                    {!! $form->checkbox($field->name . '[]', $value) !!}
                @else
                    {!! $form->checkbox($field->name, $value) !!}
                @endif
                {{ $option }}
            </label>
        </div>
    @endforeach
    {!! $errors->first($field->name, '<p class="help-block">:message</p>') !!}
</div>
