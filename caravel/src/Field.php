<?php

namespace ThisVessel\Caravel;

class Field
{
    public $name;
    public $label;
    public $type;
    public $required;
    protected $userOptions;
    protected $databaseType;

    public function __construct($name, $type, $options = null)
    {
        $this->name = $name;
        $this->label = ucfirst($name);
        $this->databaseType = $type;
        $this->userOptions = $this->parseOptions($options);
        $this->setType($type);
        $this->setRequired();
    }

    public function parseOptions($options)
    {
        // If empty, return array.
        if (empty($options)) {
            return [];
        }

        // If array, return as is.
        if (is_array($options)) {
            return $options;
        }

        // If string, explode on pipe separators into array.
        if (is_string($options)) {
            $options  = explode('|', $options);
        }

        // Set option key and value.
        foreach ($options as $option) {
            $options = array_diff($options, [$option]);
            if (strpos($option, ':')) {
                $option = explode(':', $option);
                $options[$option[0]] = $option[1];
            } else {
                $options[$option] = true;
            }
        }

        // If option has multiple values, convert to array and nest.
        foreach ($options as $key => $option) {
            if (strpos($option, ',')) {
                $options[$key] = explode(',', $option);
            }
        }

        return $options;
    }

    public function setType($type)
    {
        if (isset($this->userOptions['type'])) {
            $this->type = $this->userOptions['type'];
        } elseif (str_contains($type, 'text')) {
            $this->type = 'textarea';
        } else {
            $this->type = 'input';
        }
    }

    public function setRequired()
    {
        if (! isset($this->userOptions['required'])) {
            $this->required = false;
        } else {
            $this->required = true;
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}
