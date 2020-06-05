<?php


namespace MS\Mod\B\Sales;


class F
{

    public static function setupSalesModule(){


        $methodToCall=[
            'dashboardSectionTableMigrate'=>[],
            'dashboardActionTableMigrate'=>[],
            'dashboardSectionTableSeed'=>[],
            'dashboardActionTableSeed'=>[],

        ];
        $c=new L\Dashboard();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d[$method]=$c->$method($data);
        $er=false;
        foreach ($d as $method=>$return)if(!$return)$er=true;
        if(!$er)return true;
            return false;


    }

}
