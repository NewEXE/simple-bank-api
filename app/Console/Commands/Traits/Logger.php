<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 04.06.18
 * Time: 18:19
 */

namespace App\Console\Commands\Traits;

use Log;

/**
 * Trait Logger
 * @package App\Console\Commands\Traits
 */
trait Logger
{
    /**
     * @param $value
     */
    public function logInfo($value)
    {
        Log::info($this->getValueToLog($value));
    }

    /**
     * @param $value
     */
    public function logError($value)
    {
        Log::error($this->getValueToLog($value));
    }

    /**
     * @param $value
     * @return mixed|string
     */
    protected function getValueToLog($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (is_object($value)) {
            $value = print_r($value, true);
        }
        return $value;
    }
}