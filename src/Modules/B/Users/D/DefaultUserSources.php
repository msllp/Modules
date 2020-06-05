<?php

return[

    [
    'UniqId'=>'001',
    'VerifyName'=>'MS ID',
    'VerifyDescription'=>'For MS Login Only',
    'VerifyIcon'=>'msicon-Master-Company-Icon',
    'VerifyUrl'=>'MOD.User.Master.Roles.Login.Owner.Post',
    'VerifyCallback'=>'MOD.User.Master.Roles.Login.Owner.Callback',
    'VerifyData'=>collect([[ 'msAPIToken'=>'MSADMIN' ]])->toJson(),
    'VerifyDataDefault'=>'0',
    'Status'=>true,
    ],

];
