<?php

namespace SimonBowen\IsamsDrivers\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StaffSets extends BelongsToMany {

    protected function setJoin($query = null)
    {
        $query = $query ?: $this->query;
        $baseTable = $this->related->getTable();
        $key = $baseTable.'.'.$this->related->getKeyName();
        $query->leftJoin($this->table, $key, '=', $this->getOtherKey());
        return $this;
    }

    protected function setWhere()
    {
        $foreign = $this->getForeignKey();
        $this->query->where($foreign, '=', $this->parent->User_Code);
        $this->query->orWhereIn('TblTeachingManagerSetsID', function ($q) {
            return $q->select('TblTeachingManagerSetsID')->from('TblTeachingManagerSets')->where('txtTeacher', $this->parent->User_Code);
        });
        return $this;
    }

}