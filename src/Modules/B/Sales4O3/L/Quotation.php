<?php


namespace MS\Mod\B\Sales4O3\L;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Quotation extends Logic
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

        $this->SalesMasterQuotation='Quotation';//Only One
        $this->SalesMasterProductQuotationLedger='ProductLedgerQuotationOut';//For Every Version Of Quotation
        $this->SalesMasterQuotationVersion='QuotationVersion';//For Every Quotation




    }



    private function setupSalesMasterQuotation(){

        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterQuotation]),
            'tableName' => implode('_', [self::$modCode, 'MasterQuotation']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);
        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'InoviceId', 'type' => 'string']);
        $m->setFields(['name' => 'ClientId', 'type' => 'string']);
        $m->setFields(['name' => 'QuoteAmount', 'type' => 'string']);
        $m->setFields(['name' => 'ExpireOn', 'type' => 'string']);
        $m->setFields(['name' => 'CurrentVesrion', 'type' => 'string']);
        $m->setFields(['name' => 'CurrentVesrionGenratedBy', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationStatus', 'type' => 'boolean']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);

    }
    private function setupSalesSalesMasterQuotationVersion(){

        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterQuotationVersion]),
            'tableName' => implode('_', [self::$modCode, 'QuotationVersion']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);
        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'GenratedBy', 'type' => 'string']);
        $m->setFields(['name' => 'ExpiredOn', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationStatus', 'type' => 'boolean']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);

    }
    private function setupSalesMasterProductQuotationLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductQuotationLedger]),
            'tableName' => implode('_', [self::$modCode, 'QuotationProductLedger']),
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
