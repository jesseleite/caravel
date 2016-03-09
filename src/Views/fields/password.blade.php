<!-- Password Input -->
{!! $bootForm->password($field->label, $field)
             ->helpBlock($field->help) !!}

@if (str_contains($field->rules, 'confirmed'))
    {!! $bootForm->password("{$field->label} Confirmation", "{$field}_confirmation")
                 ->helpBlock($field->help) !!}
@endif
