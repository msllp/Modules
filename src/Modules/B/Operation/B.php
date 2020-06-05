<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Operation;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Operation\C";
    public static $model="MS\Mod\B\Operation\M";
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
            'name'=>'Operation.Machine.Cat.AddForm',
            'route'=>'/machine/cat/add',
            'method'=>'addMachineCatFrom',
            'type'=>'get',
        ],
        [
            'name'=>'Operation.Machine.Cat.AddForm.Post',
            'route'=>'/machine/cat/add',
            'method'=>'addMachineCatPost',
            'type'=>'post',
        ],
        [
            'name'=>'Operation.Machine.Cat.View',
            'route'=>'/machine/cat/view',
            'method'=>'viewCat',
            'type'=>'get',
        ],

        [
            'name'=>'Operation.Machine.Cat.View.Data',
            'route'=>'/machine/cat/view/data',
            'method'=>'viewCatData',
            'type'=>'get',
        ],

        [
            'name'=>'Operation.Machine.AddForm',
            'route'=>'/machine/add',
            'method'=>'addMachineForm',
            'type'=>'get',
        ],   [
            'name'=>'Operation.Vendor.AddForm',
            'route'=>'/vendor/add',
            'method'=>'addVendorForm',
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
