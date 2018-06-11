<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 04.06.18
 * Time: 17:23
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 * @package App\Facades
 */
class Api extends Facade
{
    protected static function getFacadeAccessor() { return 'internal_api'; }
}