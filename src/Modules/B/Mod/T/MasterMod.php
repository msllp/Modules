<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-10-2019
 * Time: 09:15 PM
 */

return [

    "Master_Mod"=>[

        'tableName'=>'MS_Master_Mod',
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
                    'name'=>'ModuleName',
                    'vName'=>'Module Name',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'ModuleDesc',
                    'vName'=>'Module Description',
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
            'Add Module'=>['UniqId','ModuleName','ModuleIcon','ModuleDesc','ModuleRoute','Status'],
            'View All Module'=>['ModuleName','ModuleDesc','ModuleRoute','Status'],
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

            'addBtn'=>[
                "btnColor"=>"bg-green-500",
                "btnIcon"=>"msicon-add",
                'btnText'=>"add module",
                'route'=>'MOD.Mod.Master.AddForm'
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
                'groups'=>['View All Module'],
                'searchable'=>true,
                'actions'=>['addBtn'],
                'massAction'=>['add'],
                'searchAllowed'=>[],
                'rowView'=>'',
                'rowId'=>'UniqId',
                'pagination'=>true,
                'paginationLink'=>'MOD.Mod.Master.View.All.Proccess'


            ]





        ],


        ]
    ];
