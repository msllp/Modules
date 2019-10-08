<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Mod;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Mod\C";
    public static $model="MS\Mod\B\Mod\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[

        [
            'name'=>'MOD.User.Index',
            'route'=>'/dashboard',
            'method'=>'index',
            'type'=>'get',
        ],


        [
            'name'=>'MOD.User.Data',
            'route'=>'/dashboard/data',
            'method'=>'index',
            'type'=>'get',
        ],


/////User Routes

        [
            'name'=>'MOD.Mod.Master.AddForm',
            'route'=>'/master/Modules/action/add/from',
            'method'=>'addModuleFrom',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.Add.toDB',
            'route'=>'/master/Modules/action/save',
            'method'=>'saveUser',
            'type'=>'post',
        ],



    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}