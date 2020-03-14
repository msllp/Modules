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


        if (count($methods) > 1 && count($methods)!=0){

        }elseif(count($methods)!=0){

            foreach ($methods as $method){
                if(array_key_exists('method',$method) && array_key_exists('data',$method)){
            //        dd(call_user_func([$c,$method['method']],$method['data']));
                    return call_user_func([$c,$method['method']],$method['data']);
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

    public function email_VerifyUserEmail($to,$name){
        $data=[
            'mailSubject'=>'Email Verification for O3 ERP Account Opening',
            'name'=>$name,
            //'toEmail'=>'emails@domain.com',
            'otp'=>\MS\Core\Helper\Comman::random(5)
        ];

       // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {
            $m=\MS\Core\Helper\MSMail::SendMail($to,'MS::core.layouts.Email.EmailVerify',$data);

        }catch (\Exception $e){
            return [] ;
        }
        return $data;
    }
    public function sms_VerifyUserEmail($to,$name){
        $data=[
            'mailSubject'=>'Email Verification for O3 ERP Account Opening',
            'name'=>$name,
            //'toEmail'=>'emails@domain.com',
            'otp'=>\MS\Core\Helper\Comman::random(5)
        ];
        return $data;
        // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {
            $m=\MS\Core\Helper\MSMail::SendMail($to,'MS::core.layouts.Email.EmailVerify',$data);

        }catch (\Exception $e){
            return [] ;
        }
        return $data;
    }

    public function verifyUser($data=[]){
       // dd($data);
        $responseJson=[];
        $m=self::getOtpModel();
        $u=self::getUserModel();
        $fV=$m->rowGet(['UniqId'=>$data['UniqId']]);
        if(count($fV)>0){
            $otpRow=reset($fV);
            $getOtp=$data['input']['otp'];
            $sourceOtp=$otpRow['OTP'];

            if($getOtp==$sourceOtp && $otpRow['Verified']==0){
                $m->rowDelete(['UniqId'=>$data['UniqId']]);
                $u->rowEdit(['UniqId'=>$otpRow['UserId']],['UserStatus'=>1]);
                $responseJson['otpVerified']=true;
                $responseJson['status']=200;
            }else{
                $m->rowEdit(['UniqId'=>$data['UniqId']],['Verified'=>$otpRow['Verified']++]);
                $responseJson['otpVerified']=false;
                $responseJson['status']=409;
                $responseJson['errorMsg']=[
                    'Please enter valid OTP !',
                ];
            }

        }


        return response()->json($responseJson);
    }

    public function signUpUser($data=[],$type=''){


        $responseJson=[];

        if(array_key_exists('useMobile',$data) && $data['useMobile'])$data['Username']=$data['ContactNo'];

        $checkUser=$this->checkUserExistOrNot($data);
       // dd($checkUser);
        if(array_key_exists(1,$checkUser) && count($checkUser[1])>0){
            $responseJson['status']=409;
            $responseJson['errorMsg']=[
                'We think you are already in our system.',
                'If you forgot your account details please mail us on help@o3erp.com'
            ];

        }
        else{
            $userData=[
                'UniqId'=>$this->getNewUserNo(),
                'apiToken'=>$this->getNewApiTokenForUser(),
                'HookType'=>$this->getDefault('HookType'),
                'HookId'=>$this->getDefault('HookId'),
                'HookData'=>$this->getDefault('HookData'),
                'Email'=> (array_key_exists('Email',$data))?$data['Email'] :' ',
                'ContactNo'=>(array_key_exists('ContactNo',$data))?$data['ContactNo'] :' ',
                'Username'=>(array_key_exists('Username',$data))? strtolower($data['Username']):(array_key_exists('useMobile',$data) && $data['useMobile'] == true )? $data['ContactNo']:$data['ContactNo'],
                'Password'=>(array_key_exists('Password',$data))?\MS\Core\Helper\Comman::encode ($data['Password']) :' ',
                'FirstName'=>(array_key_exists('FirstName',$data))?$data['FirstName'] :' ',
                'LastName'=>(array_key_exists('LastName',$data))?$data['LastName'] :' ',
                'Sex'=>(array_key_exists('Sex',$data))?$data['Sex'] :' ',
                'CompanyId'=>(array_key_exists('CompanyId',$data))?$data['CompanyId'] :0,
                'UserTotalPaid'=>0,
                'UserTotalPending'=>0,
                'UserPlan'=>(array_key_exists('Plan',$data))?$data['Plan'] :$this->getDefault('UserPlan'),
                'UserValidUpto'=>now(env('APP_TIMEZONE'))->addYear(1)->getTimestamp(),
                'UserProductCount'=>0,
                'UserInvoiceCount'=>0,
                'UserCompanyCount'=>0,
                'UserCompanyUserCount'=>0,
                'PaymentSuspend'=>0,
                'UserStatus'=>0,

            ];
            $c=new \MS\Core\Helper\MSDB($this->ModNameSpace,$this->UserMSDB);

            if((array_key_exists('useMobile',$data))?$data['useMobile'] :false)
            {
                $c->rowAdd($userData);
                $verifyData=$this->sms_VerifyUserEmail($userData['Email'],implode(' ',[$userData['FirstName'],$userData['LastName']]));
                $responseJson['type']='sms';
                $responseJson['otp']=$verifyData['otp'];
                $responseJson['userDetails']=$userData;
                $responseJson['status']=200;
            }
            else{
                $c->rowAdd($userData);
                $verifyData=$this->email_VerifyUserEmail($userData['Email'],implode(' ',[$userData['FirstName'],$userData['LastName']]));
                $responseJson['type']='email';
                $responseJson['otp']=$verifyData['otp'];
                $responseJson['userDetails']=$userData;
                $responseJson['status']=200;
            }

            if( array_key_exists('type',$responseJson) && array_key_exists('otp',$responseJson) )$responseJson['OTPUniqId']=  $this->regOtpForUser($responseJson['type'],$userData['UniqId'],$responseJson['otp'])['UniqId'];
            if(array_key_exists('otp',$responseJson))unset($responseJson['otp']);

        }


        return response()->json($responseJson);



    }

    public static $default_otc_expire=2;
    public static $UniqColumnForUser=['HookId','UniqId','ContactNo','Username','Email'];

    public function checkUserExistOrNot($data):array {
        $UniqArray=self::$UniqColumnForUser;
        $verifyData=[];
        $foundData=[];

        foreach ($UniqArray as $k){
            if(array_key_exists($k,$data)&&$data[$k]!=null)
            {
                $foundData[0][]=$k;
                $verifyData[$k]=$data[$k];
            }
        }

        if(count($verifyData)>0){
            $m=self::getUserModel();

            foreach ($verifyData as $k=>$v){

                if(!(array_key_exists(1,$foundData) && count($foundData[1]) > 0))
                {
                    $d=$m->rowGet([$k=>$v]);
                    $d2=$m->rowGet([$k=>strtolower($v)]);
                    if((count($d)>0 && in_array($k,$foundData[0])) || (count($d2)>0 && in_array($k,$foundData[0]))){
                       // unset($foundData[0][ array_key]);
                        $foundData[1][]=$k;
                    }
                }
            }

        }
        unset($foundData[0]);

        return $foundData;

    }
    public function regOtpForUser($channel,$userId,$otp):array {
       $return=[];

       $m=self::getOtpModel();
        $data=[
            'UniqId'=> \MS\Core\Helper\Comman::random(16 ,1,1),
            'UserId'=>$userId,
            'VerifyChannel'=>$channel,
            'ValidUpto'=>\Carbon::now()->addHour(self::$default_otc_expire)->toDateTimeString(),
            'OTP'=>$otp,
            'Verified'=>false
        ];
       $rowAdded=$m->rowAdd($data,['UserId']);

       if (array_key_exists('UniqId',$data))$return['UniqId']=$data['UniqId'];
       if (!$rowAdded)$return['foundOtp']=$m->rowGet(['UserId'=>$userId])[0];

       return $return;
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



    public static function getOtpModel(){
        $tableId=implode('_',[self::$modCode,'Users_OTP']);
        $c=new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',$tableId);
        return $c;

    }


    public static $c_m='O3_Users_Master';
    public static $c_d='O3_Users_Data';
    public static $c_c='O3_Users_Config';
    public static $modCode='Users4O3';

    public static function getTableRaw(){

        $methodToCall=[
            'setUpMasterUser'=>[],
            'setUpUserVerificationOTPs'=>[],
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

    private function setUpUserSettings(){
        $data=[
            'tableId'=>implode('_',[self::$modCode,'Users_settings']),
            'tableName'=>implode('_',[self::$modCode,'Users_']),
            'connection'=>self::$c_c,
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

    public function migrateById($id){
        $idExplode=explode('_',$id);
        $tableId=(count($idExplode)>0 && reset($idExplode)==self::$modCode)?
        $id:implode('_',[self::$modCode,$id]);
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
    private function setUpUserVerificationOTPs(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'Users_OTP']),
            'tableName'=>implode('_',[self::$modCode,'Users_OTP']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name' =>'UniqId','type'=>'string']);
        $m->setFields(['name' =>'UserId','type'=>'string']);
        $m->setFields(['name' =>'VerifyChannel','type'=>'string']);
        $m->setFields(['name' =>'OTP','type'=>'string',]);
        $m->setFields(['name' =>'ValidUpto','type'=>'string',]);
        $m->setFields(['name' => 'Verified', 'type' => 'boolean']);

        $m1=$m->finalReturnForTableFile();

        return array_merge($m1);
    }





}
