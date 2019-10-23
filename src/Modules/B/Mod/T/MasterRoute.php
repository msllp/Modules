<?php


return [

"Master_Route"=>[

'tableName'=>'MS_Master_Route',
'connection'=>'MS_Master',
'fields'=>
[

    [
    'name'=>'UniqId',
    'vName'=>'ID',
    'type'=>'string',
    'input'=>'auto',
    'callback'=>'genUniqId',
    "validation"=>['required'=>true,]
    ],

    [
    'name'=>'RouteName',
    'vName'=>'Route Name',
    'type'=>'string',
    'input'=>'text',
    "validation"=>['required'=>true,]
    ],

    [
        'name'=>'RouteType',
        'vName'=>'Route Type',
        'type'=>'string',
        'input'=>'option',
        "validation"=>['required'=>true,'existIn'=>MSCORE_ROUTE_TYPE_MASTER]
    ],

    [
    'name'=>'ModuleCode',
    'vName'=>'Module',
    'type'=>'string',
    'input'=>'option',
    "validation"=>['required'=>true,'existIn'=>MSCORE_MOD_MASTER]
    ],

    [
    'name'=>'RouteMethod',
    'vName'=>'Method Name',
    'type'=>'string',
    'input'=>'text',
    "validation"=>['required'=>true,]],


    [
        'name'=>'RouteUrl',
        'vName'=>'Route URL',
        'type'=>'string',
        'input'=>'text',
        "validation"=>['required'=>true,]
    ],


    [
        'name'=>'EventCode',
        'vName'=>'Events Code',
        'type'=>'string',
        'input'=>'text',
        "validation"=>['required'=>false,]
    ],



        [
            'name'=>'Status',
            'vName'=>'Status',
            'type'=>'boolean',
            'input'=>'radio',
            "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
        ],



],
'fieldGroup'=>[
'View Module Routes'=>['UniqId','RouteType','RouteName','ModuleCode','RouteUrl','Status',],
'Public_User'=>['UniqId','MSUsername'],

    'Add Master Routes'=>['UniqId','ModuleCode','RouteUrl','RouteType','RouteName','RouteMethod','Status']
//  'Add Module 2'=>['test5','test6','test7','test8','test9','test10','test11','created_at'],
// 'Add Module2'=>['modName','modDesc','modCode','modIcon','modPrefix','modForSuperAdmin','modForAdmin','modStatus','modHomeAction','modDataAction'],
// 'Login Details'=>['modName','modDesc','modCode','modIcon',],
//   'Login Details 2'=>['Username','Password','ConfirmPassword','Role']

],
'fieldGroupMultiple'=>[

],

'action'=>[
    'add'=>[
            "btnColor"=>"bg-green",
            "route"=>"MOD.Mod.Master.Route.toDB",
            "btnIcon"=>"fi flaticon-add",
            'btnText'=>"add routes"
            ],

//            'edit'=>[
//                "btnColor"=>"btn-info",
//                "route"=>"MAS.Index",
//                "btnIcon"=>"fa fa-home",
//                'btnText'=>"edit Module"
//            ],
// 'edit'=>"",

],

'validationMessage'=>[

// 'MSUsername.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",
// 'MSPassword.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",



],


'MSforms'=>[

    'add_routes'=>[
        'title'=>'Add Routes',
        'groups'=>['Add Master Routes'],
        'actions'=>['add']

    ]
],


'MSViews'=>[

'view_all'=>[
'title'=>'View all Master Routes',
'icon'=>'fas fa-users',
'groups'=>['View Module Routes'],
'searchable'=>true,
'actions'=>['add'],
'massAction'=>['add'],
'searchAllowed'=>[],
'pagination'=>true,
'paginationLink'=>'MOD.Mod.Master.Route.View.All.Proccess'


]





],


]
];
