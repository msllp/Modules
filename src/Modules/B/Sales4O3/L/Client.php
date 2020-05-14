<?php


namespace MS\Mod\B\Sales4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Client extends Logic
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

        $this->SalesMasterClient='MasterClient';//For Only One
        $this->SalesMasterClientLedger='MasterClientLedger';//For Every Client
        $this->SalesMasterClientPaymentLedger='MasterClientPaymentLedger';//For Every Client

    }

    public function addClient($data){}
    private function migrateForClient($clientId){}
    public function editClient($data){}

    private function setupSalesMasterClient(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClient]),
            'tableName' => implode('_', [self::$modCode, 'MasterClient']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TypeOfClient', 'type' => 'string']);
        $m->setFields(['name' => 'O3User', 'type' => 'boolean']);
        $m->setFields(['name' => 'O3ConnectId', 'type' => 'string']);

        $m->setFields(['name' => 'FirstName', 'type' => 'string']);
        $m->setFields(['name' => 'LastName', 'type' => 'string',]);
        $m->setFields(['name' => 'Sex', 'type' => 'string']);
        $m->setFields(['name' => 'Email', 'type' => 'string',]);
        $m->setFields(['name' => 'ContactNo', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalPaid', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalPending', 'type' => 'string',]);

        $m->setFields(['name' => 'CompanyName', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyGST', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyPANTAN', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyCIN', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyLLPNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyVerified', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyStatus', 'type' => 'boolean',]);


        $m->setFields(['name' => 'ClientStatus', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterClientLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClientLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterClientLedger']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'TotalAmount', 'type' => 'string']);
        $m->setFields(['name' => 'TotalTax', 'type' => 'string']);
        $m->setFields(['name' => 'TaxDetails', 'type' => 'string']);
        $m->setFields(['name' => 'TotalPaid', 'type' => 'string']);
        $m->setFields(['name' => 'PartialPaid', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentDetails', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterClientPaymentLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClientLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterClientLedger']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'AmountPaid', 'type' => 'string']);
        $m->setFields(['name' => 'AmountTax', 'type' => 'string']);
        $m->setFields(['name' => 'AmountPending', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentType', 'type' => 'string']);
        $m->setFields(['name' => 'ActionInwardBy', 'type' => 'string']);
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
