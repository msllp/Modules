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
'input'=>'text',
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
        'input'=>'text',
        "validation"=>['required'=>true,]
    ],

[
'name'=>'ModuleIcon',
'vName'=>'Module Icon',
'type'=>'string',
'input'=>'option',
"validation"=>['required'=>true,'existIn'=>MSCORE_UI_ICON_1]
],

[
'name'=>'ModuleDesc',
'vName'=>'Module Description',
'type'=>'string',
'input'=>'text',
"validation"=>['required'=>true,]
],

[
'name'=>'ModuleRoute',
'vName'=>'Module Route Prefix',
'type'=>'string',
'input'=>'text',
"validation"=>['required'=>true,]
],


[
'name'=>'ModuleAccess',
'vName'=>'Module Permission',
'type'=>'string',
'input'=>'text',
"validation"=>['required'=>true,]
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
'Add Module'=>['UniqId','ModuleName','ModuleIcon','ModuleDesc','ModuleRoute','Status'],
'Public_User'=>['UniqId','MSUsername'],
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
"route"=>"MOD.Mod.Master.Add.toDB",
"btnIcon"=>"msicon-add",
'btnText'=>"add module"
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
'add_user'=>[
'title'=>'Add Master Module',
'groups'=>['Add Module'],
'actions'=>['add']

],
],


'MSViews'=>[

'view_all'=>[
'title'=>'View all Master Mod',
'icon'=>'fas fa-users',
'groups'=>['Public_User'],
'searchable'=>true,
'actions'=>['add'],
'massAction'=>['add'],
'searchAllowed'=>[],
'pagination'=>true,
'paginationLink'=>'MOD.User.Master.View.All.Proccess'


]





],


]
];
