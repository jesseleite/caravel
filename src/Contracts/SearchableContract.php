<?php

namespace ThisVessel\Caravel\Contracts;

interface SearchableContract
{
    /**
     * Eloquent query scope for allowing user search on resource model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $keywords
     * @return bool
     */
    public function scopeSearch($query, $keywords);
}
