<?php
return [
    [
    'UniqId'=>'001',
    'ModuleName'=>'Users',
    'ModuleDesc'=>'User Module to manage users',
    'ModuleIcon'=>'msicon-admin-user',
    'ModuleRoute'=>'Core/Mod/Users/master',
    'ModuleAccess'=>collect([])->toJson(),
        'Status'=>1
]   ,
    [
    'UniqId'=>'002',
    'ModuleName'=>'Accounts',
    'ModuleDesc'=>'Account Module to manage financial Ledgers & Accounts',
    'ModuleIcon'=>'msicon-admin-user',
    'ModuleRoute'=>'Core/Mod/Accounts/master',
    'ModuleAccess'=>collect([])->toJson(),
        'Status'=>1
]
];
