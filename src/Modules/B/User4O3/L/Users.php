<?php

namespace MS\Mod\B\User4O3\L;

use Carbon\Carbon;
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
        $this->UserNotification=implode('_', [self::$modCode, 'Users_Notification']);
        $this->UserAction=implode('_', [self::$modCode, 'Users_Action']);


        $this->ModCode=self::$modCode;

        if (count($data)) foreach ($data as $k => $v) if (array_key_exists($k, self::$userConstructData) && gettype($v) == self::$userConstructData[$k]) $this->$k = $v;


    }

    private function upgradeUserPage(){
        //dd($this->getLiveUser());
        $foundUser=$this->getLiveUser();
        $allPlans=Plans::getAllPlans();
        $userPlan=$this->getUserPlan($foundUser['id']);

     //   dd();
        $data=[
            'UserPlans'=>$userPlan,
            'AllPlans'=>$allPlans
        ];

   //     dd($data);

        return view('MOD::B.User4O3.V.upgradeUser')->with('data',$data);
    }
    private function signByToken($data){
        $apiToken=$data['apiToken'];
        $founUser=$this->getUserByApiToken($apiToken);
        $founUser['apiToken']=$data['apiToken'];
        $this->signInUserToSession($founUser);
        return ['loggedIn'=>true];
    }
    private function explodeNotifyId($str):array{
        $rD=[];
        $exStr=explode('_',$str);
        if(count($exStr)!= 2)return $rd;
        $rD=[
            'userId'=>reset($exStr),
            'notficationId'=>end($exStr)
        ];
        return $rD;

    }

    private function getNotificationByNotifyId($data){
       //s dd($id);
        $er=[
        '101'=>['Notification Not Found'],
        '102'=>['Notification View Action Not Found']
        ];
        $notifyId=(array_key_exists('notifyId',$data))? \MS\Core\Helper\Comman::decodeLimit($data['notifyId']):'';
        $data=$this->explodeNotifyId($notifyId);

        $m=self::getUserNotificationModel($data['userId']);

        $notification=$m->rowGet(['UniqId'=>$notifyId]);
        $notification=(count($notification)>0)?reset($notification):[];
        if(count($notification)<1)return $this->throwError($er['101']);

        $redirectData=json_decode($notification['NotifyAction'],true);
        if(!array_key_exists('view',$redirectData))return $this->throwError($er['102']);
        return $this->redirectForNotification($redirectData['view']);
        dd($redirectData);
    }

    private function redirectForNotification($viewData){
        $er=[
            '101'=>['Not valid url']
        ];
       //    dd($viewData);

        if(array_key_exists('url',$viewData)  )
        {
            $url=$viewData['url'];
            if(!strpos($url,'://')){

                if(array_key_exists('para',$viewData)){
                    $url=route($url,$viewData['para']);
                }else{
                    $url=route($url);
                }

            }

            $url=str_replace('http://','https://',$url);

            return redirect($url);


        }
        return $this->throwError($er['101']);

    }

    private function getNotificationByApiToken($data){

        //dd(\MS\Core\Helper\Comman::decode($data['apiToken']));

        $apiToken=\MS\Core\Helper\Comman::decodeLimit($data['apiToken']);
     //   $apiToken='';
      //  dd($apiToken);
        if(strlen($apiToken)==0)goto MS_Error;
        $foundUser=$this->getUserByApiToken($apiToken);

        if(array_key_exists('UniqId', $foundUser)){

            $userId=$foundUser['UniqId'];
            $m=$this->getUserNotificationModel($userId);
            $d=$m->rowAll();
            $mapFunction=function ($ar){
                global $data;
              if(array_key_exists('NotifyAction',$ar))$ar['NotifyAction']=json_decode($ar['NotifyAction'],true);
              if(array_key_exists('NotifyData',$ar))$ar['NotifyData']=json_decode($ar['NotifyData'],true);
              if(array_key_exists('NotifyAction',$ar) && count($ar)>0){
                  foreach ($ar['NotifyAction'] as $ac=>$acD){

                      if(array_key_exists('url',$acD) && !strpos($acD['url'],'://') )
                      {
                          $ar['NotifyAction'][$ac]['url']=route($acD['url']);
                      }

                      if($ac=='view'){
                          $ar['NotifyAction'][$ac]['url']=route('O3.Users.Notification.get',['notifyId'=>\MS\Core\Helper\Comman::encodeLimit($ar['UniqId'])]);
                         // dd($ar);
                      }

                  }
              }
              return $ar;
            };
            $d=array_map($mapFunction,$d);
           // dd(array_map($mapFunction,$d));
            return $this->throwData($d);
        }else{
            MS_Error:
            $er=[
                'User Not Found'
            ];
            return $this->throwError($er);
        }


    }

    public function addNotificaiton($data,$userId=null){
      //  dd($this->getLiveUser());

        $foundUser=$this->getLiveUser();
        $userId=($userId==null && array_key_exists('id',$foundUser))?$foundUser['id']:$userId;

        if(!array_key_exists('UniqId',$data) )$data['UniqId']=\MS\Core\Helper\Comman::random(10,4,1,[$userId]);

        $m=self::getUserNotificationModel($userId);

        dd($m->rowAdd($data));
        dd($m);


    }

    private function getCallDataForReceiver($data){

        $data['callId']=\MS\Core\Helper\Comman::decode( $data['callId']);
        $data2=['from'=>$data['fromUser'],'to'=>$data['toUser']];
        $users=$this->getUserForCallFunction($data2,true);

        $m1=self::getUserCallLogModel($users['from']['UniqId']);
        $foundCall=$m1->rowGet(['UniqId'=>$data['callId']]);
        if (count($foundCall)==0)return$this->throwError(['No Call Details Found']);
        $foundCall=reset($foundCall);
        $vCallData=$foundCall['CallOfferData'];


        $fData=[
            'from'=>[
                'token'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken']),
                'id'=>$users['from']['UniqId'],
                'name'=>implode(' ',[$users['from']['FirstName'],$users['from']['LastName'],])
                 ],
            'vCallData'=>json_decode($vCallData,true),
            'callId'=>$data['callId']
            ];
        return $this->throwData($fData);

        //$m2=self::getUserCallLogModel($users['to']['UniqId']);

    }
    private function getCallDataForCaller($data){

        $data['callId']=\MS\Core\Helper\Comman::decode( $data['callId']);
        $data2=['from'=>$data['fromUser'],'to'=>$data['toUser']];
        $users=$this->getUserForCallFunction($data2,true);

        $m1=self::getUserCallLogModel($users['from']['UniqId']);
        $foundCall=$m1->rowGet(['UniqId'=>$data['callId']]);
        if (count($foundCall)==0)return$this->throwError(['No Call Details Found']);
        $foundCall=reset($foundCall);
        $vCallData=$foundCall['CallAnswerData'];


        $fData=[
            'from'=>[
                'token'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken']),
                'id'=>$users['from']['UniqId'],
                'name'=>implode(' ',[$users['from']['FirstName'],$users['from']['LastName'],])
                 ],
            'vCallData'=>json_decode($vCallData,true),
            'callId'=>$data['callId']
            ];
        return $this->throwData($fData);
 }

    private function getAllowedUserToCall($data){
        $json=(array_key_exists('json',$data))?$data['json']:false;
        if(array_key_exists('apiToken',$data)){

           // dd($data);

            $user=self::getUserModel();
            $foundUser=$user->rowAll();

            $mapFunction=function ($a){
                return [
                  'name'=>implode(' ',[$a['FirstName'],$a['LastName']]),
                  'id'=>$a['UniqId'],
                  'apiToken'=>\MS\Core\Helper\Comman::encode($a['apiToken']),
                  'CompanyId'=>$a['CompanyId']
              ];
            };
            if($json)return array_map($mapFunction,$foundUser);
            return $this->throwData(array_map($mapFunction,$foundUser));

        }elseif(array_key_exists('UniqId',$data)){
            $user=self::getUserModel();
            $foundUser=$user->rowAll();

            $mapFunction=function ($a){
                return [
                    'name'=>implode(' ',[$a['FirstName'],$a['LastName']]),
                    'id'=>$a['UniqId'],
                    'apiToken'=>\MS\Core\Helper\Comman::encode($a['apiToken']),
                    'CompanyId'=>$a['CompanyId']
                ];
            };
            if($json)return array_map($mapFunction,$foundUser);

        }

        else{
            $er=['api/id token not found in request'];
            return $this->throwError($er);
        }

    }

    private function triggerPusherNotify($data){
        $user=$data['userId'];
        $app_id = env('PUSHER_APP_ID');
        $app_key = env('PUSHER_APP_KEY');
        $app_secret = env('PUSHER_APP_SECRET');


        $pusher = new \Pusher\Pusher(
            $app_key,
            $app_secret,
            $app_id,
            array(
                'cluster' => 'ap2',
                'useTLS' => true
            )
        );

        $channelName=implode('_',['private',$user]);
   //     dd($data);
        try {

         //  dd($pusher->get_channel_info('o3erp'));
            $pusher->trigger( 'o3erp',$channelName, $data['data'] );
        }catch (Exception $e){
            dd($e);
            return false;
        }
        return true;
    }

    private function getUserForCallFunction($data,$all=false){
        $final=[];
        $from=\MS\Core\Helper\Comman::decode($data['from']);
        $to=\MS\Core\Helper\Comman::decode($data['to']);


        $callUser=$this->getUserByApiToken($from);
        $rcvUser=$this->getUserByApiToken($to);

        if($all){
            $final['from']=$callUser;
            $final['from']['apiToken']=$from;
            $final['to']=$rcvUser;
            $final['to']['apiToken']=$to;
            return  $final;
        }
        $final['from']=$callUser['UniqId'];
        $final['from']['apiToken']=$from;
        $final['to']=$rcvUser['UniqId'];
        $final['to']['apiToken']=$to;

        return $final;
    }

    private function sendCallRcvToUser($data){

        //dd($data);

        $callId=$data['vCallData']['callId'];
        $vCallData=(array_key_exists('vCallData',$data))?$data['vCallData']:[];
        $users=$this->getUserForCallFunction($data,true);

        $id=['UniqId'=>$callId];

        $dbInputFrom=[
            'CallAnswerData'=>collect($vCallData['vCallData'])->toJson(),
        ];
        $m=self::getUserCallLogModel($users['from']['UniqId']);
        $m2=self::getUserCallLogModel($users['to']['UniqId']);
        $m->rowEdit($id,$dbInputFrom);
        $m2->rowEdit($id,$dbInputFrom);


        $data=[
            'callId'=>$callId,
            'type'=>'call',
            'subtype'=>'video',
            'state'=>'outgoing',
            'dataLink'=>route('O3.Users.Video.call.receive.Data',['UniqId'=>\MS\Core\Helper\Comman::encode($callId),'From'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken']),'To'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken'])])
        ];

        $reData=[
            'callId'=>$callId,
            'type'=>'video',
            'state'=>'outgoing',
            'to'=>[
                'name'=>implode(' ',[$users['to']['FirstName'],$users['to']['LastName'] ]),
                'id'=>$users['to']['UniqId'],
                'apiToken'=>$users['to']['apiToken'],
            ]

        ];
        $this->triggerPusherNotify( ['userId'=>$users['to']['UniqId'] ,'data'=>$data]);

        return $this->throwData($reData);




    }
    private function sendCallToUser($data){

        $users=$this->getUserForCallFunction($data,true);
        $data=[
            'type'=>'call',
            'subtype'=>'video',
            'state'=>'incoming',
            'from'=>
                [
                    'token'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken']),
                    'id'=>$users['from']['UniqId'],
                    'name'=>implode(' ',[$users['from']['FirstName'],$users['from']['LastName'],])
                ],
            'vCallData'=>(array_key_exists('vCallData',$data))?$data['vCallData']:[]

        ];
        $uniqId=\MS\Core\Helper\Comman::random(10,2);

        $dbInputFrom=[
            'UniqId'=>$uniqId,
            'CallFor'=>$users['to']['UniqId'],
            'CallFrom'=>$users['from']['UniqId'],
            'CallOfferData'=>(array_key_exists('vCallData',$data))? collect($data['vCallData'])->toJson() :'{}',
            'CallAnswerData'=>[],
            'CallType'=>'video',
            'CallConnected'=>0,
            'CallDisconnected'=>1,
            'UserOffline'=>0,
            'CallStatus'=>0
        ];
        $m=self::getUserCallLogModel($users['from']['UniqId']);
        $m->rowAdd($dbInputFrom);

        $dbInputTo=[
            'UniqId'=>$uniqId,
            'CallFor'=>$users['to']['UniqId'],
            'CallFrom'=>$users['from']['UniqId'],
            'CallOfferData'=>(array_key_exists('vCallData',$data))? collect($data['vCallData'])->toJson() :'{}',
            'CallAnswerData'=>'{}',
            'CallType'=>'video',
            'CallConnected'=>0,
            'CallDisconnected'=>1,
            'UserOffline'=>0,
            'CallStatus'=>0
        ];

        $m=self::getUserCallLogModel($users['to']['UniqId']);
        $m->rowAdd($dbInputTo);



        $data=[
            'type'=>'call',
            'subtype'=>'video',
            'state'=>'incoming',
            'dataLink'=>route('O3.Users.Video.call.send.Data',['UniqId'=>\MS\Core\Helper\Comman::encode($uniqId),'From'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken']),'To'=>\MS\Core\Helper\Comman::encode($users['from']['apiToken'])])
        ];




        $this->triggerPusherNotify( ['userId'=>$users['to']['UniqId'] ,'data'=>$data]);

        $reData=[
            'callId'=>$uniqId,
            'type'=>'video',
            'state'=>'outgoing',
            'to'=>[
                'name'=>implode(' ',[$users['to']['FirstName'],$users['to']['LastName'] ]),
                'id'=>$users['to']['UniqId'],
                'apiToken'=>$users['to']['apiToken'],
            ]

        ];

        return $this->throwData($reData);

    }

    public function setCompanyNAddCount($companyId){
        $er=[
            '601'=>'company not updated',
            '601'=>'User Not Found'
        ];
        $c=self::getUserModel();
        $outPut=false;
        $foundUser=$this->getLiveUser();
        $fromDB=$c->rowGet(['UniqId'=>$foundUser['id']]);
        if(count($fromDB)>0){$fromDB=reset($fromDB);}else{
            if (!$outPut)return false;
        }
        $lastCompanyCount=$fromDB['UserCompanyCount']+1;

        $changeData=['CompanyId'=>$companyId,'UserCompanyCount'=>$lastCompanyCount];
        //dd($changeData);
        $this->updateSessionUser('defualtCompany',$companyId);
        $outData=$c->rowEdit(['UniqId'=>$foundUser['id']],$changeData);
        return $outData ;

    }

    public function checkUserLimits($type){
        $foundUser=$this->getLiveUser();
        $plan=$this->getUserPlan($foundUser['id']);
        switch ($type){
            case 'company':
                if(array_key_exists($type,$plan['limits'])){
                    $limit=$plan['limits'][$type];
                    return ($limit['limit']>$limit['usage']);
                }
                break;
        }

        return false;
        dd($type);

    }

    public function setCompany($companyId){
        $er=[
            '601'=>'company not updated'
        ];
        $c=self::getUserModel();
        $outPut=false;
        $foundUser=$this->getLiveUser();

        if(gettype($companyId)=='array') {
            $companyId=$companyId['companyId'];
            $outPut=true;

        }
        $changeData=['CompanyId'=>$companyId];

        $this->updateSessionUser('defualtCompany',$companyId);
        $outData=$c->rowEdit(['UniqId'=>$foundUser['id']],$changeData);
        if($outPut)return ($outData)? $this->throwData(['status'=>true]):$this->throwError($er['601']);
        return $outData ;

    }

    private function getLogedInUser():array{
      //  dd(Session::get('o3User'));

        return (Session::get('o3User')!=null)? Session::get('o3User'):[];
    }

    private function checkUserLoginSession($apiToken=null){
        $logedInUser=$this->getLogedInUser();
        if($apiToken==null && array_key_exists('apiToken',$logedInUser))$apiToken=$logedInUser['apiToken'];
        //dd($apiToken);
        //dd([$apiToken,$logedInUser['apiToken']]);
        return (array_key_exists('apiToken',$logedInUser) && $apiToken==$logedInUser['apiToken'])?true:false;
    }

    private function singOutUserToSession($data=[]):bool{
        Session::flush();
        return  true;
    }

    private function updateSessionUser($key,$val){
        $foundUser=$this->getLogedInUser();
        return (array_key_exists($key,$foundUser))? $foundUser[$key]=$val: false;
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

                $this->signInUserToSession($foundUser);
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
            'UserPurchaseCount' => 0,
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
        $this->migrateForUserWhenSignup($userData['UniqId']);
        if($responseInArray)return $responseJson;
        return $this->throwData($responseJson);

    }

    private function signUpUser($data = [], $type = '')
    {

       // dd($data);

        $responseJson = [];

        if (array_key_exists('useMobile', $data) && $data['useMobile']) $data['Username'] = $data['ContactNo'];

        $checkUser = $this->checkUserExistOrNot($data);
        $checkUser=[];
        if (array_key_exists(1, $checkUser) && count($checkUser[1]) > 0) {
            $responseJson['status'] = 409;
            $responseJson['errorMsg'] = [
                'We think you are already in our system.',
                'If you forgot your account details please mail us on help@o3erp.com'
            ];
            return response()->json($responseJson,$responseJson['status']);
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
                'Username' =>(array_key_exists('Username', $data))? strtolower($data['Username']) :'',
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
                'UserPurchaseCount' => 0,

                'UserCompanyCount' => 0,
                'UserCompanyUserCount' => 0,
                'PaymentSuspend' => 0,
                'UserStatus' => 0,

            ];
            $c = new MSDB($this->ModNameSpace, $this->UserMSDB);

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
            $this->migrateForUserWhenSignup($userData['UniqId']);

        }


        return response()->json($responseJson);


    }

    private function migrateForUserWhenSignup($userId){
        $this->migrateById('Payment_Ledger', [$userId]);
    //    $this->migrateById('Call_Log', [$userId]);
        $this->migrateById($this->UserNotification, [$userId]);
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


        if (count($fV) > 0 )  {
            $otpRow = reset($fV);
            $fU = $u->rowGet(['UniqId' => $otpRow['UserId']]);
            $userData = reset($fU);

            $sourceOtp = $otpRow['OTP'];

            if ($otpRow['Verified'] == 0) {

                switch ($otpRow['VerifyChannel']) {
                    case 'sms':
                        $this->sms_VerifyUserNumber($userData['ContactNo'], 1, $sourceOtp);
                        break;
                    case 'email':
                        $this->email_VerifyUserEmail($userData['Email'], implode(' ',[$userData['FirstName'],$userData['LastName']]));
                        break;
                }

                $responseJson['status'] = 200;
            }



        }
        else {
            $dataExp=explode('_',$data['UniqId']);
            $userId=reset($dataExp);

            $userData=$u->rowGet(['UniqId'=>$userId]);
            $userData=reset($userData);
            if(count($userData)>0){
                $otp=[];
                $sourceOtp=\MS\Core\Helper\Comman::random(5);
                switch ($data['input']['type']) {

                    case 'sms':
                        $otp= $this->sms_VerifyUserNumber($userData['ContactNo'], 1, $sourceOtp);
                        break;
                    case 'email':
                        $otp=  $this->email_VerifyUserEmail($userData['Email'], implode(' ',[$userData['FirstName'],$userData['LastName']]),$sourceOtp);
                        break;
                }
                $this->regOtpForUser($data['input']['type'],$userId,$otp['otp'],$data['UniqId']);
                $responseJson['status']='200';
            }else{

            }

      }


        return response()->json($responseJson,$responseJson['status']);
    }
    private function initiatePaymentForUser($data)
    {


        $UserId = (array_key_exists('UserId', $data)) ? $data['UserId'] : 0;
        $planId = (array_key_exists('input', $data) && array_key_exists('planId', $data['input'])) ? $data['input']['planId'] : 0;
        $buyFor = (array_key_exists('input', $data) && array_key_exists('buyFor', $data['input'])) ? $data['input']['buyFor'] : 0;


        $u = self::getUserModel();
        $responseJson = [];
        $userData = $u->rowGet(['UniqId' => $UserId]);

        $p = collect(Plans::getAllPlans());

        $p1 = $p->where('UniqId', '=', $planId);
        $invoice = [];

        $planData = ($p1->count() > 0) ? $p1->first() : [];


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







//
//    private function upgradeUser($data = [], $type = '')
//    {
//    }




    public function viewUserProfile($data = [], $type = '')
    {

        $user = $this->getLiveUser();
        $user['plan'] = $this->getUserPlan($user['id']);
        return $user;

    }
    public function getLiveUser()
    {

        $user=$this->getLogedInUser();
        if(!array_key_exists('apiToken',$user))return[];
        $foundUser=$this->getUserByApiToken($user['apiToken']);

        return [
            "id"=>$foundUser['UniqId'],
            "Username" =>(array_key_exists('username',$user))?$user['username']:$foundUser['Username'],
            "email" =>(array_key_exists('email',$user))?$user['email']:$foundUser['Email'],
            "fname" =>(array_key_exists('name',$user))?explode(' ',$user['name'])[0]:$foundUser['FirstName'] ,
            "lname" =>(array_key_exists('name',$user))?explode(' ',$user['name'])[1]:$foundUser['LastName'],
            "name"=>(array_key_exists('name',$user))?$user['name']: implode(' ',[$foundUser['FirstName'],$foundUser['LastName']]),
            "phone" =>(array_key_exists('mobile',$user))? $user['mobile']:$foundUser['ContactNo'],
            "sex" => (array_key_exists('sex',$user))? $user['sex']:$foundUser['Sex'],
            'currentCompany'=>(array_key_exists('currentCompany',$user))? $user['currentCompany']:$foundUser['CompanyId'],
            'apiToken'=>$user['apiToken']
        ];

    }

    private function getUserPlanId(){

    }
    public function getUserPlan($userId)
    {

        $plans = Plans::getAllPlans();


        $c=self::getUserModel();
        $foundUser=$c->rowGet(['UniqId'=>$userId]);
        $foundUser=reset($foundUser);

        $userPlan= (array_key_exists('UserPlan',$foundUser) && $foundUser['UserPlan']!='')? $foundUser['UserPlan']:'111';
       // dd($foundUser);
        $date=Carbon::now('Asia/Kolkata');
        $plan = collect($plans)->where('UniqId', "=", $userPlan)->first();
       // dd($corbon->setTimestamp($foundUser['UserValidUpto']));
        $validYear=$date->setTimestamp($foundUser['UserValidUpto'])->format('Y');
        $validMonthDay=$date->setTimestamp($foundUser['UserValidUpto'])->format('d/m');
        $outData=[
            'planId' => $plan['UniqId'],
            'name' => $plan['PlanName'],
            'limits' => [

                'products' => [
                    'vName' => 'Products',
                    'limit' => $plan['Product'],
                    'usage' => $foundUser['UserProductCount'],
                ],
                'invoice' => [
                    'vName' => 'Invoice',
                    'limit' => $plan['Invoice'],
                    'usage' => $foundUser['UserInvoiceCount'],
                ],
                'purchase' => [
                    'vName' => 'Purchase',
                    'limit' => $plan['Purchase'],
                    'usage' => $foundUser['UserPurchaseCount'],
                ],
                'company' => [
                    'vName' => 'Company',
                    'limit' => $plan['Company'],
                    'usage' => $foundUser['UserCompanyCount'],
                ]
                ,
                'user' => [
                    'vName' => 'Users/Company',
                    'limit' => $plan['PerCompanyUser'],
                    'usage' => $foundUser['UserCompanyCount'],
                ],

                'validupto' => [
                    'vName' => 'Valid upto',
                    'limit' => $validYear,
                    'usage' => $validMonthDay,
                    'remainingInDays'=>$date->diffInDays(Carbon::now())
                ]

            ]
        ];


        return $outData ;
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

    public function migrateByIdForAllUser($id,$users=null,$column='UniqId',$returnData=false){
        $m=self::getUserModel();
        $foundUser=$m->rowAll();
        $users=($users==null)?$foundUser:$users;
        $idExplode = explode('_', $id);
        $tableId = (count($idExplode) > 0 && reset($idExplode) == self::$modCode) ?
            $id : implode('_', array_merge([self::$modCode, $id,]));
        $out=[];
        foreach ($users as $user){
            if(array_key_exists($column,$user)){
                $c = new MSDB('MS\Mod\B\User4O3', $tableId, [ $user[$column] ]);
                $out[implode('_',[$tableId,$user[$column]])]=$c->migrate();
            }else{return false;}
            }
        if($returnData)return $out;
        return true;
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
        $m->setFields(['name' => 'UserPurchaseCount', 'type' => 'string',]);

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
    private function setUpMasterSubUser()
    {

        $data = [
            'tableId' => implode('_', [self::$modCode, 'Sub_Users']),
            'tableName' => implode('_', [self::$modCode, 'Sub_Users_']),
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
    private function setUpUserNotification()
    {
        $data = [
            'tableId' => $this->UserNotification,
            'tableName' => implode('_', [self::$modCode, 'Users_Notification_']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyType', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyFrom', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyTitle', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyAction', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyData', 'type' => 'string']);
        $m->setFields(['name' => 'NotifyRead', 'type' => 'string',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setUpUserAction()
    {
        $data = [
            'tableId' => $this->UserAction,
            'tableName' => implode('_', [self::$modCode, 'Users_Action_']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'ActionType', 'type' => 'string']);
        $m->setFields(['name' => 'ActionMod', 'type' => 'string']);
        $m->setFields(['name' => 'ActionTitle', 'type' => 'string']);
        $m->setFields(['name' => 'ActionData', 'type' => 'string']);
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }


    private function setUpUserPayment($userId = [])
    {


        $userId2 = implode('', $userId);

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
    private function setUpUserCall($userId = [])
    {

        $userId2 = implode('', $userId);

        $data = [
            'tableId' => implode('_', [self::$modCode, 'Call_Log']),
            'tableName' => (count($userId) > 0) ? implode('_', [self::$modCode, 'Call_Log', $userId2]) : implode('_', [self::$modCode, 'Call_Log']),
            'connection' => self::$c_d,
        ];


        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CallFor', 'type' => 'string']);
        $m->setFields(['name' => 'CallFrom', 'type' => 'string']);
        $m->setFields(['name' => 'CallOfferData', 'type' => 'string']);
        $m->setFields(['name' => 'CallAnswerData', 'type' => 'string']);
        $m->setFields(['name' => 'CallType', 'type' => 'string']);
        $m->setFields(['name' => 'CallConnected', 'type' => 'string',]);
        $m->setFields(['name' => 'CallDisconnected', 'type' => 'string',]);
        $m->setFields(['name' => 'UserOffline', 'type' => 'string']);
        $m->setFields(['name' => 'CallStatus', 'type' => 'string',]);

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
        $data['channel']=0;
        if ($try > 0) $data['channel'] = 1;
        $u = [];
        // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {

            $u = (!array_key_exists('channel', $data)) ?
                MSSMS::SendSMS($to, ['strData' => ['OTP' => $data['otp']], 'templateId' => $data['name']]) : MSSMS::SendSMS($to, ['strData' => ['OTP' => $data['otp']], 'templateId' => $data['name'], 'channel' => $data['channel']]);

        } catch (Exception $e) {
           // dd($e);
          //  return [];
        }


        return $data;
    }
    private function email_VerifyUserEmail($to,$name,$otp=null)
    {
        $data = [
            'mailSubject' => 'Email Verification for O3 ERP Account Opening',
            'name' => $name,
            //'toEmail'=>'emails@domain.com',
            'otp' => ($otp==null)? Comman::random(5):$otp
        ];




        // return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
        try {
            $m = MSMail::SendMail($to, 'MS::core.layouts.Email.EmailVerify', $data);

        } catch (Exception $e) {
            //dd($e);
           // return [];
        }
        return $data;
    }
    private function regOtpForUser($channel, $userId, $otp,$uniqId=''): array
    {
        $return = [];

        $m = self::getOtpModel();
        $data = [
            'UniqId' =>($uniqId=='')?Comman::random(16, 1, 1,[$userId]):$uniqId,
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


    public static function getTableRaw($data=[])
    {

        $methodToCall = [
            'setUpMasterUser' => [],
            'setUpUserVerificationOTPs' => [],
            'setUpUserPayment' => [],
            'setUpUserCall'=>[],
            'setUpUserNotification'=>[]
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
    public static function getUserNotificationModel($userId)
    {
        $c = new self();
        return $c = new MSDB($c->ModNameSpace, $c->UserNotification, [$userId]);
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
    public static function getUserCallLogModel($userId){
        $c = new self();
        return $c = new MSDB($c->ModNameSpace,implode('_',[self::$modCode,'Call_Log']),[$userId]);
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
