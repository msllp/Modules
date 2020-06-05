<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 26-05-2019
 * Time: 06:18 PM
 */

namespace MS\Mod\B\Company4O3;
use Faker\Generator as Faker;
//use Faker\Provider\Miscellaneous as Faker;
class F
{


    public function __invoke()
    {

        self::runCron();


    }

    public static function getCurrentAllBankBalanceOfCompany (){
        $data=[];
        return L\Company::fromController([['method'=>'getCurrentBankBalanceOfCompany','data'=>$data]]);

    }
    public static function getCurrentCashBalanceOfCompany (){
        $data=[];
        return L\Company::fromController([['method'=>'getCurrentCashBalanceOfCompany','data'=>$data]]);

    }

    public static function getCurrentCompanyData(){
        $data=[];
        return L\Company::fromController([['method'=>'getCurrentCompanyForUser','data'=>$data]]);

    }
    public static function getAllCompany(){
        $data=[
            'json'=>false
        ];
        return L\Company::fromController([['method'=>'getAllCompanyForUser','data'=>$data]]);

    }
    public static function runCron()
    {

    }
}
