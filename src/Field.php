<?php

namespace ThisVessel\Caravel;

class Field
{
    public $name;
    public $label;
    public $type;
    public $listable = true;
    public $required = false;
    public $help = null;
    public $modifiers = null;
    public $rules = null;
    protected $options = null;

    public function __construct($name, $dbalType, $options = null)
    {
        $this->setName($name);
        $this->setTypeFromDbal($dbalType);
        $this->setOptions($options);
        $this->setEdgeCases();
        $this->setLabel();
        $this->setHelp();
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setTypeFromDbal($type)
    {
        if ($type instanceof \Doctrine\DBAL\Types\TextType) {
            $this->type = 'textarea';
        } else {
            $this->type = 'input';
        }
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
    }

    public function setEdgeCases()
    {
        $this->unlistIfPassword();
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

    public function unlistIfPassword()
    {
        if ($this->type == 'password') {
            $this->setUnlisted();
        }
    }

    public function setType($type)
    {
        $this->type = $type;
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

    public function listable()
    {
        return $this->listable;
    }

    public function __toString()
    {
        return $this->name;
    }
}
