<?php


namespace MS\Mod\B\Sales4O3;


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

        $this->SalesMasterInvoice='InvoiceLedger';
        $this->SalesMasterInvoiceType='InvoiceType';
        $this->SalesDetailedInvoice='InvoiceDetailes';
        $this->SalesMasterProductInvoiceLedger='ProductLedgerInvoiceOut';
        $this->SalesMasterInvoicePayment='InvoiceLedgerPayment';

        $this->SalesMasterLead='Leads';
        $this->SalesMasterLeadDetailed='LeadsDetails';
        $this->SalesMasterProductLeadLedger='ProductLedgerLeadOut';
        $this->SalesMasterLeadAction='LeadAction';

        $this->SalesMasterQuotation='Quotation';
        $this->SalesMasterQuotationDetailed='QuotationDetails';
        $this->SalesMasterProductQuotationLedger='ProductLedgerQuotationOut';
        $this->SalesMasterQuotationVersion='QuotationVersion';

    }


    private function setupMasterProduct(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->CompanyCashLedger]),
            'tableName' => implode('_', [self::$modCode, 'CompanyCashLedger']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductName', 'type' => 'string']);
        $m->setFields(['name' => 'ProductUnit', 'type' => 'string']);
        $m->setFields(['name' => 'ProductUnitBatch', 'type' => 'string']);
        $m->setFields(['name' => 'ProductDescription', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductSaleCount', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductCategory', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductMadeCompany', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductModel', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductHsnSac', 'type' => 'string',]);
        $m->setFields(['name' => 'ProductPrice', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionPartial', 'type' => 'boolean',]);
        $m->setFields(['name' => 'TransactionStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    public static function getTableRaw($data=[])
    {

        $methodToCall = [

            'setupMasterProduct' => [],


        ];
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method)) $d = array_merge($d, $c->$method($data));
        // dd($d);
        return $d;
        dd($d);


    }

}
