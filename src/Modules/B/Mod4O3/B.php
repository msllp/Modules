<?php

namespace MS\Mod\B\Mod4O3;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Mod4O3\C";
    public static $model="MS\Mod\B\Mod4O3\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[


        [
            'name'=>'Mod4O3.Genrate.ApiToken.ForUser',
            'route'=>'/forUser',
            'method'=>'genrateApiToken',
            'type'=>'get',
        ]

    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
