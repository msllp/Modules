<?php


namespace MS\Core\Helper;


trait Logics
{
    public static function getTableRaw($method){

        $methodToCall=[
            'setUpBasicSettings'=>[],
          //  'setUpDashboardActionTable'=>[],
        ];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        // dd($d);
        return $d;
    }

}
