<?php

namespace SimonBowen\IsamsDrivers\Models;

class BoardingHouse extends BaseModel
{
    protected $table = 'TblSchoolManagementHouses';

    public function housemaster()
    {
        return $this->belongsTo(Staff::class, 'User_Code', 'txtHouseMaster');
    }

    public function pupils()
    {
        return $this->hasMany(Pupil::class);
    }

    public function getHousemaster()
    {
        return $this->housemaster;
    }
}
