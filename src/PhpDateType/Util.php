<?php
/**
 * Created by PhpStorm.
 * User: xushengbin
 * Date: 2018/12/7
 * Time: 15:28
 */

namespace PhpDataType;

class Util
{
    /**
     * @param $date
     */
    public static function isWeekEnd($date)
    {
        return (date('N', strtotime($date)) >= 6);
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isWorkDay($date)
    {
        return (date('N', strtotime($date)) <= 5);
    }
}
