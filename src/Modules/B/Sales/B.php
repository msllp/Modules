<?php


namespace MS\Mod\B\Sales;


use B\BM\M;
use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Sales\C";
    public static $model="MS\Mod\B\Sales\M";
    //  public static $dir="MS.B.MAS";

    public static $route=[




        [
            'name'=>'MOD.Sales.Dashboard',
            'route'=>'/dashboard',
            'method'=>'dashboard',
            'type'=>'get',
        ],

        ];

public static $tables=[];

}
