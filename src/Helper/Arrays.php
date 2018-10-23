<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.10.18
 * Time: 10:02
 */

namespace App\Helper;


class Arrays
{
    public function getKey($arr, $key, $def=null)
    {
        return isset($arr[$key]) ? $arr[$key] : $def;
    }
}