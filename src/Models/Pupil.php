<?php

namespace SimonBowen\IsamsDrivers\Models;

use SimonBowen\IsamsDrivers\Eloquent\Relations\PupilSets;

class Pupil extends BaseModel
{
    protected $table = 'TblPupilManagementPupils';
    protected $primaryKey = 'TblPupilManagementPupilsID';

    public function sets()
    {
        return new PupilSets((new Set())->newQuery(), $this, 'TblTeachingManagerSetLists', 'txtSchoolID', 'intSetID');
    }
}
