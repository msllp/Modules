<?php

namespace MS\Mod\B\User4O3\L;

use Exception;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\Comman;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSMail;
use MS\Core\Helper\MSPay;
use MS\Core\Helper\MSSMS;
use MS\Core\Helper\MSTableSchema;


class Users
{


    public static $userConstructData = [
        'UserId' => 'string'
    ];
    public static $type = ['website', 'app', 'google'];
    public static $default_otc_expire = 2;
    public static $UniqColumnForUser = ['HookId', 'UniqId', 'ContactNo', 'Username', 'Email'];
    public static $c_m = 'O3_Users_Master';
    public static $c_d = 'O3_Users_Data';
    public static $c_c = 'O3_Users_Config';
    public static $modCode = 'Users4O3';
    public $UserId;

    public function __construct($data = [])
    {

        $this->UserMSDB = implode('_', [self::$modCode, 'Users']);
        $this->UserPayment = implode('_', [self::$modCode, 'Payment_Ledger']);
        $this->ModNameSpace = 'MS\Mod\B\User4O3';

        if (count($data)) foreach ($data as $k => $v) if (array_key_exists($k, self::$userConstructData) && gettype($v) == self::$userConstructData[$k]) $this->$k = $v;


    }

    private function getLogedInUser(){
      //  dd(Session::get('o3User'));
        return Session::get('o3User');
    }

    private function checkUserLoginSession($apiToken){
        $logedInUser=$this->getLogedInUser();
  //      dd([$apiToken,$logedInUser['apiToken']]);
        return ($apiToken==$logedInUser['apiToken'])?true:false;
    }

    private function singOutUserToSession($data=[]):bool{
        Session::flush();
        return  true;
    }

    private function signInUserToSession($user):bool {
        $sessionData=[
            'username'=>(strpos($user['Username'],'@' ))?explode('@',$user['Username'])[0]:$user['Username'],
            'name'=> implode(' ',[$user['FirstName'],$user['LastName']]),
            'apiToken'=>$user['apiToken'],
            'email'=>$user['Email'],
            'mobile'=>$user['ContactNo'],
            'defualtCompany'=>$user['CompanyId'],
        ];
        Session::put('o3User', $sessionData);
     //   dd(Session::all());
        return true;

    }

    private function signInUserFromGoogle($data){
        $err=[];
        try{
            $user=$data->user;

            if(array_key_exists('email',$user) && array_key_exists('id',$user)){
                $c = new MSDB($this->ModNameSpace, $this->UserMSDB);
                $foundUser=$c->rowGet(['Email'=>$user['email'],'UserStatus'=>1]);
                if(count($foundUser)>0){
                    $foundUser  =reset($foundUser);

                    if($user['id']==$foundUser['HookId']){

                        $outData=[
                            'redirectUrl'=>route('O3.Panel.From.Login',['apiToken'=>$foundUser['apiToken']]),
                        ];
                        $this->signInUserToSession($foundUser);
                        //dd($outData);

                        return redirect()->route('O3.Panel.From.Login',['apiToken'=>$foundUser['apiToken']]);
                        return $this->throwData($outData);
                    }else{goto MS_ERROR;}

                }else{goto MS_ERROR;}

            }else{
                goto MS_ERROR;
            }

        }catch (Exception $e){
            MS_ERROR:
            $err[]="Error Found";
            Session::put('O3LoginByGoogle',$data);
            return redirect()->route('O3.Users.SignUp.Google.Callback.backend',['user'=>'O3LoginByGoogle']);

        }


    }

