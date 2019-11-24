<?php

return [

    "User_User_Type"=>[

        'tableName'=>'User_Master_User_Type',
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
                    'name'=>'UserTypeName',
                    'vName'=>'Name of Role',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                    'name'=>'UserTypeIcon',
                    'vName'=>'Role Icon',
                    'type'=>'string',
                    'input'=>'option',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_ICON_1]
                ],

                [
                    'name'=>'UserTypeDesc',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                'name'=>'UserTypeAllowedEvents',
                'vName'=>'Allowed Application Events',
                'type'=>'string',
                'input'=>'option',
                "validation"=>['required'=>true,'existIn'=>MSCORE_MOD_EVENT_MASTER],
                'dbOff'=>true
            ],
                [
                    'name'=>'UserTypeLoginLink',
                    'vName'=>'MS Link',
                    'type'=>'string',
                    'input'=>'option',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_ROUTES_MASTER]
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
            'User Role Details'=>['UserTypeName','UserTypeIcon','UserTypeDesc','UserTypeLoginLink','Status'],
            'User Role Allowed Apllication Events'=>['UserTypeAllowedEvents'],

        ],
        'fieldGroupMultiple'=>[
            'User Role Allowed Apllication Events'
        ],

        'action'=>[
            'add'=>[
                "btnColor"=>"bg-green",
                "route"=>"MOD.User.Master.Roles.Add.toDB",
                "btnIcon"=>"far fa-save",
                'btnText'=>"add user role"
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

        ],


        'MSforms'=>[
            'add_user_type'=>[
                'title'=>'Add User Role',
                'groups'=>['User Role Details','User Role Allowed Apllication Events'],
                'actions'=>['add']

            ],
        ],


        'MSViews'=>[

            'view_all'=>[
                'title'=>'View all Users Roles',
                'icon'=>'fas fa-users',
                'groups'=>['User Role Details'],
                'searchable'=>true,
                'actions'=>['add'],
                'massAction'=>['add'],
                'searchAllowed'=>[],
                'pagination'=>true,
                'paginationLink'=>'MOD.User.Master.Roles.View.All.Proccess'


            ]





        ],


    ],


    "User_User_Type_sub"=>[

        'tableName'=>'MS_Master_Role',
        'connection'=>'MS_Master',
        'fields'=>
            [

                [
                    'name'=>'EventCode',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],





            ],
        'fieldGroup'=>[
            'Routes'=>['RouteCode',]
        ],
        'fieldGroupMultiple'=>[
            'Routes'
        ],

        'action'=>[
            'add'=>[
                "btnColor"=>"bg-green",
                "route"=>"MOD.Mod.Master.Event.toDB",
                "btnIcon"=>"fi flaticon-add",
                'btnText'=>"add event"
            ],


        ],

        'validationMessage'=>[
        ],


        'MSforms'=>[

            'add_event'=>[
                'title'=>'Add Events',
                'groups'=>['Routes'],
                'actions'=>['add']

            ]
        ],


        'MSViews'=>[

            'view_all'=>[
                'title'=>'View all Master Events',
                'icon'=>'fas fa-users',
                'groups'=>['Routes'],
                'searchable'=>true,
                'actions'=>['add'],
                'massAction'=>['add'],
                'searchAllowed'=>[],
                'pagination'=>true,
                'paginationLink'=>'MOD.Mod.Master.Route.View.All.Proccess'


            ]





        ],

    ],



    "User_App_User"=>[

    'tableName'=>'User_App_Master',
    'connection'=>'MS_USER',
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
                'name'=>'UserName',
                'vName'=>'Username / Email / Mobile No.',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
            'name'=>'PassWord',
            'vName'=>'Password',
            'type'=>'string',
            'input'=>'password',
            "validation"=>['required'=>true,]
        ],

            [
                'name'=>'ConfirmPassWord',
                'vName'=>'Confirm Password',
                'type'=>'string',
                'input'=>'password',
                "validation"=>['required'=>true,],
                  'dbOff'=>true
            ],
            [
                'name'=>'UserTypeCode',
                'vName'=>'User Role',
                'type'=>'text',
                'input'=>'option',
                "validation"=>['required'=>true,'existIn'=>MSCORE_USER_TYPE_MASTER]
            ],
            [
            'name'=>'HookTypeCode',
            'vName'=>'other partner',
            'type'=>'string',
            'input'=>'text',
            "validation"=>['required'=>true,]
        ],

            [
                'name'=>'HookUniqId',
                'vName'=>'other partner',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'HookData',
                'vName'=>'other partner',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserIcon',
                'vName'=>'other partner',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'UserAddress1',
                'vName'=>'Home/Flat/Plot/Block etc No.',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'UserAddress2',
                'vName'=>'Street & Area',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserAddress3',
                'vName'=>'Landmark',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserCity',
                'vName'=>'City / Town',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserState',
                'vName'=>'City / Town',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserPincode',
                'vName'=>'Pincode',
                'type'=>'string',
                'input'=>'number',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'UserCountry',
                'vName'=>'Country',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserMobileNumber',
                'vName'=>'Mobile Number',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserEmail',
                'vName'=>'Email',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserCompany',
                'vName'=>'Company Name',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'UserCompanyPost',
                'vName'=>'Post',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],



            [
                'name'=>'UserKnownDevice',
                'vName'=>'Recent Login Details',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserLastTabs',
                'vName'=>'Recent Opration Details',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],


            [
                'name'=>'UserActionCodes',
                'vName'=>'Recently taken Actions',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserNotifyReadCodes',
                'vName'=>'Address line 1',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'UserSettings',
                'vName'=>'Setting Array',
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
        'Master Details'=>['UserName','Status','PassWord','ConfirmPassWord',],
        'Professional Details'=>['UserCompany','UserCompanyPost','UserTypeCode'],
        'Location Details'=>['UserAddress1','UserAddress2','UserAddress3','UserCity','UserState','UserPincode','UserCountry'],
        'Communication Details'=>['UserMobileNumber','UserEmail'],
    ],
    'fieldGroupMultiple'=>[

    ],

    'action'=>[
        'add'=>[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>"add app user"
        ],


        // 'edit'=>"",

    ],

    'validationMessage'=>[

    ],


    'MSforms'=>[
        'add_app_user'=>[
            'title'=>'Add App User',
            'groups'=>['Master Details','Professional Details','Location Details','Communication Details'],
            'actions'=>['add']

        ],
    ],


    'MSViews'=>[

        'view_all'=>[
            'title'=>'View all App Users',
            'icon'=>'fas fa-users',
            'groups'=>['Master Details','Communication Details'],
            'searchable'=>true,
            'actions'=>['add'],
            'massAction'=>['add'],
            'searchAllowed'=>[],
            'pagination'=>true,
            'paginationLink'=>'MOD.User.View.All.Proccess'


        ]





    ],


]
];
