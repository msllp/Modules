<?php


namespace MS\Mod\B\User4O3;


class F
{

    public static function getRootIdFromSubUserId($UserId){

        $exUserId=explode('_',$UserId);
        if(count($exUserId)>1)$UserId=reset($exUserId);
        return$UserId;


    }
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

    public static function checkUserLimits($type){
        $c=new L\Users();

        return $c->checkUserLimits($type);
    }

    public static function setDefaultCompanyForUser($companyId,$add=false){
        $c=new L\Users();

        if($add)return $c->setCompanyNAddCount($companyId);

        return $c->setCompany($companyId);
        //$c=new
    }




}
