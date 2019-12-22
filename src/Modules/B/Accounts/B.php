<?php


namespace MS\Mod\B\Accounts;

use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Accounts\C";
    public static $model="MS\Mod\B\Accounts\M";
    public static $route=[
        [
            'name'=>'Account.Index',
            'route'=>'/dashboard',
            'type'=>'get',
            'method'=>'indexData',
        ],


    ];

    public static $allOnSameconnection=false;


    public static $tables=[];

}
