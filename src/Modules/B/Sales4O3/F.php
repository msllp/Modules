<?php

namespace MS\Mod\B\Sales4O3;
use Faker\Generator as Faker;
//use Faker\Provider\Miscellaneous as Faker;
class F
{


    public function __invoke()
    {

        self::runCron();


    }

    public static function runCron()
    {

    }
    public static function setupSalesForCompany($companyId){

        return L\Sales::fromController([['method'=>'migrateSalesAllTablesForCompany','data'=>['companyId'=>$companyId]]]);


    }
}
