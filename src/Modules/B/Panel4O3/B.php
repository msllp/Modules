<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Panel4O3;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Panel4O3\C";
    public static $model="MS\Mod\B\Panel4O3\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[


        [
            'name'=>'O3.Panel',
            'route'=>'/home',
            'method'=>'MaintainaceDashboard',
            'type'=>'get' ,
        ],


        [
            'name'=>'O3.Panel.From.Login',
            'route'=>'/home/{apiToken}',
            'method'=>'MaintainaceDashboardWithApiToken',
            'type'=>'get' ,
        ],



        [
            'name'=>'O3.Panel.data',
            'route'=>'/home/data/sidebar',
            'method'=>'SideNavForMaintainaceDashboard',
            'type'=>'get' ,
        ],




    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
