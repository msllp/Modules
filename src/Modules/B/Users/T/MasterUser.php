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
            'Root User Details'=>['UniqId','MSUsername','MSPassword'],
            'Public_User'=>['UniqId','MSUsername'],
            'Edit User Details'=>['MSUsername','MSPassword']
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
                "btnColor"=>"bg-blue-100",
                "route"=>"MOD.User.Master.EditForm.Post",
                "routePara"=>['id'=>'UniqId'],
                "btnIcon"=>"fi flaticon-edit",
                'btnText'=>"Edit Root User",
                'msLinkKey'=>'UniqId',
                'msLinkText'=>'MSUsername',
               // 'msNextAction'=>'MOD.User.Master.View.All'

            ],

            'delete'=>[
                "btnColor"=>"bg-red-100",
                "route"=>"MOD.User.Master.Delete",
                "routePara"=>['id'=>'UniqId'],
                "btnIcon"=>"fi flaticon-bin",
                'btnText'=>"Delete Root User",
                'msLinkKey'=>'UniqId',
                'msLinkText'=>'MSUsername',
                'doubleConfirm'=>'true',
                'doubleConfirmText'=>'Are You Sure to remove Root User',
                'ownTab'=>'true',
                // 'msNextAction'=>'MOD.User.Master.View.All'

            ],

            'editPost'=>[
                "btnColor"=>"btn-info",
                "route"=>"MOD.User.Master.EditForm.Post",
                "btnIcon"=>"fi flaticon-edit",
                'btnText'=>"edit Module",
                'msLinkKey'=>'UniqId',
                'msLinkText'=>'MSUsername',
                // 'msNextAction'=>'MOD.User.Master.View.All'

            ],
            // 'edit'=>"",

        ],

        'validationMessage'=>[

            'MSUsername.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",
            'MSPassword.required'=>":attribute is Required to go on .Please Contact on help@millionsllp.com",



        ],


        'MSforms'=>[
            'add_user'=>[
                'title'=>'Add Root User',
                'groups'=>['Root User Details'],
                'actions'=>['add']

            ],

            'edit_user'=>[
                'title'=>'Edit Root User',
                'groups'=>['Edit User Details'],
                'actions'=>['edit']

            ],
        ],


        'MSViews'=>[

            'view_all'=>[
                'title'=>'View all Root Users',
                'icon'=>'fas fa-users',
                'groups'=>['Public_User'],
                'searchable'=>true,
                'actions'=>['edit','delete'],
                'massAction'=>[],
                'searchAllowed'=>[],
                'pagination'=>true,
                'paginationLink'=>'MOD.User.Master.View.All.Proccess'


            ]





        ],


        ]
    ];
