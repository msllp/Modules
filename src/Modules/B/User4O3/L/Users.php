<?php
namespace MS\Mod\B\User4O3\L;

use phpDocumentor\Reflection\Types\Self_;

class Users
{


    public $UserId;

    public static $userConstructData=[
        'UserId'=>'string'
            ];

    public function __construct($data=[])
    {

        $this->UserMSDB=implode('_',[self::$modCode,'Users']);
        $this->ModNameSpace='MS\Mod\B\User4O3';

        if(count($data))foreach ($data as $k=>$v)if(array_key_exists($k,self::$userConstructData) && gettype($v)==self::$userConstructData[$k] )$this->$k=$v;


    }

    public static $type=['website','app','google'];

    public static function getUserModel(){
        $c=new self();
        return $c=new \MS\Core\Helper\MSDB($c->ModNameSpace,$c->UserMSDB);
    }

    public function unSet($column,$d){

        foreach ($column as $name){
            if(array_key_exists($name,$d))unset($d[$name]);
        }
        return$d;
    }
    public function getUserByApiToken($apiToken){

        $m=self::getUserModel();
        $u=$m->rowGet(['apiToken'=>$apiToken]);
        if (count($u) > 0){
            $d=$m->rowGet(['apiToken'=>$apiToken]);
            $e=reset($d);
            $h=['apiToken','Password','created_at','updated_at','Hook'];
            $e=$this->unSet($h,$e);
            return $e;

        }
        return [];

        dd($m->where('apiToken','=',$apiToken)->get()->count());

    }

    public function getLiveUser(){
        return      [
            "Username"=>"maxirooney",
            "email"=>"user@company.com",
            "fname"=>"Mitul",
            "lname"=>"Patel",
            "phone"=>"9662611234",
            "sex"=>"male"
        ];;
    }

    public function getUserPlan($userId){

        $plans=Plans::getAllPlanS();

     //   dd(collect($plans)->where('UniqId',"=",'111')->first());

        $plan=collect($plans)->where('UniqId',"=",'111')->first();



        return[
            'planId'=>$plan['UniqId'],
            'name'=>$plan['PlanName'],
            'limits'=>[

            'products'=>[
                'vName' =>'Products',
                'limit' =>$plan['Product'],
                'usage' =>1,
            ],
            'invoice'=>[
                'vName' =>'Invoice',
                'limit' =>$plan['Invoice'],
                'usage' =>1,
            ],
            'purchase'=>[
                'vName' =>'Purchase',
                'limit' =>$plan['Purchase'],
                'usage' =>1,
            ],
                'company'=>[
                'vName' =>'Company',
                'limit' =>$plan['Company'],
                'usage' =>1,
            ]
                ,
                'user'=>[
                'vName' =>'Users/Company',
                'limit' =>$plan['PerCompanyUser'],
                'usage' =>1,
            ]
                ,
                'validupto'=>[
                    'vName' =>'Valid upto',
                    'limit' => now()->format('Y'),
                    'usage' =>now()->format('d/m'),
                ]

            ]
        ];
    }


    public static function fromController(array $methods){
        $c=new self();

      //  dd($methods);
        if (count($methods) > 1 && count($methods)!=0){

        }elseif(count($methods)!=0){

            foreach ($methods as $method){
                if(array_key_exists('method',$method) && array_key_exists('data',$method)){

                    return $c->$method['method']($method['data']);
                }
            }

        }


    }
    private function getNewUserNo(){
        $c=new \MS\Core\Helper\MSDB($this->ModNameSpace,$this->UserMSDB);
        $code= \MS\Core\Helper\Comman::random(16 ,1,1);
        $d=$c->getModel();
        while ($d->where('UniqId',$code)->get()->count() > 1){
            $code= \MS\Core\Helper\Comman::random(16    ,1,1);
        }
        return $code;
    }

    private function getNewApiTokenForUser(){
        $c=new \MS\Core\Helper\MSDB($this->ModNameSpace,$this->UserMSDB);
        $code= \MS\Core\Helper\Comman::random(188 ,4,1);
        $d=$c->getModel();
        while ($d->where('apiToken',$code)->get()->count() > 1){
            $code= \MS\Core\Helper\Comman::random(16    ,1,1);
        }
        return $code;
    }
    private function getDefault($id){
        $d=[
            'HookType'=>'MS',
            'HookId'=>0,
            'HookData'=>collect([])->toJson(),
            'UserPlan'=>'111'
        ];
        if(array_key_exists($id,$d)){
        return $d[$id];
        }else{
            return '';
        }
    }
    public function signUpUser($data=[],$type=''){

       // $this->migrate();
        $userData=[
            'UniqId'=>$this->getNewUserNo(),
            'apiToken'=>$this->getNewApiTokenForUser(),
            'HookType'=>$this->getDefault('HookType'),
            'HookId'=>$this->getDefault('HookId'),
            'HookData'=>$this->getDefault('HookData'),
            'Email'=> (array_key_exists('Email',$data))?$data['Email'] :' ',
            'ContactNo'=>(array_key_exists('ContactNo',$data))?$data['ContactNo'] :' ',
            'Username'=>(array_key_exists('Username',$data))?$data['Username'] :' ',
            'Password'=>(array_key_exists('Password',$data))?\MS\Core\Helper\Comman::encode ($data['Password']) :' ',
            'FirstName'=>(array_key_exists('FirstName',$data))?$data['FirstName'] :' ',
            'LastName'=>(array_key_exists('LastName',$data))?$data['LastName'] :' ',
            'Sex'=>(array_key_exists('Sex',$data))?$data['Sex'] :' ',
            'CompanyId'=>(array_key_exists('CompanyId',$data))?$data['CompanyId'] :' ',
            'UserTotalPaid'=>0,
            'UserTotalPending'=>0,
            'UserPlan'=>(array_key_exists('Plan',$data))?$data['Plan'] :$this->getDefault('UserPlan'),
            'UserValidUpto'=>now(env('APP_TIMEZONE'))->addYear(1)->getTimestamp(),
            'UserProductCount'=>0,
            'UserInvoiceCount'=>0,
            'UserCompanyCount'=>0,
            'UserCompanyUserCount'=>0,
            'PaymentSuspend'=>0,
            'UserStatus'=>1,

        ];
       // dd($userData['UserValidUpto']);
     //   $dt = \Carbon::now(env('APP_TIMEZONE'));
       // $date=$dt->timestamp($userData['UserValidUpto']) ;

        $c=new \MS\Core\Helper\MSDB($this->ModNameSpace,$this->UserMSDB);
      //  dd($date);
      dd($c->rowAdd($userData));
        $tableId="";
        if(((array_key_exists('Username',$data) or array_key_exists('Email',$data) or array_key_exists('ContactNo',$data) ) && array_key_exists('FirstName',$data))){


            dd($c);
            dd($c->rowAdd($userData));
           return "";
        //   dd($data);


        }


    }