    private function signInUser($data = [], $type = '')
    {
        //dd($data);
        $m = self::getUserModel();
        $userData=[
            'Username'=>(array_key_exists('usernameForLogin',$data['input']))?$data['input']['usernameForLogin']:''
        ];
        $foundUser=$m->rowGet(['Username'=>$userData['Username']]);

        if(count($foundUser)>0){
            $foundUser=reset($foundUser);
            $decodePassword=\MS\Core\Helper\Comman::decode($foundUser['Password']);

            if($decodePassword==$data['input']['passwordForLogin']){

                $outData=[
                    'redirectUrl'=>route('O3.Panel.From.Login',['apiToken'=>$foundUser['apiToken']]),
                ];
                return $this->throwData($outData);
            }else{
                goto MSError;
            }
        }else{
            MSError:
            $er= [
                'Username/Password is incorrect.',
                'Please check Your credentials Or Contact our Customer Support.'
            ];
            return $this->throwError($er);
        }



    }


    private function signUpUserFromGoogle($data = []){
        $responseInArray=false;
        if(array_key_exists('array',$data) && $data['array']){
           $responseInArray=$data['array'];
           $data=$data['user'];
       }

        $googleResponse=$data->user;
        $googleResponse['token']=$data->token;
        $googleResponse['type']='google';
        $responseJson=[];
        $userData = [
            'UniqId' => $this->getNewUserNo(),
            'apiToken' => $this->getNewApiTokenForUser(),
            'HookType' =>1,
            'HookId' => (array_key_exists('id',$googleResponse))?$googleResponse['id'] :$this->getDefault('HookId'),
            'HookData' => $googleResponse,
            'Email' =>  (array_key_exists('email',$googleResponse))?$googleResponse['email'] :'',
            'ContactNo' => 0,
            'Username' => (array_key_exists('email',$googleResponse))?$googleResponse['email'] :'',
            'Password' => '',
            'FirstName' => (array_key_exists('given_name',$googleResponse))?$googleResponse['given_name'] :'',
            'LastName' => (array_key_exists('family_name', $googleResponse)) ? $data['family_name'] : ' ',
            'Sex' => ' ',
            'CompanyId' => 0,
            'UserTotalPaid' => 0,
            'UserTotalPending' => 0,
            'UserPlan' => $this->getDefault('UserPlan'),
            'UserValidUpto' => now(env('APP_TIMEZONE'))->addYear(1)->getTimestamp(),
            'UserProductCount' => 0,
            'UserInvoiceCount' => 0,
            'UserCompanyCount' => 0,
            'UserCompanyUserCount' => 0,
            'PaymentSuspend' => 0,
            'UserStatus' => 0,

        ];
        $c = new MSDB($this->ModNameSpace, $this->UserMSDB);
        $c->rowAdd($userData);
        $verifyData = $this->email_VerifyUserEmail($userData['Email'], implode(' ', [$userData['FirstName'], $userData['LastName']]));
        $responseJson['type'] = 'email';
        $responseJson['otp'] = $verifyData['otp'];
        $responseJson['userDetails'] = $userData;
        $responseJson['status'] = 200;
        if (array_key_exists('type', $responseJson) && array_key_exists('otp', $responseJson)) $responseJson['OTPUniqId'] = $this->regOtpForUser($responseJson['type'], $userData['UniqId'], $responseJson['otp'])['UniqId'];
        if (array_key_exists('otp', $responseJson)) unset($responseJson['otp']);
        $this->migrateById('Payment_Ledger', [$userData['UniqId']]);
        if($responseInArray)return $responseJson;
        return $this->throwData($responseJson);

    }

