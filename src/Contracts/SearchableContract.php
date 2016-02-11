<?php

namespace ThisVessel\Caravel\Contracts;

interface SearchableContract
{
    /**
     * Determine if the entity has a given ability.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $keywords
     * @return bool
     */
    public function scopeSearch($query, $keywords);
}
