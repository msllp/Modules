<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 04-08-2019
 * Time: 05:33 AM
 */
namespace MS\Core\Test;
class Master
{

    static public function Test ($r){

        return view("MS::core.layouts.panel");

        dd($r);
    }

}
