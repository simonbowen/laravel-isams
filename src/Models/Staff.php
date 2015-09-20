<?php

namespace SimonBowen\IsamsDrivers\Models;

use Illuminate\Database\Eloquent\Model;

use SimonBowen\IsamsDrivers\Eloquent\Relations\StaffSets;

class Staff extends Model {

    protected $table = 'TblStaff';
    protected $primaryKey = 'TblStaffID';

    public function sets()
    {
        return new StaffSets((new Set)->newQuery(), $this, 'TblTeachingManagerSetAssociatedTeachers', 'txtTeacher', 'intSetID');
    }

}