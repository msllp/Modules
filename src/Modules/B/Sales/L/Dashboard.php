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
        $m->setFields(['name'=>'hasSub','type'=>'boolean']);
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

    public function dashboardSectionTableMigrate(){
        $tableId=implode('_',[self::$modCode,'DashboardSectionForAction']);
        $m=new \MS\Core\Helper\MSDB(self::$namespace,$tableId);
        if (!$m->checkTableExist())return  $m->migrate();
        return false;

    }

    public function dashboardActionTableMigrate(){
        $tableId=implode('_',[self::$modCode,'DashboardActionForSection']);
        $m=new \MS\Core\Helper\MSDB(self::$namespace,$tableId);
        if (!$m->checkTableExist())return  $m->migrate();
        return false;
    }



    private function dashboardSectionTableDefaultData():array {
        $d=[

            [
                'UniqId'=>'sales1',
                'SectionName'=>'Sales.DashboardManageLeads',
                'SectionText'=>'Manage Leads',
                'SectionIcon'=>'msicon-svg-leads',
                'hasSub'=>true,
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales2',
                'SectionName'=>'Sales.DashboardManageQuotations',
                'SectionText'=>'Manage Quotations',
                'SectionIcon'=>'msicon-svg-followup',
                'hasSub'=>true,
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales3',
                'SectionName'=>'Sales.DashboardManageInvoices',
                'SectionText'=>'Manage Invoices',
                'SectionIcon'=>'msicon-svg-invoice',
                'hasSub'=>true,
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales4',
                'SectionName'=>'Sales.DashboardManageCustomers',
                'SectionText'=>'Manage Customers',
                'SectionIcon'=>'msicon-svg-customer',
                'hasSub'=>true,
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales5',
                'SectionName'=>'Sales.DashboardManageProductsNServices',
                'SectionText'=>'Manage Products & Services',
                'SectionIcon'=>'msicon-svg-productnservices',
                'hasSub'=>true,
                'Status'=>true,
            ],

        ];
        return $d;
    }

    public function dashboardSectionTableSeed(){
        $tableId=implode('_',[self::$modCode,'DashboardSectionForAction']);
        $d=$this->dashboardSectionTableDefaultData();

        $m=new \MS\Core\Helper\MSDB(self::$namespace,$tableId);

        foreach ($d as $r)$m->rowAdd($r,['UniqId','SectionName','SectionIcon','SectionText']);

        return true;
    }

    private function dashboardActionTableDefaultData():array{
        $d=[

            [
                'UniqId'=>'sales11',
                'ActionName'=>'Sales.NavSub11',
                'ActionText'=>'Get Lead',
                'ActionIcon'=>'msicon-for-addlead',
                'ActionLink'=>'',
                'SectionId'=>'sales1',
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales12',
                'ActionName'=>'Sales.NavSub13',
                'ActionText'=>'View all Leads',
                'ActionIcon'=>'msicon-for-viewlead',
                'ActionLink'=>'',
                'SectionId'=>'sales1',
                'Status'=>true,
            ],

            [
                'UniqId'=>'sales21',
                'ActionName'=>'Sales.NavSub12',
                'ActionText'=>'Generate Quotation',
                'ActionIcon'=>'msicon-for-addquotation',
                'ActionLink'=>'',
                'SectionId'=>'sales2',
                'Status'=>true,
            ],
            [
                'UniqId'=>'sales22',
                'ActionName'=>'Sales.NavSub14',
                'ActionText'=>'View all Quotation',
                'ActionIcon'=>'msicon-for-viewquotation',
                'ActionLink'=>'',
                'SectionId'=>'sales2',
                'Status'=>true,
            ],



        ];
        return $d;
    }

    public function dashboardActionTableSeed(){
        $tableId=implode('_',[self::$modCode,'DashboardActionForSection']);
        $d=$this->dashboardActionTableDefaultData();
        $m=new \MS\Core\Helper\MSDB(self::$namespace,$tableId);
        foreach ($d as $r)$m->rowAdd($r,['UniqId','ActionName','ActionIcon','ActionText']);
        //  $m=new \MS\Core\Helper\MSDB(self::$namespace,$tableId);
        return true;

    }

}
