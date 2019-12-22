<?php


return [

    "Master_Events"=>[

        'tableName'=>'MS_Master_Events',
        'connection'=>'MS_Master',
        'groupDynamic'=>true,
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
                    'name'=>'EventName',
                    'vName'=>'Event Name',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'EventDesc',
                    'vName'=>'Event Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'ModuleCode',
                    'vName'=>'Module',
                    'type'=>'string',
                    'input'=>'option',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_MOD_MASTER]
                ],



                [
                    'name'=>'EventAccess',
                    'vName'=>'Routes',
                    'type'=>'string',
                    'input'=>'text',

                ],

                [
                    'name'=>'Routes',
                    'vName'=>'Routes',
                    'input'=>'text',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_ROUTES_MASTER],
                    'dbOff'=>true
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
            'View All Events'=>['EventName','EventDesc','ModuleCode','Status',],
            'Event Details'=>['EventName','EventDesc','ModuleCode','Status',],
            'Routes'=>['Routes',]
//  'Add Module 2'=>['test5','test6','test7','test8','test9','test10','test11','created_at'],
// 'Add Module2'=>['modName','modDesc','modCode','modIcon','modPrefix','modForSuperAdmin','modForAdmin','modStatus','modHomeAction','modDataAction'],
// 'Login Details'=>['modName','modDesc','modCode','modIcon',],
//   'Login Details 2'=>['Username','Password','ConfirmPassword','Role']

        ],
        'fieldGroupMultiple'=>['Routes'],

        'action'=>[
            'add'=>[
                "btnColor"=>"bg-green",
                "route"=>"MOD.Mod.Master.Event.toDB",
                "btnIcon"=>"fi flaticon-add",
                'btnText'=>"add event"
            ],
            'delete'=>[
                "btnColor"=>"bg-red-300",
                "route"=>"MOD.Mod.Master.Event.Delete",
                "routePara"=>['id'=>'UniqId'],
                "btnIcon"=>"fi flaticon-bin",
                'btnText'=>"Delete Mod Event",
                'msLinkKey'=>'UniqId',
                'msLinkText'=>'EventName',
                'doubleConfirm'=>'true',
                'doubleConfirmText'=>'Are you sure you want to remove Module Event',
                'ownTab'=>'true',
                // 'msNextAction'=>'MOD.User.Master.View.All'

            ],

        ],

        'validationMessage'=>[
        ],


        'MSforms'=>[

            'add_event'=>[
                'title'=>'Add Events',
                'groups'=>['Event Details','Routes'],
                'actions'=>['add']

            ]
        ],


        'MSViews'=>[

            'view_all'=>[
                'title'=>'View all Master Events',
                'icon'=>'fas fa-users',
                'groups'=>['View All Events'],
                'searchable'=>true,
                'actions'=>['add'],
                'massAction'=>['add'],
                'searchAllowed'=>[],
                'pagination'=>true,
                'paginationLink'=>'MOD.Mod.Master.Event.View.All.Proccess'


            ]





        ],

]


];
