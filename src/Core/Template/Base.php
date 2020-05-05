<?php
/**
 * Created by MS
 * Base File For Module {{modCode}}
 */

namespace {{end}}\{{modCode}};



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="B\MAS\C";
    public static $model="B\MAS\M";
    //  public static $dir="MS.B.MAS";

    public static $route=[

        [
            'name'=>'MAS.Index',
            'route'=>'/',
            'method'=>'index',
            'type'=>'get',
        ],

        [
            'name'=>'MAS.Index.data',
            'route'=>'/data',
            'method'=>'indexData',
            'type'=>'get',
        ]];

   public static $allOnSameconnection=false;






}
