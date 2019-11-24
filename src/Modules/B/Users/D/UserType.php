<?php
return [


    [

      //  'UniqId'=>001,
        'UserTypeName'=>'Owner',
        'UserTypeIcon'=>'',
        'UserTypeDesc'=>'Owner or Manager',
     //   'UserTypeAllowedEvents'=>collect([])->toJson(),
      'UserTypeLoginLink'=>'MOD.User.Master.Roles.Login.Owner',
        'Status'=>true,
        ],

    [

      //  'UniqId'=>002,
        'UserTypeName'=>'Employee',
        'UserTypeIcon'=>'',
        'UserTypeDesc'=>'Employees of the Company / Organatation',
      //  'UserTypeAllowedEvents'=>collect([])->toJson(),
        'UserTypeLoginLink'=>'MOD.User.Master.Roles.Login.Employee',
        'Status'=>true,
        ],



];
