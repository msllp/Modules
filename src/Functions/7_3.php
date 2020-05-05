<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 17-03-2019
 * Time: 01:14 PM
 */

if (!function_exists('array_key_first')) {
    /**
     * Gets the first key of an array
     *
     * @param array $array
     * @return mixed
     */
    function array_key_first(array $array)
    {
        return $array ? array_keys($array)[0] : null;
    }

}