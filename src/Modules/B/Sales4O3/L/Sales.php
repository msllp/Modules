<?php

namespace MS\Mod\B\Sales4O3\L;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Sales extends Logic
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

        $this->SalesMasterProduct='Product';
        $this->SalesMasterProductCategory='ProductCategory';
        $this->SalesMasterClient='MasterClient';
        $this->SalesMasterClientLedger='MasterClientLedger';

    //    $this->SalesMasterProductCategoryLedger='ProductCategoryLedger';

        $this->SalesMasterLead='Leads';
        $this->SalesMasterProductLeadLedger='ProductLedgerLeadOut';
        $this->SalesMasterLeadAction='LeadAction';

        $this->SalesMasterQuotation='Quotation';
        $this->SalesMasterProductQuotationLedger='ProductLedgerQuotationOut';
        $this->SalesMasterQuotationVersion='QuotationVersion';



        $this->SalesMasterInvoice='InvoiceLedger';
        $this->SalesMasterInvoiceType='InvoiceType';
        $this->SalesDetailedInvoice='InvoiceDetailes';
        $this->SalesMasterProductInvoiceLedger='ProductLedgerInvoiceOut';
        $this->SalesMasterInvoicePayment='InvoiceLedgerPayment';






    }


    private function setupMasterProduct(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProduct]),
            'tableName' => implode('_', [self::$modCode, 'MasterProduct']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductCodeVersion', 'type' => 'string']);
        $m->setFields(['name' => 'ProductBarcode', 'type' => 'string']);
        $m->setFields(['name' => 'ProductName', 'type' => 'string']);
        $m->setFields(['name' => 'ProductUnit', 'type' => 'string']);
        $m->setFields(['name' => 'ProductDescription', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductSaleCount', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductCategory', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductMadeCompany', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductModel', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductHsnSac', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductBasePrice', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductAvaragePrice', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductTrade', 'type' => 'boolean',]);
        $m->setFields(['name' => 'ProductKeepStock', 'type' => 'boolean',]);
        $m->setFields(['name' => 'ProductExtraData', 'type' => 'boolean',]);
        $m->setFields(['name' => 'ProductStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterProductCategory(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductCategory]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductCategory']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryName', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryExtraData', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryDescription', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterClient(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClient]),
            'tableName' => implode('_', [self::$modCode, 'MasterClient']),
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
        $m->setFields(['name' => 'Sex', 'type' => 'string']);
        $m->setFields(['name' => 'Email', 'type' => 'string',]);
        $m->setFields(['name' => 'ContactNo', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalPaid', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalPending', 'type' => 'string',]);
        $m->setFields(['name' => 'ClientStatus', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterLead(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterLeadDetailed]),
            'tableName' => implode('_', [self::$modCode, 'MasterLead']),
            'connection' => self::$c_d,
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
    private function setupSalesMasterProductLeadLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductLeadLedger]),
            'tableName' => implode('_', [self::$modCode, 'ProductLeadLedger']),
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

    private function setupSalesMasterQuotation(){

        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterQuotation]),
            'tableName' => implode('_', [self::$modCode, 'MasterQuotation']),
            'connection' => self::$c_d,
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
        $methodToCall = [];
        $methodToCall=array_merge($autoMethodsGrabed,$methodToCall);
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method))  $d = array_merge($d, $c->$method($data));
        return $d;
    }

}
