<!-- Select -->
{!! $bootForm->select($field->label, $field)
             ->helpBlock($field->help)
             ->options($model->{$field->typeParams[0]}) !!}
