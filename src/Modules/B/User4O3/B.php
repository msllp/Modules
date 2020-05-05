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
                'route'=>'/get/{apiToken}/website',
                'method'=>'getUserForWebsite',
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
            'name'=>'O3.Users.SignUp.Verify.Resend',
            'route'=>'/verify/{token}/resend',
            'method'=>'resendOtp',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.SignUp.Verify.Resend',
            'route'=>'/verify/{token}/resend',
            'method'=>'resendOtp',
            'type'=>'post',
        ],
        [
            'name'=>'O3.Users.SignUp.Gen.Payment',
            'route'=>'/payment/{userId}',
            'method'=>'redirectToPaymentGateway',
            'type'=>'post',
        ],
            [
            'name'=>'O3.Users.SignUp.Verify.Resend',
            'route'=>'/payment/track/{orderId}',
            'method'=>'trackPaymentForUserSignUp',
            'type'=>'get',
            ],


        [
            'name'=>'O3.Users.Login.Form',
            'route'=>'/login',
            'method'=>'loginPage',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.Logout',
            'route'=>'/logout',
            'method'=>'logoutUser',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.Login.Google',
            'route'=>'/login/google',
            'method'=>'signInByGoogle',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.Login.Google.Callback',
            'route'=>'/login/google/callback',
            'method'=>'signInByGoogleCallBack',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.SignUp.Google',
            'route'=>'/signup/google/website',
            'method'=>'signUpByGoogleFromWebsite',
            'type'=>'get',
        ],
        [
            'name'=>'O3.Users.SignUp.Google.Callback',
            'route'=>'/signup/google/website/callback',
            'method'=>'signUpByGoogleFromWebsiteCallback',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.SignUp.Google.Callback.backend',
            'route'=>'/signup/google/backend/callback/{user}',
            'method'=>'signUpByGoogleFromBackendCallback',
            'type'=>'get',
        ],



        [
            'name'=>'O3.Users.Login.Form.Post',
            'route'=>'/login',
            'method'=>'loginInUserCheck',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.Plans.For.Website',
            'route'=>'/getAllPlansForWebsite',
            'method'=>'getAllPlansForWebsite',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Users.Video.call.send',
            'route'=>'/video/call/send/{from}/{to}',
            'method'=>'sendNotificatonToReceiver',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.Video.call.send.Data',
            'route'=>'/video/call/send/data/{UniqId}/{From}/{To}',
            'method'=>'getCallDataForReceiver',
            'type'=>'post',
        ],

        [
            'name'=>'O3.Users.Video.call.receive.Data',
            'route'=>'/video/call/receive/data/{UniqId}/{From}/{To}',
            'method'=>'getCallDataForCaller',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.Video.call.receive',
            'route'=>'/video/call/receive/{from}/{to}',
            'method'=>'sendNotificatonToCaller',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.Allowed.for.Call',
            'route'=>'/video/call/allowed/list/{apiToken}',
            'method'=>'getAllAllowedUserList',
            'type'=>'post',
        ],


        [
            'name'=>'O3.Users.vMeet.Add.New.Form',
            'route'=>'/vMeet/add/newMeet',
            'method'=>'showVmeetForm',
            'type'=>'get',
        ],  [
            'name'=>'O3.Users.vMeet.Add.New.Form',
            'route'=>'/vMeet/add/newMeet',
            'method'=>'showVmeetForm',
            'type'=>'get',
        ],


        [
            'name'=>'O3.Users.Notification',
            'route'=>'/notification/get/{apiToken}',
            'method'=>'getNotificationByApiToken',
            'type'=>'get',
        ],
        [
            'name'=>'O3.Users.Notification.get',
            'route'=>'/notification/get/show/{notifyId}',
            'method'=>'getNotificationByApiTokenForNotifyId',
            'type'=>'get',
        ],



        [
            'name'=>'O3.Test',
            'route'=>'/test',
            'method'=>'test',
            'type'=>'get',
        ],

        [
            'name'=>'O3.Test',
            'route'=>'/test',
            'method'=>'testPost',
            'type'=>'post',
        ],

        [
            'name'=>'O3.Sign.By.Token',
            'route'=>'/signin/by/{apiToken}',
            'method'=>'signInByToken',
            'type'=>'get',
        ],
        [
            'name'=>'O3.get.CSRF',
            'route'=>'/signin/get/csrf',
            'method'=>'getCsrf',
            'type'=>'get',
        ],





    ];

    public static $tables=[];
}
