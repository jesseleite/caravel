<?php

namespace ThisVessel\Caravel;

class Field
{
    public $name;
    public $label;
    public $type;
    public $required = false;
    public $help = null;
    public $rules = null;
    protected $options = null;

    public function __construct($name, $type, $options = null)
    {
        $this->setName($name);
        $this->setTypeFromDbal($type);
        $this->setOptions($options);
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

        if (isset($options['rules'])) {
            $this->setRules($options['rules']);
        }
    }

    public function separateModifiersFromValidationRules($options)
    {
        $options = explode('|', $options);
        $rules   = [];

        foreach ($options as $option) {

            // If type modifier provided, set on object.
            if (str_contains($option, 'type:')) {
                $type = explode(':', $option);
                $this->setType($type[1]);
            }

            // If required modifier provided, set on object and save as validation rule.
            elseif ($option == 'required') {
                $this->setRequired(true);
                $rules[] = $option;
            }

            // Else pass all other options as validation rules.
            else {
                $rules[] = $option;
            }
        }

        $this->setRules(implode('|', $rules));
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
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
        return $this->type == 'password' ? false : true;
    }

    public function __toString()
    {
        return $this->name;
    }
}
