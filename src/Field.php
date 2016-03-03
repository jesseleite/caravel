<?php

namespace ThisVessel\Caravel;

class Field
{
    public $name;
    public $label;
    public $type;
    public $typeParams = null;
    public $nullable = false;
    public $listable = true;
    public $listAccessor = null;
    public $required = false;
    public $help = null;
    public $modifiers = null;
    public $rules = null;
    public $relation = false;
    protected $options = null;

    public function __construct($name, $dbalType, $nullable, $options = null)
    {
        $this->setName($name);
        $this->setTypeFromDbal($dbalType);
        $this->setNullable($nullable);
        $this->setOptions($options);
        $this->setEdgeCases();
        $this->setLabel();
        $this->setHelp();
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        if (str_contains($type, ',')) {
            $exploded = explode(',', $type);
            $type = $exploded[0];
            $this->setTypeParams($exploded, true);
        }

        $this->type = $type;
    }

    public function setTypeParams($params, $removeType = false)
    {
        if ($removeType) {
            unset($params[0]);
            $params = array_values($params);
        }

        $this->typeParams = $params;
    }

    public function setListAccessor($accessor)
    {
        $this->listAccessor = $accessor;
    }

    public function setUnlisted()
    {
        $this->listable = false;
    }

    public function setRequired()
    {
        $this->required = true;
    }

    public function setLabel()
    {
        if (isset($this->options['label'])) {
            $this->label = $this->options['label'];
        } else {
            $this->label = ucwords(str_replace('_', ' ', $this->name));
        }
    }

    public function setHelp()
    {
        if (isset($this->options['help'])) {
            $this->help = $this->options['help'];
        }
    }

    public function setRelation($relation)
    {
        $exploded = explode(',', $relation);
        $relation = $exploded[0];
        $accessor = isset($exploded[1]) ? $exploded[1] : false;

        $this->relation = $relation;

        if (! $this->listAccessor && $accessor) {
            $this->setListAccessor($accessor);
        }
    }

    public function listable()
    {
        return $this->listable;
    }

    public function setTypeFromDbal($type)
    {
        if ($type instanceof \Doctrine\DBAL\Types\TextType) {
            $this->type = 'textarea';
        } else {
            $this->type = 'input';
        }
    }

    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        if (is_string($options)) {
            $this->separateModifiersFromValidationRules($options);
        }

        if (isset($options['type'])) {
            $this->setType($options['type']);
        }

        if (isset($options['modifiers'])) {
            $this->setModifiers($options['modifiers']);
        }

        if (isset($options['rules'])) {
            $this->setRules($options['rules']);
        }

        if (isset($options['relation'])) {
            $this->setRelation($options['relation']);
        }
    }

    public function separateModifiersFromValidationRules($options)
    {
        $options   = explode('|', $options);
        $modifiers = [];
        $rules     = [];

        // Loop through options and set object state accordingly.
        foreach ($options as $option) {

            // If type modifier provided, set on object.
            if (str_contains($option, 'type:')) {
                $modifiers[] = $option;
            }

            // If type modifier provided, set on object.
            elseif (str_contains($option, 'list:')) {
                $modifiers[] = $option;
            }

            // If type modifier provided, set on object.
            elseif (str_contains($option, 'relation:')) {
                $modifiers[] = $option;
            }

            // If unlist modifier provided, set on object.
            elseif ($option == 'unlist') {
                $modifiers[] = $option;
            }

            // Else pass all other options as validation rules.
            else {
                $rules[] = $option;
            }
        }

        $this->setModifiers(implode('|', $modifiers));
        $this->setRules(implode('|', $rules));
    }

    public function setModifiers($modifiers)
    {
        $modifiers = explode('|', $modifiers);

        // Loop through options and set object state accordingly.
        foreach ($modifiers as $modifier) {

            // If type modifier provided, set on object.
            if (str_contains($modifier, 'type:')) {
                $type = explode(':', $modifier);
                $this->setType($type[1]);
            }

            // If list modifier provided, set on object.
            elseif (str_contains($modifier, 'list:')) {
                $accessor = explode(':', $modifier);
                $this->setListAccessor($accessor[1]);
            }

            // If list modifier provided, set on object.
            elseif (str_contains($modifier, 'relation:')) {
                $relation = explode(':', $modifier);
                $this->setRelation($relation[1]);
            }

            // If unlist modifier provided, set on object.
            elseif ($modifier == 'unlist') {
                $this->setUnlisted();
            }
        }

        $this->modifiers = $modifiers ? implode('|', $modifiers) : null;
    }

    public function setRules($rules)
    {
        $rules = explode('|', $rules);

        // Loop through rules and set object state accordingly.
        foreach ($rules as $rule) {

            // If required modifier provided, set on object and save as validation rule.
            if ($rule == 'required') {
                $this->setRequired();
            }
        }

        $this->rules = $rules ? implode('|', $rules) : null;
    }

    public function setEdgeCases()
    {
        $this->unlistIfPassword();
    }

    public function unlistIfPassword()
    {
        if ($this->type == 'password') {
            $this->setUnlisted();
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}
