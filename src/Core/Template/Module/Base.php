<?php
/**
 * Created by MS
 * Base File For Module {{modCode}}
 */

namespace {{end}}\{{modCode}};



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="{{end}}\{{modCode}}\C";
    public static $model="{{end}}\{{modCode}}\M";
    //  public static $dir="MS.B.MAS";

    public static $route=[

        [
            'name'=>'{{end}}.{{modCode}}.Index',
            'route'=>'/',
            'method'=>'index',
            'type'=>'get',
        ],

        [
            'name'=>'{{end}}.{{modCode}}.data',
            'route'=>'/data',
            'method'=>'indexData',
            'type'=>'get',
        ]];

   public static $allOnSameconnection=true;






}
