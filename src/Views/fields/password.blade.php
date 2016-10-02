<!-- Password Input -->
{!! $bootForm->password($field->label, $field)
             ->helpBlock($field->help) !!}

@if (str_contains($field->rules, 'confirmed'))
    {!! $bootForm->password("Confirm {$field->label}", "{$field}_confirmation")
                 ->helpBlock($field->help) !!}
@endif
