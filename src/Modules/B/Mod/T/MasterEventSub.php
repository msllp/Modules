<?php


return [

    "Master_Events_sub"=>[

        'tableName'=>'MS_Master_Events_Sub',
        'connection'=>'MS_Master',
        'fields'=>
            [

                [
                    'name'=>'RouteCode',
                    'vName'=>'Route ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                    'name'=>'Routes',
                    'vName'=>'Routes',
                    'dbOff'=>true

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

    ]


];
