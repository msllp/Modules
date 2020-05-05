<?php


namespace MS\Mod\B\Sales4O3;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Config extends Logic
{

    public static $userConstructData = [
        'UniqId' => 'string',

    ];

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB=[];

    private $typeOfTaxCode=[
        'h'=>'HSN',
        's'=>'SAC'
    ];

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->modPre='Sales';
        $this->SalesMasterProductUnit='Units';
        $this->SalesMasterProductUnitConversation='UnitsConverstation';
        $this->SalesMasterHsnSac='HsnSac';
        $this->SalesMasterHsnSacLedger='HsnSac';
        $this->SalesMasterCompany='MasterMake';
        $this->SalesMasterCompanyLedger='MasterMakeProductLedger';




    }

    private function  defaultUnitType(){
        return $allUnitType;
    }



    private function getUnitTypeCode($t){
        return (array_key_exists($t,$this->allUnitType))?$t:'s';
    }

    private function defaultMasterProductUnit(){
        $data=[
            [
                'UniqId'=>\MS\Core\Helper\Comman::random(5,3),
                'UnitName'=>'Pieces',
                'UnitShortName'=>'pc',
                'UnitStatus'=>true
            ],
            [
                'UniqId'=>\MS\Core\Helper\Comman::random(5,3),
                'UnitName'=>'Liter',
                'UnitShortName'=>'lt',
                'UnitStatus'=>true
            ],
            [
                'UniqId'=>\MS\Core\Helper\Comman::random(5,3),
                'UnitName'=>'Kilogram',
                'UnitShortName'=>'kg',
                'UnitStatus'=>true
            ],
        ];
    }

    private function setupMasterProductUnit(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnit ]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnit']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'UnitName', 'type' => 'string']);
        $m->setFields(['name' => 'UnitShortName', 'type' => 'string']);
        $m->setFields(['name' => 'UnitStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterProductUnitConversation(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnitConversation]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnitConversation']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'UnitName', 'type' => 'string']);
        $m->setFields(['name' => 'UnitShortName', 'type' => 'string']);
        $m->setFields(['name' => 'UnitMultiplier', 'type' => 'string']);
        $m->setFields(['name' => 'UnitStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterHsnSac(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnit]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnit']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TypeOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'NameOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'DescriptionOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'TaxCode', 'type' => 'string']);
        $m->setFields(['name' => 'CGST', 'type' => 'string']);
        $m->setFields(['name' => 'SGST', 'type' => 'string']);
        $m->setFields(['name' => 'IGST', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterHsnSacLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnit]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnit']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TypeOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'NameOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'DescriptionOfCode', 'type' => 'string']);
        $m->setFields(['name' => 'TaxCode', 'type' => 'string']);
        $m->setFields(['name' => 'CGST', 'type' => 'string']);
        $m->setFields(['name' => 'SGST', 'type' => 'string']);
        $m->setFields(['name' => 'IGST', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterCompany(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnit]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnit']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyName', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyShort', 'type' => 'string']);
        $m->setFields(['name' => 'OriginCity', 'type' => 'string']);
        $m->setFields(['name' => 'OriginCountry', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyData', 'type' => 'string']);
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);

    }

    private function setupSalesMasterCompanyLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductUnit]),
            'tableName' => implode('_', [self::$modCode, 'SalesUnit']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductCode', 'type' => 'string']);
        $m->setFields(['name' => 'ProductCodeVersion', 'type' => 'string']);
        $m->setFields(['name' => 'ProductPrice', 'type' => 'string']);

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
