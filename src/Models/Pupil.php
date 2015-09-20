<?php

namespace SimonBowen\IsamsDrivers\Models;

use Illuminate\Database\Eloquent\Model;

use SimonBowen\IsamsDrivers\Repositories\Eloquent\Relations\PupilSets;

class Pupil extends Model {

    protected $table = 'TblPupilManagementPupils';
    protected $primaryKey = 'TblPupilManagementPupilsID';

    public function sets()
    {
        return new PupilSets((new Set)->newQuery(), $this, 'TblTeachingManagerSetLists', 'txtSchoolID', 'intSetID');
    }

}