<!-- File Input -->
@if ($model->{$field})
    {!! $bootForm->text('Current ' . $field->label, 'current_' . $field)
                 ->disable()
                 ->value($model->{$field}) !!}

    {!! $bootForm->file('New ' . $field->label, $field)
                 ->helpBlock($field->help) !!}
@else
    {!! $bootForm->file($field->label, $field)
                 ->helpBlock($field->help) !!}
@endif
