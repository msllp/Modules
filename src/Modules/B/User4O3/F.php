<?php


namespace MS\Mod\B\User4O3;


class F
{

    public static function checkUserLogin($apiToken=null){


        return  \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'checkUserLoginSession','data'=> $apiToken ]]);

    }

    public static function redirectToLoginPage(){
        return redirect()->route('O3.Users.Login.Form');
    }

    public static function refirecToPanel (){
        $data=[
            'path'=> [
                'sidebar'=> route('O3.Panel.data')
            ],
            'accessToken'=> \MS\Core\Helper\Comman::encode($apiToken),
            'msUser'=>  \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLiveUser','data'=> [] ]])

        ];

        return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
    }

    public static function getUser(){
        $user=new L\Users();
        return $user->getLiveUser();
    }

}
