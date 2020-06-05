<?php

/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-10-2019
 * Time: 09:15 PM
 */

return [

    "Master_User_VerifyBy" => [

        'tableName' => 'MAS_User_VerifyBy',
        'connection' => 'MS_Master',
        'fields' =>
            [

                [
                    'name' => 'UniqId',
                    'vName' => 'ID',
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],

                [
                    'name' => 'VerifyName',
                    'vName' => \Lang::get('Mod.Users.VerifyByName'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],


                [
                    'name' => 'VerifyDescription',
                    'vName' => \Lang::get('Mod.Users.VerifyDescription'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],

                [
                    'name' => 'VerifyIcon',
                    'vName' => \Lang::get('Mod.Users.VerifyIcon'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],
                [
                    'name' => 'VerifyUrl',
                    'vName' => \Lang::get('Mod.Users.VerifyUrl'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],


                [
                    'name' => 'VerifyCallback',
                    'vName' => \Lang::get('Mod.Users.VerifyCallback'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],


                [
                    'name' => 'VerifyData',
                    'vName' => \Lang::get('Mod.Users.VerifyData'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],
                [
                    'name' => 'VerifyDataDefault',
                    'vName' => \Lang::get('Mod.Users.VerifyDataDefault'),
                    'type' => 'string',
                    'input' => 'text',
                    "validation" => ['required' => true,]
                ],

                [
                    'name'=>'Status',
                    'vName'=>'Status',
                    'type'=>'boolean',
                    'input'=>'radio',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
                ],


            ],
        'fieldGroup' => [

        ],
        'fieldGroupMultiple' => [

        ],

        'action' => [


        ],

        'validationMessage' => [


        ],


        'MSforms' => [
        ],


        'MSViews' => [

            'view_all' => [
                'title' => 'View all Root Users',
                'icon' => 'fas fa-users',
                'groups' => ['Public_User'],
                'searchable' => true,
                'actions' => ['edit', 'delete'],
                'massAction' => [],
                'searchAllowed' => [],
                'pagination' => true,
                'paginationLink' => 'MOD.User.Master.View.All.Proccess'


            ]


        ],

        'MSLogin' => [


        ],


    ]
];
