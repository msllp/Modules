<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Panel4EN;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Panel4EN\C";
    public static $model="MS\Mod\B\Panel4EN\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[

        [
            'name'=>'Env.Panel',
            'route'=>'/panel',
            'method'=>'MaintainaceDashboard',
            'type'=>'get' ,
        ],

        [
            'name'=>'Env.Panel.data',
            'route'=>'/panel/data',
            'method'=>'SideNavForMaintainaceDashboard',
            'type'=>'get' ,
        ],

        [
            'name'=>'Env.Panel.Add.item.Request',
            'route'=>'/panel/item/req/add',
            'method'=>'addItemRequest',
            'type'=>'get' ,
        ],


        [
            'name'=>'Env.Panel.Add.item.Request.get.Product',
            'route'=>'/panel/item/req/add/get/product',
            'method'=>'getProduct',
            'type'=>'get' ,
        ],
    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
