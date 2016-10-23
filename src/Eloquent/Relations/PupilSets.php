<?php

namespace SimonBowen\IsamsDrivers\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PupilSets extends BelongsToMany
{
    protected function setJoin($query = null)
    {
        $query = $query ?: $this->query;
        $baseTable = $this->related->getTable();
        $key = $baseTable.'.TblTeachingManagerSetsID';
        $query->join($this->table, $key, '=', $this->getOtherKey());

        return $this;
    }

    protected function setWhere()
    {
        $foreign = $this->getForeignKey();
        $this->query->where($foreign, '=', $this->parent->txtSchoolID);

        return $this;
    }
}
