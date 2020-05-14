<?php


namespace MS\Mod\B\Sales4O3\L;


use MS\Core\Helper\MSTableSchema;

class Product
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


    }


    private function setupMasterProduct(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProduct]),
            'tableName' => implode('_', [self::$modCode, 'MasterProduct']),
            'connection' => self::$c_m,
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
            'connection' => self::$c_c,
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

    private function setupSalesMasterProductLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductLedger']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductRate', 'type' => 'string']);
        $m->setFields(['name' => 'ProductUnit', 'type' => 'string']);

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
