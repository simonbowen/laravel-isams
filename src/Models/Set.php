<?php

namespace SimonBowen\IsamsDrivers\Models;

use SimonBowen\IsamsDrivers\Eloquent\Relations\SetPupils;
use SimonBowen\IsamsDrivers\Eloquent\Relations\SetStaff;

class Set extends BaseModel {

    protected $table = 'TblTeachingManagerSets';
    protected $primaryKey = 'TblTeachingManagerSetsID';

    public function teachers()
    {
        return new SetStaff((new Staff)->newQuery(), $this, 'TblTeachingManagerSetAssociatedTeachers', 'intSetID', 'txtTeacher');
    }

    public function primary_teacher()
    {
        return $this->belongsTo(Staff::class, 'txtTeacher', 'User_Code');
    }

    public function pupils()
    {
        return new SetPupils((new Pupil)->newQuery(), $this, 'TblTeachingManagerSetLists', 'intSetID', 'txtSchoolID');
    }

}