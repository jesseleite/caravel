<?php

namespace ThisVessel\Caravel;

class Field
{
    protected $table;
    protected $field;
    public $label;
    protected $options;

    public function __construct($table, $field, $options = null)
    {
        $this->table = $table;
        $this->field = $field;
        $this->label = ucfirst($field);
        $this->setOptions($options);
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

    public function setOptions($options)
    {
        $this->options = $this->parseOptions($options);
    }

    public function option($key)
    {
        return $this->options[$key];
    }

    public function __toString()
    {
        return $this->field;
    }

    // public function __get($attribute)
    // {
    //     return $this->$options[$attribute];
    // }
}
