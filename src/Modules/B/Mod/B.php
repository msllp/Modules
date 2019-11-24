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


/////Module Routes

        [
            'name'=>'MOD.Mod.Master.AddForm',
            'route'=>'/master/Modules/action/add/from',
            'method'=>'addModuleFrom',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.Add.toDB',
            'route'=>'/master/Modules/action/save',
            'method'=>'saveMethodForMod',
            'type'=>'post',
        ],

        [
            'name'=>'MOD.Mod.Master.View.All',
            'route'=>'/master/Modules/view/all',
            'method'=>'viewAllMod',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.View.All.Proccess',
            'route'=>'/master/Modules/view/all/proccess',
            'method'=>'viewAllModPagination',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.Mod.Master.Route.AddForm',
            'route'=>'/master/Modules/routes/action/add/from',
            'method'=>'addModuleRoutesFrom',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.Route.toDB',
            'route'=>'/master/Modules/routes/action/save',
            'method'=>'saveMethodForModRoutes',
            'type'=>'post',
        ],

        [
            'name'=>'MOD.Mod.Master.Route.View.All',
            'route'=>'/master/Modules/routes/view/all',
            'method'=>'viewAllModRoutes',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.Route.View.All.Proccess',
            'route'=>'/master/Modules/routes/view/all/proccess',
            'method'=>'viewAllModRoutesPagination',
            'type'=>'get',
        ],

        ///Event
        ///
        ///
        ///


        [
            'name'=>'MOD.Mod.Master.Event.AddForm',
            'route'=>'/master/Modules/event/action/add/from',
            'method'=>'addModuleEventFrom',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.Mod.Master.Event.toDB',
            'route'=>'/master/Modules/event/action/save',
            'method'=>'addModuleEventtoDB',
            'type'=>'post',
        ],

        [
            'name'=>'MOD.Mod.Master.Event.View.All',
            'route'=>'/master/Modules/event/view/all',
            'method'=>'viewAllModEvents',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.Mod.Master.Event.View.All.Proccess',
            'route'=>'/master/Modules/event/view/all/proccess',
            'method'=>'viewAsllModEventsPagination',
            'type'=>'get',
        ],

    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
