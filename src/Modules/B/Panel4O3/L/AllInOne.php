<?php


namespace MS\Mod\B\Panel4O3\L;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class AllInOne extends Logic
{
    public function __construct($data = [])
    {

        $this->modPre='Panel4O3';

        parent::__construct($data);
    }


    public function dashboard($data){



        $data=[
            'currency'=>'₹',
            'company'=>\MS\Mod\B\Company4O3\F::getCurrentCompanyData(),
            'totalCash'=>\MS\Mod\B\Company4O3\F::getCurrentCashBalanceOfCompany(),
            'totalBank'=>\MS\Mod\B\Company4O3\F::getCurrentAllBankBalanceOfCompany()
        ];
        //dd($data);
        return  view('MOD::B.Panel4O3.V.AllInOne')->with('data',$data);

    }

    public static $userConstructData = [
        'UniqId' => 'string',
    ];

    public static $c_m = 'O3_Company_Master';
    public static $c_d = 'O3_Company_Data';
    public static $c_c = 'O3_Company_Config';
    public static $modCode = 'Company4O3';
    public $DB=[];

}
