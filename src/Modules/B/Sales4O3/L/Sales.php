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
        $this->SalesMasterProductLedger='ProductLedger';
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

    public function migrateSalesAllTablesForCompany($data){


        $companyId=$data['companyId'];
        $tablesToMigrate=[
            'SalesMasterProduct','SalesMasterProductCategory','SalesMasterClient',//'SalesMasterClientLedger',
            'SalesMasterLead',//'SalesMasterProductLeadLedger','SalesMasterLeadAction',
            'SalesMasterQuotation',//'SalesMasterProductQuotationLedger','SalesMasterQuotationVersion'
        ];

        $models=[];

        foreach ($tablesToMigrate as $c)$models[$c]= call_user_func([$this,implode('',['get',$c,'Model'])],$companyId)->migrate();


        $companyId=array_key_exists('companyId',$data)?$data['companyId']:'';


    }









    public static function loadRoutes(){
        return [

            [
                'name'=>'Sales.Test1',
                'route'=>'/test',
                'method'=>'test',
                'type'=>'get',
            ],

            [
                'name'=>'Sales.Test2',
                'route'=>'/test',
                'method'=>'test',
                'type'=>'get',
            ],
        ];
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
