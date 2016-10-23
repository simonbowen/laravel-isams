<?php

namespace SimonBowen\IsamsDrivers\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SetStaff extends BelongsToMany
{
    protected function setJoin($query = null)
    {
        $query = $query ?: $this->query;
        $baseTable = $this->related->getTable();
        $key = $baseTable.'.User_Code';
        $query->join($this->table, $key, '=', $this->getOtherKey());

        return $this;
    }
}
