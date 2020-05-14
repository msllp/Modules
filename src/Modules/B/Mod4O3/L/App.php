<?php


namespace MS\Mod\B\Mod4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class App extends Logic
{

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB=[];


    public function genrateApiTokenForFrontEnd ($data){
        $r=$data['r'];
        $debug=0;
        $er=[
            '419'=>['Dont try to be smart . You are not only who think smart.']
        ];
        if(!$debug && !$r->headers->has('MS-APP-ID'))return $this->throwError($er['419']);
        $appId=$r->headers->get('MS-APP-ID');
        return $this->throwData(['csrf'=>\MS\Core\Helper\Comman::encodeLimit($appId,120)]);


    }

}
