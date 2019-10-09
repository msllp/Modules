<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-10-2019
 * Time: 09:15 PM
 */

return [

    "MS_Route_Type"=>[

        'tableName'=>'MS_Route_Type',
        'connection'=>'MS_UI',
        'fields'=>
            [



                [
                    'name'=>'RouteTypeName',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'RouteTypeCode',
                    'type'=>'string',
                   'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Status',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],



            ],
        'fieldGroup'=>[],
        'fieldGroupMultiple'=>[],

        'action'=>[],

        'validationMessage'=>[],


        'MSforms'=>[],


        'MSViews'=>[],


    ]
];
