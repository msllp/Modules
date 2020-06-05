<?php


namespace MS\Mod\B\Sales\L;


use MS\Core\Module\Logic;

class Tax extends Logic
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

        $this->SalesMasterTaxCode='MasterGSTCode';


    }
}
