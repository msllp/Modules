<?php

namespace MS\Mod\B\Sales4O3;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Sales4O3\C";
    public static $model="MS\Mo\B\Sales4O3\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[


        [
            'name'=>'Sales.Test',
            'route'=>'/test',
            'method'=>'test',
            'type'=>'get',
        ],

        [
            'preFix'=>'sales',
            'dynamicLoadNameSpace'=>'L\\Sales',
            'dynamicLoadRouteMethod'=>'loadRoutes'
        ],

        [
            'preFix'=>'invoice',
            'dynamicLoadNameSpace'=>'L\\Invoice',
            'dynamicLoadRouteMethod'=>'loadRoutes'
        ],
        [
        'NamePreFix'=>'O3.Sales.Product',
        'preFix'=>'Product',
        'dynamicLoadNameSpace'=>'L\\Product',
        'dynamicLoadRouteMethod'=>'loadRoutes'
        ],
        [
        'NamePreFix'=>'O3.Sales.Customer',
        'preFix'=>'Customer',
        'dynamicLoadNameSpace'=>'L\\Client',
        'dynamicLoadRouteMethod'=>'loadRoutes'
        ],

    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