    private function signUpUser($data = [], $type = '')
    {


        $responseJson = [];

        if (array_key_exists('useMobile', $data) && $data['useMobile']) $data['Username'] = $data['ContactNo'];

        $checkUser = $this->checkUserExistOrNot($data);
        // dd($checkUser);
        if (array_key_exists(1, $checkUser) && count($checkUser[1]) > 0) {
            $responseJson['status'] = 409;
            $responseJson['errorMsg'] = [
                'We think you are already in our system.',
                'If you forgot your account details please mail us on help@o3erp.com'
            ];

        }
        else {
            $userData = [
                'UniqId' => $this->getNewUserNo(),
                'apiToken' => $this->getNewApiTokenForUser(),
                'HookType' => $this->getDefault('HookType'),
                'HookId' => $this->getDefault('HookId'),
                'HookData' => $this->getDefault('HookData'),
                'Email' => (array_key_exists('Email', $data)) ? $data['Email'] : ' ',
                'ContactNo' => (array_key_exists('ContactNo', $data)) ? $data['ContactNo'] : ' ',
                'Username' => (array_key_exists('Username', $data)) ? strtolower($data['Username']) : (array_key_exists('useMobile', $data) && $data['useMobile'] == true) ? $data['ContactNo'] : $data['ContactNo'],
                'Password' => (array_key_exists('Password', $data)) ? Comman::encode($data['Password']) : ' ',
                'FirstName' => (array_key_exists('FirstName', $data)) ? $data['FirstName'] : ' ',
                'LastName' => (array_key_exists('LastName', $data)) ? $data['LastName'] : ' ',
                'Sex' => (array_key_exists('Sex', $data)) ? $data['Sex'] : ' ',
                'CompanyId' => (array_key_exists('CompanyId', $data)) ? $data['CompanyId'] : 0,
                'UserTotalPaid' => 0,
                'UserTotalPending' => 0,
                'UserPlan' => (array_key_exists('Plan', $data)) ? $data['Plan'] : $this->getDefault('UserPlan'),
                'UserValidUpto' => now(env('APP_TIMEZONE'))->addYear(1)->getTimestamp(),
                'UserProductCount' => 0,
                'UserInvoiceCount' => 0,
                'UserCompanyCount' => 0,
                'UserCompanyUserCount' => 0,
                'PaymentSuspend' => 0,
                'UserStatus' => 0,

            ];
            $c = new MSDB($this->ModNameSpace, $this->UserMSDB);

            //dd($this->sms_VerifyUserNumber($userData['ContactNo']));
            if ((array_key_exists('useMobile', $data)) ? $data['useMobile'] : false) {

                $c->rowAdd($userData);
                $verifyData = $this->sms_VerifyUserNumber($userData['ContactNo']);
                $responseJson['type'] = 'sms';
                $responseJson['otp'] = $verifyData['otp'];
                $responseJson['userDetails'] = $userData;
                $responseJson['status'] = 200;
            }
            else {
                $c->rowAdd($userData);
                $verifyData = $this->email_VerifyUserEmail($userData['Email'], implode(' ', [$userData['FirstName'], $userData['LastName']]));
                $responseJson['type'] = 'email';
                $responseJson['otp'] = $verifyData['otp'];
                $responseJson['userDetails'] = $userData;
                $responseJson['status'] = 200;
            }

            if (array_key_exists('type', $responseJson) && array_key_exists('otp', $responseJson)) $responseJson['OTPUniqId'] = $this->regOtpForUser($responseJson['type'], $userData['UniqId'], $responseJson['otp'])['UniqId'];
            if (array_key_exists('otp', $responseJson)) unset($responseJson['otp']);
            $this->migrateById('Payment_Ledger', [$userData['UniqId']]);
        }


        return response()->json($responseJson);


    }
    private function verifyUser($data = [])
    {
        // dd($data);
        $responseJson = [];
        $m = self::getOtpModel();
        $u = self::getUserModel();
        $fV = $m->rowGet(['UniqId' => $data['UniqId']]);
        if (count($fV) > 0) {
            $otpRow = reset($fV);
            $getOtp = $data['input']['otp'];
            $sourceOtp = $otpRow['OTP'];

            if ($getOtp == $sourceOtp && $otpRow['Verified'] == 0) {
                $m->rowDelete(['UniqId' => $data['UniqId']]);
                $u->rowEdit(['UniqId' => $otpRow['UserId']], ['UserStatus' => 1]);
                $responseJson['userId'] = $otpRow['UserId'];
                $responseJson['otpVerified'] = true;
                $responseJson['status'] = 200;
            } else {
                //  $m->rowEdit(['UniqId'=>$data['UniqId']],['Verified'=>$otpRow['Verified']++]);
                $responseJson['otpVerified'] = false;
                $responseJson['status'] = 409;
                $responseJson['errorMsg'] = [
                    'Please enter valid OTP !',
                ];
            }

        }


        return response()->json($responseJson);
    }
    private function resendVerifyUser($data = [])
    {
        // dd($data);
        $responseJson = [];
        $m = self::getOtpModel();
        $u = self::getUserModel();

        $fV = $m->rowGet(['UniqId' => $data['UniqId']]);

        if (count($fV) > 0) {
            $otpRow = reset($fV);
            $fU = $u->rowGet(['UniqId' => $otpRow['UserId']]);
            $userData = reset($fU);

            $sourceOtp = $otpRow['OTP'];

            if ($otpRow['Verified'] == 0) {

                switch ($otpRow['VerifyChannel']) {
                    case 'sms':
                        $this->sms_VerifyUserNumber($userData['ContactNo'], 1, $sourceOtp);
                        break;
                }

                $responseJson['status'] = 200;
            } else {

                $responseJson['status'] = 409;
                $responseJson['errorMsg'] = [
                    'Resend OTP Not Successfully.',
                ];
            }

            return response()->json($responseJson);

        }


        return response()->json($responseJson);
    }
    private function initiatePaymentForUser($data)
    {


        $UserId = (array_key_exists('UserId', $data)) ? $data['UserId'] : 0;
        $planId = (array_key_exists('input', $data) && array_key_exists('planId', $data['input'])) ? $data['input']['planId'] : 0;
        $buyFor = (array_key_exists('input', $data) && array_key_exists('buyFor', $data['input'])) ? $data['input']['buyFor'] : 0;


        $u = self::getUserModel();
        $responseJson = [];
        $userData = $u->rowGet(['UniqId' => $UserId]);

        // dd($u);
        $p = collect(Plans::getAllPlanS());

        $p1 = $p->where('UniqId', '=', $planId);
        $invoice = [];

        //   dd($planId);
        $planData = ($p1->count() > 0) ? $p1->first() : [];
//dd($data);

        if (count($userData) > 0 && count($planData) > 0) {
            $userData = reset($userData);
            $up = self::getUserPaymentModel($UserId);

            switch ($buyFor) {
                case 1:
                    //1Month
                    $invoice['totalWithOutTax'] = $planData['PerMonth'];
                    $invoice['buyFor'] = '1 Month';
                    break;
                case 2:
                    //6Month
                    $invoice['totalWithOutTax'] = ($planData['PerMonth'] - (($planData['PerMonthFor6Month'] * $planData['PerMonth']) / 100)) * 6;
                    $invoice['buyFor'] = '6 Months';
                    break;
                case 3:
                    //1yr
                    $invoice['totalWithOutTax'] = ($planData['PerMonth'] - (($planData['PerMonthFor1Year'] * $planData['PerMonth']) / 100)) * 12;
                    $invoice['buyFor'] = '1 Year';
                    break;
                case 4:
                    //2yr
                    $invoice['buyFor'] = '2 Year';
                    $invoice['totalWithOutTax'] = ($planData['PerMonth'] - (($planData['PerMonthFor2Year'] * $planData['PerMonth']) / 100)) * 24;
                    break;
            }

            $invoice['totaTax'] = $invoice['totalWithOutTax'] * 0.18;
            $invoice['totalWithTax'] = $invoice['totaTax'] + $invoice['totalWithOutTax'];
            $invoice['UniqId'] = implode('_', [$UserId, Comman::random('8'),$buyFor,$planId]);
            $invoice['type'] = 'online';
            $invoice['paymentCharge'] = ($invoice['totalWithTax'] * 2.75) / 100;
            $invoice['PaymentTaxDetails'] = collect([['name' => 'GST', 'rate' => '18', 'total' => $invoice['totaTax']]])->toJson();

            // dd($invoice);


            $paymentData = [
                'description' => implode(' ', [$planData['PlanName'], 'for', $invoice['buyFor'], 'of O3 ERP']),
                //'customerEmail'=>$userData['Email'],
                //'customerNumber'=>$userData['ContactNo'],
                'invoiceId' => $invoice['UniqId'],
                // 'customerId'=>$userData['UniqId']
            ];


            $am = round($invoice['totalWithTax'] + $invoice['paymentCharge']);
            $paymentResponse = MSPay::makePaymentLink((int)$am, $paymentData);

            //     dd($paymentResponse);
            $User_Ledger_Data = [
                'UniqId' => $paymentResponse['invoiceid'],
                'PaymentId' => $paymentResponse['id'],
                'PaymentType' => $invoice['type'],
                'PaymentStatus' => 0,
                'PaymentAmount' => $invoice['totalWithOutTax'],
                'PaymentCharges' => $invoice['paymentCharge'],
                'PaymentTax' => $invoice['totaTax'],
                'PaymentTaxDetails' => $invoice['PaymentTaxDetails'],

            ];
            $up->rowAdd($User_Ledger_Data);
            $responseJson['status'] = 200;
            $responseJson['paymentDetails'] = [
                'invoiceId' => $paymentResponse['invoiceid'],
                'orderId' => $paymentResponse['id'],
                'amount' => $paymentResponse['amount'],
                'userId' => $UserId
            ];
            // $responseJson['invoiceDetails']=$invoice;

        } else {
            $responseJson['status'] = 409;
            $responseJson['errorMsg'] = [
                'Bug in initiatePaymentForUser line 119 ',

            ];

        }

        return response()->json($responseJson);
    }
    private function updatePaymentStatus($data)
    {
        $orderId = $data['OrderId'];
        $pD = MSPay::getPaymentStatus($orderId);
        $pdExplode=explode('_',$pD['LadgerId']);
        $planId=end($pdExplode);
        $userId=$pdExplode[0];
        $pM = self::getUserPaymentModel($pD['UserId']);
        $uM=self::getUserModel();
        if ($pD['status']) {
            $pM->rowEdit(['UniqId' => $pD['LadgerId']], ['PaymentStatus' => 1]);
            $uUpdateArray=[

                'UserPlan'=>$planId,
                'PaymentSuspend'=>0

            ];

            $uM->rowEdit(['UniqId'=>$userId],[]);
        }

        $pMd = $pM->rowGet(['UniqId' => $pD['LadgerId']]);

        $invoice = reset($pMd);

        $invoice['PaymentAmount'] = $pD['amount'] - ($invoice['PaymentCharges'] + $invoice ['PaymentTax']);
        $hidden = ['id', 'UniqId', 'PaymentTaxDetails'];
        $int = ['PaymentAmount', 'PaymentCharges', 'PaymentTax'];
        foreach ($hidden as $v) {
            unset($invoice[$v]);
        }
        foreach ($int as $v) {
            $invoice[$v] = (int)$invoice[$v];
        }
        $d = [
            'order_id' => $orderId,
            'invoiceDetails' => $invoice
        ];
        return response()->json($d);
    }

