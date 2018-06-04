<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    /**
     * @return string Model's table name
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
