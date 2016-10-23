<?php

namespace SimonBowen\IsamsDrivers\Models;

use SimonBowen\IsamsDrivers\Eloquent\Relations\StaffSets;

class Staff extends BaseModel
{
    protected $table = 'TblStaff';
    protected $primaryKey = 'TblStaffID';

    public function sets()
    {
        return new StaffSets((new Set())->newQuery(), $this, 'TblTeachingManagerSetAssociatedTeachers', 'txtTeacher', 'intSetID');
    }
}