    private function editUserProfile($data = [], $type = '')
    {
    }


    private function getUserByApiToken($apiToken)
    {

        $m = self::getUserModel();
        $u = $m->rowGet(['apiToken' => $apiToken]);
        if (count($u) > 0) {
            $d = $m->rowGet(['apiToken' => $apiToken]);
            $e = reset($d);
            $h = ['apiToken', 'Password', 'created_at', 'updated_at', 'Hook'];
            $e = $this->unSet($h, $e);
            return $e;

        }
        return [];


    }







    private function upgradeUser($data = [], $type = '')
    {
    }




    public function viewUserProfile($data = [], $type = '')
    {

        $user = $this->getLiveUser();
        $user['plan'] = (array_key_exists('Username', $user)) ? $this->getUserPlan($user['Username']) : $this->getUserPlan($user['email']);
        return $user;

    }
    public function getLiveUser()
    {

        $user=$this->getLogedInUser();
        return [
            "Username" => $user['username'],
            "email" => $user['email'],
            "fname" =>explode(' ',$user['name'])[0],
            "lname" => explode(' ',$user['name'])[1],
            "name"=>$user['name'],
            "phone" => $user['mobile'],
            "sex" => "male",
            'currentCompany'=>$user['defualtCompany']
        ];

    }
    public function getUserPlan($userId)
    {

        $plans = Plans::getAllPlanS();

        //   dd(collect($plans)->where('UniqId',"=",'111')->first());

        $plan = collect($plans)->where('UniqId', "=", '111')->first();


        return [
            'planId' => $plan['UniqId'],
            'name' => $plan['PlanName'],
            'limits' => [

                'products' => [
                    'vName' => 'Products',
                    'limit' => $plan['Product'],
                    'usage' => 1,
                ],
                'invoice' => [
                    'vName' => 'Invoice',
                    'limit' => $plan['Invoice'],
                    'usage' => 1,
                ],
                'purchase' => [
                    'vName' => 'Purchase',
                    'limit' => $plan['Purchase'],
                    'usage' => 1,
                ],
                'company' => [
                    'vName' => 'Company',
                    'limit' => $plan['Company'],
                    'usage' => 1,
                ]
                ,
                'user' => [
                    'vName' => 'Users/Company',
                    'limit' => $plan['PerCompanyUser'],
                    'usage' => 1,
                ],

                'validupto' => [
                    'vName' => 'Valid upto',
                    'limit' => now()->format('Y'),
                    'usage' => now()->format('d/m'),
                ]

            ]
        ];
    }
    public function migrate()
    {
        $tableId = implode('_', [self::$modCode, 'Users']);

        $c = new MSDB('MS\Mod\B\User4O3', $tableId);

        //  dd($c->migrate());
        return $c->migrate();

    }
    public function migrateById($id, $data = [])
    {
        $idExplode = explode('_', $id);
        $tableId = (count($idExplode) > 0 && reset($idExplode) == self::$modCode) ?
            $id : implode('_', array_merge([self::$modCode, $id,]));

        $c = new MSDB('MS\Mod\B\User4O3', $tableId, $data);
        // dd($c);
        //  dd($c->migrate());
        return $c->migrate();
    }


