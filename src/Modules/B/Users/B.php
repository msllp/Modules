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
            'name'=>'MOD.User.Data',
            'route'=>'/dashboard/data',
            'method'=>'index',
            'type'=>'get',
        ],


/////User Routes
/// For Root User

        [
            'name'=>'MOD.User.Master.AddForm',
            'route'=>'/master/Users/action/add/from',
            'method'=>'addUserFrom',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.EditForm',
            'route'=>'/master/Users/action/edit/from/{id?}',
            'method'=>'editUserFrom',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.EditForm.Post',
            'route'=>'/master/Users/action/edit/from/{id?}',
            'method'=>'updateUser',
            'type'=>'post',
        ],


        [
            'name'=>'MOD.User.Master.Delete',
            'route'=>'/master/Users/action/delete/{id?}',
            'method'=>'deleteUser',
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

    /// For Users Roles

        [
            'name'=>'MOD.User.Master.Roles.AddForm',
            'route'=>'/master/Users/Sub/Roles/action/add/from',
            'method'=>'addUserRolesFrom',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.User.Master.Roles.Add.toDB',
            'route'=>'/master/Users/Sub/Roles/action/save',
            'method'=>'saveUserRoles',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.User.Master.Roles.EditForm',
            'route'=>'/master/Users/Sub/Roles/action/edit/from/{id?}',
            'method'=>'editUserRolesFrom',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.Roles.EditForm.Post',
            'route'=>'/master/Users/Sub/Roles/action/edit/from/{id?}',
            'method'=>'updateUserRoles',
            'type'=>'post',
        ],


        [
            'name'=>'MOD.User.Master.Roles.Delete',
            'route'=>'/master/Users/Sub/Roles/action/delete/{id?}',
            'method'=>'deleteUserRole',
            'type'=>'get',
        ],



        [
            'name'=>'MOD.User.Master.Roles.View.All',
            'route'=>'/master/Users/Sub/Roles/view/all',
            'method'=>'viewAllUserRoles',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.Roles.View.All.Proccess',
            'route'=>'/master/Users/Sub/Roles/view/all/proccess',
            'method'=>'viewAllUserPaginationRoles',
            'type'=>'get',
        ],
        [
            'name'=>'MOD.User.Master.Roles.Login.Owner',
            'route'=>'/master/Users/Sub/Roles/login/Owner',
            'method'=>'loginForRootUser',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.Roles.Login.Owner.Others',
            'route'=>'/master/Users/Sub/Roles/login/Owner/check/Fromothers',
            'method'=>'loginForRootUserFromOthers',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.Roles.Login.Owner.Callback',
            'route'=>'/master/Users/Sub/Roles/login/Owner/Callback',
            'method'=>'loginForRootUserFromOtherCallback',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Master.Roles.Login.Owner.Post',
            'route'=>'/master/Users/Sub/Roles/login/Owner/check',
            'method'=>'loginForRootUser',
            'type'=>'post',
        ],

        [
            'name'=>'MOD.User.Master.Roles.Login.Employee',
            'route'=>'/master/Users/Sub/Roles/login/Employee',
            'method'=>'viewAllUserPaginationRoles',
            'type'=>'get',
        ],

/// For Users for application

        [
            'name'=>'MOD.User.AddForm',
            'route'=>'/master/Users/Sub/action/add/from',
            'method'=>'addAppUserFrom',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Add.toDB',
            'route'=>'/master/Users/Sub/action/save',
            'method'=>'saveAppUser',
            'type'=>'post',
        ],


        [
            'name'=>'MOD.User.View.All',
            'route'=>'/master/Users/Sub/view/all',
            'method'=>'viewAllUserRoles',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.View.All.Proccess',
            'route'=>'/master/Users/Sub/view/all/proccess',
            'method'=>'viewAllUserPaginationRoles',
            'type'=>'get',
        ],

        [
            'name'=>'MOD.User.Test',
            'route'=>'/Test',
            'method'=>'cTest',
            'type'=>'get',
        ],
    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}
