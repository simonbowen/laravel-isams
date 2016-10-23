<?php

namespace SimonBowen\IsamsDrivers\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SetPupils extends BelongsToMany
{
    protected function setJoin($query = null)
    {
        $query = $query ?: $this->query;
        $baseTable = $this->related->getTable();
        $key = $baseTable.'.txtSchoolID';
        $query->join($this->table, $key, '=', $this->getOtherKey());

        return $this;
    }
}
