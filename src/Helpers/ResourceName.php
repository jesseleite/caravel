<?php

namespace ThisVessel\Caravel\Helpers;

class ResourceName
{
    public $original;

    protected $mutated;

    protected $slug;

    public function __construct($resource)
    {
        $this->original = $resource;
        $this->mutated = $this->default($resource);
        $this->slug = $this->slug();
    }

    public function plural()
    {
        $this->mutated = str_plural($this->mutated);

        return $this;
    }

    public function singular()
    {
        $this->mutated = str_singular($this->mutated);

        return $this;
    }

    public function lower()
    {
        $this->mutated = strtolower($this->mutated);

        return $this;
    }

    public function title()
    {
        $this->mutated = ucwords($this->mutated);

        return $this;
    }

    public function slug()
    {
        return str_slug(å, '-');
    }

    protected function default($resource)
    {
        return $this->title(str_replace('-', ' ', $resource));
    }

    public function __toString()
    {
        return $this->mutated;
    }
}
