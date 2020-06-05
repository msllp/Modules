<?php


namespace MS\Mod\B\Sales4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Lead
{

    public static $userConstructData = [
        'UniqId' => 'string',

    ];

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB=[];

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->modPre='Sales';

        $this->SalesMasterLead='Leads'; //Only One
        $this->SalesMasterLeadDetailes='LeadDetailes'; //For Every Leads
        $this->SalesMasterLeadAction='LeadAction';//For Every Leads

    }


    private function setupSalesMasterLead(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterLead]),
            'tableName' => implode('_', [self::$modCode, 'MasterLead']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TypeOfClient', 'type' => 'string']);
        $m->setFields(['name' => 'O3User', 'type' => 'string']);
        $m->setFields(['name' => 'O3ConnectId', 'type' => 'string']);
        $m->setFields(['name' => 'BusinessName', 'type' => 'string']);
        $m->setFields(['name' => 'FirstName', 'type' => 'string']);
        $m->setFields(['name' => 'LastName', 'type' => 'string',]);
        $m->setFields(['name' => 'Email', 'type' => 'string',]);
        $m->setFields(['name' => 'ContactNo', 'type' => 'string',]);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string',]);
        $m->setFields(['name' => 'ClientId', 'type' => 'string',]);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string',]);
        $m->setFields(['name' => 'LeadCurrentUser', 'type' => 'string',]);
        $m->setFields(['name' => 'LeadStatus', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterLeadDetailes(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterLeadDetailes]),
            'tableName' => implode('_', [self::$modCode, 'LeadDetailes']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);
        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductPrice', 'type' => 'string']);
        $m->setFields(['name' => 'ProductNote', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterLeadAction(){

        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterLeadAction]),
            'tableName' => implode('_', [self::$modCode, 'LeadAction']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);
        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'stepType', 'type' => 'string']);
        $m->setFields(['name' => 'stepData', 'type' => 'string']);
        $m->setFields(['name' => 'stepNote', 'type' => 'string']);
        $m->setFields(['name' => 'stepManagedByUser', 'type' => 'string']);
        $m->setFields(['name' => 'stepStatus', 'type' => 'boolean']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }


    public static function getTableRaw($data=[])
    {
        $allMethods=get_class_methods (__CLASS__);
        $autoMethodsGrabed=[];
        foreach ($allMethods as $k=>$m)if(strpos($m,'setup')===0)$autoMethodsGrabed[$m]=[];
        //  dd($autoMethodsGrabed);
        $methodToCall = [];
        $methodToCall=array_merge($autoMethodsGrabed,$methodToCall);
        //   dd($methodToCall);
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method))  $d = array_merge($d, $c->$method($data));
        return $d;
    }

}
