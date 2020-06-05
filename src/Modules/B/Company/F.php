<?php


namespace MS\Mod\B\Company;


class F
{
    public static function genUniqId(){
        return \MS\Core\Helper\Comman::random(3);
    }

    public static function getCompanyModel(){
        $m = new \MS\Core\Helper\MSDB(__NAMESPACE__,'Company_Master');
        return $m;
    }



}
