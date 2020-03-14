<?php


namespace MS\Mod\B\User4O3;

use MS\Core\Module\Master;

class B extends Master
{


    public static $controller="MS\Mod\B\User4O3\C";
    public static $model="MS\Mod\B\User4O3\M";
    //  public static $dir="MS.B.MAS";

    public static $route=[


            [
                'name'=>'O3.Users',
                'route'=>'/profile',
                'method'=>'viewProfileOfCurrentUser',
                'type'=>'get',
            ],

        [
                'name'=>'O3.Users.Android.Profile',
                'route'=>'/android/profile/{apiToken}',
                'method'=>'AndroidApi_getUser',
                'type'=>'get',
            ],




        [
            'name'=>'O3.Users.SignUp',
            'route'=>'/signup',
            'method'=>'signUpUser',
            'type'=>'post',
        ],
        [
            'name'=>'O3.Users.SignUp.Verify',
            'route'=>'/verify/{token}',
            'method'=>'signUpUserVerify',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.Plans.For.Website',
            'route'=>'/getAllPlansForWebsite',
            'method'=>'getAllPlansForWebsite',
            'type'=>'get',
        ],
        [
            'name'=>'O3.Test',
            'route'=>'/test',
            'method'=>'test',
            'type'=>'get',
        ],




    ];

    public static $tables=[];
}
