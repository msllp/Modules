<?php

namespace MS\Mod\B\Mod4O3;
use DemeterChain\A;
use Faker\Generator as Faker;
use MS\Mod\B\Mod4O3\L\App;

//use Faker\Provider\Miscellaneous as Faker;
class F
{


    public function __invoke()
    {

        self::runCron();


    }


    public static function getApiTokenForWebsite($appId){

        dd($appId);
    }

    public static function getPermissions(){
        $c=new App();
        return $c->getPermisions();
    }

    public static function makeDataForPermission($data){
        $c=new App();
        return $c->getProccessedPermissionForTableEntry($data);
    }


    public static function getAllowedCompany(){
        $c=new L\App();
        return $c->getAllowedCompany();
    }

    public static function runCron()
    {

    }
}
