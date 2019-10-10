<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 26-05-2019
 * Time: 06:18 PM
 */

namespace MS\Mod\B\Mod;
use Faker\Generator as Faker;
//use Faker\Provider\Miscellaneous as Faker;
class F
{






public static function genUniqId(){
    return \MS\Core\Helper\Comman::random(10);
}

public static function genAPIToken(){
    $faker = \Faker\Factory::create();

    return $faker->md5();

}

public static function genAPISecrete(){
    $faker = \Faker\Factory::create();

    return $faker->sha256();
}


public static function getRootModuleModel(){
    return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Mod');
}

public static function getRouteModel(){
    return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Route');
}

public static function checkRouteExist($r):array{
    $returnArray=['pathFound'=>false];
    $m=self::getRouteModel();

    $data=[
        'path'=>$r->path()
    ];

    $DBdata= $m->rowGet([
        'RouteUrl'=>$data['path'],
        'Status'=>1
    ]);
    //dd(count($DBdata));
    if (count($DBdata) == 1){


            $returnArray['pathFound']=true;

    }



    //return $data;
    return $returnArray;

}

}
