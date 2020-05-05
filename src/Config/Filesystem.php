<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 28-06-2019
 * Time: 03:31 AM
 */


return

    [
        'MS-ROOT'=>[
            'driver' => 'local',
            'root' => base_path('/'),
        ],

        'MS-CORE'=>[
            'driver' => 'local',
            'root' => base_path('MS'),
        ],
        'MS-MASTER-Storage'=>[
            'driver' => 'local',
            'root' => base_path('MS'.DS.'AppData'),
        ]

    ]

;
