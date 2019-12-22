<?php


namespace MS\Mod\B\Company;

use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Company\C";
    public static $model="MS\Mod\B\Company\M";
    public static $route=[
        [
            'name'=>'Company.AddForm',
            'route'=>'/company/add',
            'type'=>'get',
            'method'=>'addForm',
        ],
        [
            'name'=>'Company.AddFormPost',
            'route'=>'/company/addd',
            'type'=>'post',
            'method'=>'addFormPost',
        ],
        [
            'name'=>'Company.viewForm',
            'route'=>'/company/view',
            'type'=>'get',
            'method'=>'viewForm',
        ],
        [
            'name'=>'Company.viewFormAjax',
            'route'=>'/company/view/Data',
            'type'=>'get',
            'method'=>'viewFormAjax',
        ],
        [
            'name'=>'Company.Delete',
            'route'=>'/company/delete/{id}',
            'type'=>'get',
            'method'=>'viewFormAjax',
        ],




    ];

    public static $allOnSameconnection=false;


    public static $tables=[];

}