    public function signInUser($data=[],$type=''){}
    public function upgradeUser($data=[],$type=''){}
    public function viewUserProfile($data=[],$type=''){

        $user=$this->getLiveUser();
        $user['plan']=(array_key_exists('Username',$user))?$this->getUserPlan($user['Username']):$this->getUserPlan($user['email']);
            return $user;

    }
    public function editUserProfile($data=[],$type=''){}


    private function makeArrayForDBEntryForUserTable($data):array {}
    private function makeArrayForDBEntryTableConnection($data):array {}
    private function MigrateDBForUser($data):array {}



    public static $c_m='O3_Users_Master';
    public static $c_d='O3_Users_Data';
    public static $c_c='O3_Users_Config';
    public static $modCode='Users4O3';

    public static function getTableRaw(){

        $methodToCall=[
            'setUpMasterUser'=>[],
            // 'setUpPlanCatergoryLimits'=>[],
        ];
        $c=new self() ;
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        return $d;
        dd($d);



    }

    private function setUpMasterUser(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'Users']),
            'tableName'=>implode('_',[self::$modCode,'Users']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name' =>'UniqId','type'=>'string']);
        $m->setFields(['name' =>'Username','type'=>'string']);
        $m->setFields(['name' =>'Password','type'=>'string']);
        $m->setFields(['name' =>'apiToken','type'=>'string']);
        $m->setFields(['name' =>'HookType','type'=>'string']);
        $m->setFields(['name' =>'HookId','type'=>'string',]);
        $m->setFields(['name' =>'HookData','type'=>'string',]);
        $m->setFields(['name' => 'FirstName', 'type' => 'string']);
        $m->setFields(['name' => 'Sex', 'type' => 'string']);
        $m->setFields(['name' => 'LastName', 'type' => 'string',]);
        $m->setFields(['name' => 'Email', 'type' => 'string',]);
        $m->setFields(['name' => 'ContactNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyId', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyPost', 'type' => 'string',]);
        $m->setFields(['name' => 'UserTotalPaid', 'type' => 'string',]);
        $m->setFields(['name' => 'UserTotalPending', 'type' => 'string',]);

        $m->setFields(['name' => 'UserPlan', 'type' => 'string',]);
        $m->setFields(['name' => 'UserValidUpto', 'type' => 'string',]);
        $m->setFields(['name' => 'UserProductCount', 'type' => 'string',]);
        $m->setFields(['name' => 'UserInvoiceCount', 'type' => 'string',]);

        $m->setFields(['name' => 'UserCompanyCount', 'type' => 'string',]);
        $m->setFields(['name' => 'UserCompanyUserCount', 'type' => 'string',]);
        $m->setFields(['name' => 'PaymentSuspend', 'type' => 'boolean',]);
        $m->setFields(['name' => 'UserStatus', 'type' => 'boolean',]);

        $m1=$m->finalReturnForTableFile();

        return array_merge($m1);
    }


    public function migrate(){
        $tableId=implode('_',[self::$modCode,'Users']);

        $c=new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',$tableId);

      //  dd($c->migrate());
        return $c->migrate();

    }




    private function setUpUserPayment($userId){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'Payment_Ledger',$userId]),
            'tableName'=>implode('_',[self::$modCode,'Payment_Ledger',$userId]),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name' =>'UniqId','type'=>'string']);
        $m->setFields(['name' =>'PaymentType','type'=>'string']);
        $m->setFields(['name' =>'PaymentStatus','type'=>'string']);
        $m->setFields(['name' =>'PaymentAmount','type'=>'string',]);
        $m->setFields(['name' =>'PaymentCharges','type'=>'string',]);
        $m->setFields(['name' => 'PaymentTax', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentTaxDetails', 'type' => 'string',]);

        $m1=$m->finalReturnForTableFile();

        return array_merge($m1);
    }





}
