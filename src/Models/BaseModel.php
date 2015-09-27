<?php

namespace SimonBowen\IsamsDrivers\Models;

use Config;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public function getConnection()
    {
        return static::resolveConnection(Config::get('isams.db.connection'));
    }

}