<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Users;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Users\C";
    public static $model="MS\Mod\B\Users\M";
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
            'name'=>'MOD.User.Master.AddForm',
            'route'=>'/master/Users/action/add/from',
            'method'=>'addUserFrom',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.User.Master.Add.toDB',
            'route'=>'/master/Users/action/save',
            'method'=>'saveUser',
            'type'=>'post',
        ],

        [
            'name'=>'MOD.User.Master.View.All',
            'route'=>'/master/Users/view/all',
            'method'=>'viewAllUser',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.View.All.Proccess',
            'route'=>'/master/Users/view/all/proccess',
            'method'=>'viewAllUserPagination',
            'type'=>'get',
        ],


    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