    private function makeArrayForDBEntryForUserTable($data): array
    {
    }
    private function makeArrayForDBEntryTableConnection($data): array
    {
    }

    private function MigrateDBForUser($data): array
    {
    }

    private function setUpMasterUser()
    {

        $data = [
            'tableId' => implode('_', [self::$modCode, 'Users']),
            'tableName' => implode('_', [self::$modCode, 'Users']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'Username', 'type' => 'string']);
        $m->setFields(['name' => 'Password', 'type' => 'string']);
        $m->setFields(['name' => 'apiToken', 'type' => 'string']);
        $m->setFields(['name' => 'HookType', 'type' => 'string']);
        $m->setFields(['name' => 'HookId', 'type' => 'string',]);
        $m->setFields(['name' => 'HookData', 'type' => 'string',]);
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

        $m->setFields(['name'=>'usernameForLogin','vName'=>Lang::get('UI.panelLoginId'),'dbOff'=>true,'input'=>'text']);
        $m->setFields(['name'=>'passwordForLogin','vName'=>Lang::get('UI.panelLoginPassword'),'dbOff'=>true,'input'=>'password']);

        $signInGroup='signInOwner';
        $m->addGroup($signInGroup)->addField($signInGroup,['usernameForLogin','passwordForLogin']);


        $loginId='ForOwner';

        $m->addAction('signin',[
            "btnColor"=>"bg-green",
            "route"=>"O3.Users.Login.Form.Post",
            "btnIcon"=>"fi2 flaticon-unlocked",
            'btnText'=>"Sign in"
        ]);

        $m

            ->addForm($signInGroup)
            ->addGroup4Form($signInGroup,[$signInGroup])
            ->addTitle4Form($signInGroup,Lang::get('UI.loginForOwner'))
            ->addAction4Form($signInGroup,['signin'])
        ;



        $m
            ->addLogin($loginId)
            ->addGroup4Login($loginId,[$signInGroup])
            ->addTitle4Login($loginId,Lang::get('UI.loginForOwner'))
            ->setPost4Login($loginId,'O3.Users.Login.Form.Post');



      //     dd($m);
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setUpUserSettings()
    {
        $data = [
            'tableId' => implode('_', [self::$modCode, 'Users_settings']),
            'tableName' => implode('_', [self::$modCode, 'Users_']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'Username', 'type' => 'string']);
        $m->setFields(['name' => 'Password', 'type' => 'string']);
        $m->setFields(['name' => 'apiToken', 'type' => 'string']);
        $m->setFields(['name' => 'HookType', 'type' => 'string']);
        $m->setFields(['name' => 'HookId', 'type' => 'string',]);
        $m->setFields(['name' => 'HookData', 'type' => 'string',]);
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

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setUpUserPayment($userId = [])
    {

        //  dd($userId);
        $userId2 = implode('', $userId);
        //

        $data = [
            'tableId' => implode('_', [self::$modCode, 'Payment_Ledger']),
            'tableName' => (count($userId) > 0) ? implode('_', [self::$modCode, 'Payment_Ledger', $userId2]) : implode('_', [self::$modCode, 'Payment_Ledger']),
            'connection' => self::$c_d,
        ];


        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentId', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentType', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentStatus', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentAmount', 'type' => 'string',]);
        $m->setFields(['name' => 'PaymentCharges', 'type' => 'string',]);
        $m->setFields(['name' => 'PaymentTax', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentTaxDetails', 'type' => 'string',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setUpUserVerificationOTPs()
    {

        $data = [
            'tableId' => implode('_', [self::$modCode, 'Users_OTP']),
            'tableName' => implode('_', [self::$modCode, 'Users_OTP']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'UserId', 'type' => 'string']);
        $m->setFields(['name' => 'VerifyChannel', 'type' => 'string']);
        $m->setFields(['name' => 'OTP', 'type' => 'string',]);
        $m->setFields(['name' => 'ValidUpto', 'type' => 'string',]);
        $m->setFields(['name' => 'Verified', 'type' => 'boolean']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function checkUserExistOrNot($data): array
    {
        $UniqArray = self::$UniqColumnForUser;
        $verifyData = [];
        $foundData = [];

        foreach ($UniqArray as $k) {
            if (array_key_exists($k, $data) && $data[$k] != null) {
                $foundData[0][] = $k;
                $verifyData[$k] = $data[$k];
            }
        }

        if (count($verifyData) > 0) {
            $m = self::getUserModel();

            foreach ($verifyData as $k => $v) {

                if (!(array_key_exists(1, $foundData) && count($foundData[1]) > 0)) {
                    $d = $m->rowGet([$k => $v]);
                    $d2 = $m->rowGet([$k => strtolower($v)]);
                    if ((count($d) > 0 && in_array($k, $foundData[0])) || (count($d2) > 0 && in_array($k, $foundData[0]))) {
                        // unset($foundData[0][ array_key]);
                        $foundData[1][] = $k;
                    }
                }
            }

        }
        unset($foundData[0]);

        return $foundData;

    }
    private function getNewUserNo()
    {
        $c = new MSDB($this->ModNameSpace, $this->UserMSDB);
        $code = Comman::random(16, 1, 1);
        $d = $c->getModel();
        while ($d->where('UniqId', $code)->get()->count() > 1) {
            $code = Comman::random(16, 1, 1);
        }
        return $code;
    }
    private function getNewApiTokenForUser()
    {
        $c = new MSDB($this->ModNameSpace, $this->UserMSDB);
        $code = Comman::random(188, 4, 1);
        $d = $c->getModel();
        while ($d->where('apiToken', $code)->get()->count() > 1) {
            $code = Comman::random(16, 1, 1);
        }
        return $code;
    }
    private function getDefault($id)
    {
        $d = [
            'HookType' => 'MS',
            'HookId' => 0,
            'HookData' => collect([])->toJson(),
            'UserPlan' => '111'
        ];
        if (array_key_exists($id, $d)) {
            return $d[$id];
        } else {
            return '';
        }
    }
    private function sms_VerifyUserNumber($to, $try = 0, $otp = null, $name = 'OTPforUser')
    {
        $data = [
            'name' => $name,
            'toNumber' => $to,
            'otp' => ($otp == null) ? Comman::random(5) : $otp
        ];

        if ($try > 0) $data['channel'] = 1;
        $u = [];
        // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {

            $u = (!array_key_exists('channel', $data)) ?
                MSSMS::SendSMS($to, ['strData' => ['OTP' => $data['otp']], 'templateId' => $data['name']]) : MSSMS::SendSMS($to, ['strData' => ['OTP' => $data['otp']], 'templateId' => $data['name'], 'channel' => $data['channel']]);

        } catch (Exception $e) {

            return [];
        }


        return $data;
    }
    private function email_VerifyUserEmail($to, $name)
    {
        $data = [
            'mailSubject' => 'Email Verification for O3 ERP Account Opening',
            'name' => $name,
            //'toEmail'=>'emails@domain.com',
            'otp' => Comman::random(5)
        ];


        // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {
            $m = MSMail::SendMail($to, 'MS::core.layouts.Email.EmailVerify', $data);

        } catch (Exception $e) {
            return [];
        }
        return $data;
    }
    private function regOtpForUser($channel, $userId, $otp): array
    {
        $return = [];

        $m = self::getOtpModel();
        $data = [
            'UniqId' => Comman::random(16, 1, 1),
            'UserId' => $userId,
            'VerifyChannel' => $channel,
            'ValidUpto' => \Carbon::now()->addHour(self::$default_otc_expire)->toDateTimeString(),
            'OTP' => $otp,
            'Verified' => false
        ];
        $rowAdded = $m->rowAdd($data, ['UserId']);

        if (array_key_exists('UniqId', $data)) $return['UniqId'] = $data['UniqId'];
        if (!$rowAdded) $return['foundOtp'] = $m->rowGet(['UserId' => $userId])[0];

        return $return;
    }
    private function unSet($column, $d)
    {

        foreach ($column as $name) {
            if (array_key_exists($name, $d)) unset($d[$name]);
        }
        return $d;
    }


    public static function getTableRaw()
    {

        $methodToCall = [
            'setUpMasterUser' => [],
            'setUpUserVerificationOTPs' => [],
            'setUpUserPayment' => []
        ];
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method)) $d = array_merge($d, $c->$method($data));
        return $d;
        dd($d);


    }

    public static function getUserPaymentModel($userId)
    {
        $c = new self();
        return $c = new MSDB($c->ModNameSpace, $c->UserPayment, [$userId]);
    }

    public static function getOtpModel()
    {
        $tableId = implode('_', [self::$modCode, 'Users_OTP']);
        $c = new MSDB('MS\Mod\B\User4O3', $tableId);
        return $c;

    }

    public static function getUserModel()
    {
        $c = new self();
        return $c = new MSDB($c->ModNameSpace, $c->UserMSDB);
    }

    public static function fromController(array $methods)
    {
        $c = new self();


        if (count($methods) > 1 && count($methods) != 0) {

        } elseif (count($methods) != 0) {

            foreach ($methods as $method) {
                if (array_key_exists('method', $method) && array_key_exists('data', $method)) {
                    //        dd(call_user_func([$c,$method['method']],$method['data']));

                    return call_user_func([$c, $method['method']], $method['data']);
                }
            }

        }


    }

    private function throwData(array $data){
        $err=[
            'msData'=>$data
        ];

        return response()->json($err,200);
    }
    private function throwError(array $data){

        $err=[
            'errors'=>$data
        ];

        return response()->json($err,419);
    }


}
