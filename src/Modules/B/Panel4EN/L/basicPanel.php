<?php


namespace MS\Mod\B\Panel4EN\L;


class basicPanel
{
    public static $namespace='MS\Mod\B\Panel4EN';
    public static $c_m='MS_ENV_panel_Master';
    public static $c_d='MS_ENV_Panel_Data';
    public static $c_c='MS_ENV_Panel_Config';
    public static $modCode='Sales';
    private $TableId=[];
    public function __construct()
    {
    }

    public static function getTableRaw(){

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

    private function setUpBasicSettings($data){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'Current_Live_Users']),
            'tableName'=>implode('_',[self::$modCode,'DashboardSectionForAction']),
            'connection'=>self::$c_c,
        ];


        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','type'=>'string']);
        $m->setFields(['name'=>'UserId','type'=>'string']);
        $m->setFields(['name'=>'Device','type'=>'string']);
        $m->setFields(['name'=>'Channel','type'=>'string']);
        $m->setFields(['name'=>'LastActive','type'=>'string']);
        $m->setFields(['name'=>'SessionApiToken','type'=>'string']);
        $m->setFields(['name'=>'UserExit','type'=>'boolean']);
        $m->setFields(['name'=>'Status','type'=>'boolean']);

        $m1=$m->finalReturnForTableFile();

        $data=[
            'tableId'=>implode('_',[self::$modCode,'DashboardActionForSection']),
            'tableName'=>implode('_',[self::$modCode,'DashboardActionForSection']),
            'connection'=>self::$c_c,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','type'=>'string']);
        $m->setFields(['name'=>'ActionName','type'=>'string']);
        $m->setFields(['name'=>'ActionText','type'=>'string']);
        $m->setFields(['name'=>'ActionIcon','type'=>'string']);
        $m->setFields(['name'=>'ActionLink','type'=>'string']);
        $m->setFields(['name'=>'SectionId','type'=>'string']);
        $m->setFields(['name'=>'Status','type'=>'boolean']);

        $m2=$m->finalReturnForTableFile();

        return array_merge($m1,$m2);

    }



}
