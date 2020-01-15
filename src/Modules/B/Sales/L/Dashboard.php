<?php


namespace MS\Mod\B\Sales\L;


class Dashboard
{
    public static $namespace='MS\Mod\B\Sales';
    public static $c_m='MS_Sales_Master';
    public static $c_d='MS_Sales_Data';
    public static $c_c='MS_Sales_Config';
    public static $modCode='Sales';
    private $TableId=[];
    public function __construct()
    {
    }

    public static function getTableRaw(){

        $methodToCall=[
            'setUpDashboardSectionTable'=>[],
            'setUpDashboardActionTable'=>[],
        ];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
       // dd($d);
        return $d;
    }

    private function setUpDashboardSectionTable($data){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'DashboardSectionForAction']),
            'tableName'=>implode('_',[self::$modCode,'DashboardSectionForAction']),
            'connection'=>self::$c_c,
        ];


        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','type'=>'string']);
        $m->setFields(['name'=>'SectionName','type'=>'string']);
        $m->setFields(['name'=>'SectionText','type'=>'string']);
        $m->setFields(['name'=>'SectionIcon','type'=>'string']);
        $m->setFields(['name'=>'hasSub','type'=>'string']);
        $m1=$m->finalReturnForTableFile();

        $data=[
            'tableId'=>implode('_',[self::$modCode,'DashboardSectionForAction']),
            'tableName'=>implode('_',[self::$modCode,'DashboardSectionForAction']),
            'connection'=>self::$c_c,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','type'=>'string']);
        $m->setFields(['name'=>'ActionName','type'=>'string']);
        $m->setFields(['name'=>'ActionText','type'=>'string']);
        $m->setFields(['name'=>'ActionIcon','type'=>'string']);
        $m->setFields(['name'=>'ActionLink','type'=>'string']);
        $m->setFields(['name'=>'SectionId','type'=>'string']);
        $m->setFields(['name'=>'Status','type'=>'string']);

        $m2=$m->finalReturnForTableFile();

        return array_merge($m1,$m2);

    }

    public function dashboardSectionTableMigrate(){
        $m=new \MS\Core\Helper\MSDB(self::$namespace,implode('_',[self::$modCode,'DashboardSectionForAction']));
        if ($m->checkTableExist())  $m->migrate();


    }

}
