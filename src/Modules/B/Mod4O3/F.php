<?php

namespace MS\Mod\B\Mod4O3;
use Faker\Generator as Faker;
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

    public static function runCron()
    {

    }
}
