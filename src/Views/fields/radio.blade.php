<!-- Radio Inputs -->
<div class="form-group {{ $errors->has($field->name) ? 'has-error' : '' }}">
    {!! $form->label($field->label) !!}
    @foreach ($model->{$field->typeParams[0]} as $value => $option)
        <div class="radio">
            <label>
                {!! $form->radio($field->name, $value) !!}
                {{ $option }}
            </label>
        </div>
    @endforeach
    {!! $errors->first($field->name, '<p class="help-block">:message</p>') !!}
</div>
