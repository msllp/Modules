<?php


namespace MS\Mod\B\Sales4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;


class Invoice extends Logic
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




        $this->SalesMasterInvoice='InvoiceLedger'; //Onlu One invoiceid/qutation/leadId/totaxamount/totalamoint/paidstatus
        $this->SalesMasterInvoiceType='InvoiceType'; //Only One
        $this->SalesDetailedInvoice='InvoiceDetailes'; //For Every Invoice productId/qt/tax/arate/totalamount
        $this->SalesMasterProductInvoiceLedger='ProductLedgerInvoiceOut'; //For Every Product
        $this->SalesMasterInvoicePayment='InvoiceLedgerPayment'; //For Every Payment On Every Invoice


    }

    private function setupSalesMasterInvoice(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterInvoice]),
            'tableName' => implode('_', [self::$modCode, 'MasterInvoice']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

    }
    private function setupSalesMasterInvoiceType(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterInvoiceType]),
            'tableName' => implode('_', [self::$modCode, 'MasterInvoiceType']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);
    }
    private function setupSalesDetailedInvoice(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesDetailedInvoice]),
            'tableName' => implode('_', [self::$modCode, 'MasterInvocieDetailes']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);
    }
    private function setupSalesMasterProductInvoiceLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductInvoiceLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductInvoiceLedger']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);
    }
    private function setupSalesMasterInvoicePayment(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterInvoicePayment]),
            'tableName' => implode('_', [self::$modCode, 'MasterInvoicePayment']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);
    }




    public static function loadRoutes(){
        return [


            [
                'name'=>'In.Test1',
                'route'=>'/test',
                'method'=>'test',
                'type'=>'get',
            ],

            [
                'name'=>'In.Test2',
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
