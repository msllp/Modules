<?php

namespace MS\Mod\{NameSpace};



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="{NameSpace}\C";
    public static $model="{NameSpace}\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[


//        [
//            'name'=>'Route Name',
//            'route'=>'/url',
//            'method'=>'methodName',
//            'type'=>'get' || 'post,
//        ],

    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
