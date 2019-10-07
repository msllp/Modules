<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-10-2019
 * Time: 09:15 PM
 */

return [

    "Master_User"=>[

        'tableName'=>'MAS_Master_Root',
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
                    'name'=>'MSUsername',
                    'vName'=>'Username',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'MSPassword',
                    'vName'=>'Password',
                    'type'=>'string',
                    'input'=>'password',
                    "validation"=>['required'=>true,]
                ],




            ],
        'fieldGroup'=>[
            'Add_User'=>['UniqId','MSUsername','MSPassword'],
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
                "route"=>"MOD.User.Master.Add.toDB",
                "btnIcon"=>"far fa-save",
                'btnText'=>"add root user"
            ],

            'edit'=>[
                "btnColor"=>"btn-info",
                "route"=>"MAS.Index",
                "btnIcon"=>"fa fa-home",
                'btnText'=>"edit Module"
            ],
            // 'edit'=>"",

        ],

        'validationMessage'=>[

            'MSUsername.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",
            'MSPassword.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",



        ],


        'MSforms'=>[
            'add_user'=>[
                'title'=>'Add Master User',
                'groups'=>['Add_User'],
                'actions'=>['add']

            ],
        ],


        'MSViews'=>[

            'view_all'=>[
                'title'=>'View all Root Users',
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
