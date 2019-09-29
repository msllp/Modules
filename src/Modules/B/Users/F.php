<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 26-05-2019
 * Time: 06:18 PM
 */

namespace B\MAS;
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

}
