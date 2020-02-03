<?php


namespace MS\Mod\B\User4O3;

use MS\Core\Module\Master;

class B extends Master
{


    public static $controller="MS\Mod\B\User4O3\C";
    public static $model="MS\Mod\B\User4O3\M";
    //  public static $dir="MS.B.MAS";

    public static $route=[


            [
                'name'=>'O3.Users',
                'route'=>'/profile',
                'method'=>'viewProfileOfCurrentUser',
                'type'=>'get',
            ],


    ];
}
