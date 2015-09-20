<?php

namespace SimonBowen\IsamsDrivers\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class BaseModel extends Model {

    public function __construct(array $attributes = [])
    {
        $this->connection = Config::get('isams.db.connection');
        parent::__construct($attributes);
    }

}