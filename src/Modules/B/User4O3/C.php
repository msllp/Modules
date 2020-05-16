<?php


namespace MS\Mod\B\User4O3;
//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\Comman;
use MS\Mod\B\User4O3\L\Users;
use mysql_xdevapi\Exception;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{

    public function __construct()
    {
        $this->middleware('onlyAjax')->only('getAllPlansForWebsite','getUserForWebsite');
        $this->middleware('onlyUsers')->only([]);


    }

    public function upgradeUser(){
        $inputData=[

        ];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'upgradeUserPage','data'=>$inputData]]);

    }

    public function changeCurrentCompany($userId,$companyId){

         $inputData=[
             'companyId'=>$companyId,
             'userId'=>$userId
         ];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'setCompany','data'=>$inputData]]);

    }

    public function getCsrf(){
        $array=[
            'msData'=>[
                'csrf'=>csrf_token()
            ]
        ];
        return response()->json($array);
    }

    public function signInByToken($apiToken){

        $inputData=[
            'apiToken'=>$apiToken
        ];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signByToken','data'=>$inputData]]);


    }
    public function showVmeetForm(){
        $u=new Users();
        $cUApiToken=$u->getLiveUser()['apiToken'];

        $inputData=['apiToken'=>$cUApiToken,'json'=>true];
        //dd(\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getAllowedUserToCall','data'=>$inputData]]));
        $allowedUser= \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getAllowedUserToCall','data'=>$inputData]]);

        $inputData=[

            'allowedUser'=>$allowedUser

        ];
        return \MS\Mod\B\User4O3\L\Meetings::fromController([['method'=>'addNewMeetForm','data'=>$inputData]]);


    }


    public function getCallDataForReceiver($UniqId,$From,$To){
        $inputData=[
            'callId'=>$UniqId,
            'fromUser'=>$From,
            'toUser'=>$To
            ];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getCallDataForReceiver','data'=>$inputData]]);



    }
    public function getCallDataForCaller($UniqId,$From,$To){
        $inputData=[
            'callId'=>$UniqId,
            'fromUser'=>$From,
            'toUser'=>$To
            ];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getCallDataForCaller','data'=>$inputData]]);



    }

    public function loginPage(){
     if (   F::checkUserLogin())return \MS\Mod\B\Panel4O3\F::redirectToPanel();
        $m=L\Users::getUserModel();
        return $m->loginPage();
    }

    public function logoutUser(){
        \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'singOutUserToSession','data'=>[]]]);
        return redirect()->route('O3.Users.Login.Form');
    }
    public function loginInUserCheck(Request $r){

        $inputData=$r->all();
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signInUser','data'=>['input'=>$inputData]]]);

    }

    public function sendNotificatonToReceiver($from,$to,Request $r){
        $inputData=['from'=>$from,'to'=>$to,'vCallData'=>$r->all()];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'sendCallToUser','data'=>$inputData]]);

    }

    public function sendNotificatonToCaller($from,$to,Request $r){
        $inputData=['from'=>$from,'to'=>$to,'vCallData'=>$r->all()];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'sendCallRcvToUser','data'=>$inputData]]);

    }

    public function getAllAllowedUserList($apiToken){
        $inputData=['apiToken'=>$apiToken];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getAllowedUserToCall','data'=>$inputData]]);

    }

    public function getNotificationByApiToken($apiToken){
        $inputData=['apiToken'=>$apiToken];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getNotificationByApiToken','data'=>$inputData]]);

    }

    public function getNotificationByApiTokenForNotifyId($notifyId){
        $inputData=['notifyId'=>$notifyId];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getNotificationByNotifyId','data'=>$inputData]]);



        dd($notifyId);
    }

    public function testPost(Request $r)
    {


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
        $pusher->trigger( 'o3erp', 'my-live-feed', $r->all() );
        dd($pusher);
    }
    public function test(Request $r){
       // dd(L\Users::getOtpModel());


        //dd(F::setDefaultCompanyForUser("test"));
      //  return view('MS::core.layouts.Email.EmailVerify');
        $m=new L\Users();

        dd($m->migrate());
        $getCurrentUser=$m->getLiveUser();

        $start = microtime(true);
        $encode=\MS\Core\Helper\Comman::encodeLimit($getCurrentUser['apiToken']);

        $decode=\MS\Core\Helper\Comman::decodeLimit($encode);
        $end=$time_elapsed_secs = microtime(true) - $start;

        //dd($end);
       // dd(number_format ($end*6000,50,'.',' '));
        var_dump(strlen(\MS\Core\Helper\Comman::encode($getCurrentUser['apiToken'])));
        dd($decode==$getCurrentUser['apiToken']);

        $id=implode('_', [L\Users::$modCode, 'Users_Notification']);
        $c=new L\Users();

        $data=[
            //'UniqId'=>\MS\Core\Helper\Comman::random(10,3,2,['test']),
            'NotifyType'=>'System',
            'NotifyFrom'=>'System',
            'NotifyTitle'=>'Setup Company',
            'NotifyAction'=>[
                'view'=>[
                    'url'=>route('O3.Users.Login.Form'),
                    'text'=>'Login Nod'
                ]
            ],
            'NotifyData'=>[
                'body'=>' Please Setup Company'
            ],
            'NotifyRead'=>0
        ];

        dd($c->addNotificaiton($data));
      //  dd($c->migrateByIdForAllUser($data));


        dd(\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'migrateByIdForAllUser','data'=>$inputData]]));




        //dd(\MS\Core\Helper\MSPlease::ModuleInMod('B\Company4O3'));
        $c=new L\Meetings();
        dd($c->getMeetingModel());

        return view('MOD::B.User4O3.V.videoConf');

        $m=new L\Users();
        dd($m->migrateByIdForAllUser(implode('_',['Call_Log'])));


        dd(\MS\Core\Helper\Comman::encode('peYxyNBOnakULQTwbmzScQpFDfioQCaLJAGRqhkznsFWfAMvwLEGGQNDfnuRdVqjwcpHnngwkJCDPyLouvstIWZDimmfwscqRATJdvdarNbLCaLEdKHKUSdYQSNmqmtHsHiBzXSTRHvmjapbxmHitdrRnQAFLhrSIqsotUJZwoQzEgKEuLAAJwDQaeHk'));
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
        $pusher->trigger( 'o3erp', 'my-event', ['name'=>'Mitul'] );
        dd($pusher);

      //  dd(\MS\Core\Helper\MSPay::checkPaymentStatus('inv_EUFiXcT9rbjWDs'));
        //dd($this->redirectToPaymentGateway($r,'7591253951733152'));
        $u=new Users();
        dd($u->migrateById('Users'));
        $u=\MS\Core\Helper\MSSMS::SendSMS('7990563470',['strData'=>['OTP'=>'123'],'templateId'=>'OTPforUser','channel'=>1]);

        dd($u->migrate());
        //dd(\MS\Core\Helper\Comman::random(16 ,1,1));
        $d[true][]=12;
        dd($d);
        $data=[
            'mailSubject'=>'Email Verification for O3 ERP Account Opening',
            'name'=>'Mitul Patel',
            'toEmail'=>'emails@domain.com',
            'otp'=>\MS\Core\Helper\Comman::random(5)
        ];
        return view('MS::core.layouts.Email.EmailVerify')->with('data',$data);
      $m=\MS\Core\Helper\MSMail::SendMail('mitul.a.patel.live@gmail.com','MS::core.layouts.Email.EmailVerify',$data);
      dd($m);
    }


    public  function trackPaymentForUserSignUp($orderId){
        $inputData=[];
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'updatePaymentStatus','data'=>['input'=>$inputData,'OrderId'=>$orderId]]]);
    }
    public function redirectToPaymentGateway(Request $r,$userId){
        $inputData=$r->all();
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'initiatePaymentForUser','data'=>['input'=>$inputData,'UserId'=>$userId]]]);
    }
    public function signUpUserVerify($token,Request $r){
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'verifyUser','data'=>['input'=>$r->all(),'UniqId'=>$token]]]);
    }
    public function resendOtp($token,Request $r){
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'resendVerifyUser','data'=>['input'=>$r->all(),'UniqId'=>$token]]]);
    }
    public function viewProfileOfCurrentUser(){
        $m=new L\Users();
        $p=new L\Plans();
    //    dd($m->migrate());
        $getCurrentUser=$m->getLiveUser();

        $data['UserDetails']=$m->viewUserProfile($getCurrentUser);
        $data['AllPlanDetails']=$p->getAllPlan();
    //    dd($data);
        return view("MOD::B.User4O3.V.profilePage")->with('data',$data);
    }
    public function signUpUser(Request  $r){

        $m=new L\Users();
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signUpUser','data'=>$r->all()]]);
    }
    public function getAllPlansForWebsite(){
        $m=new L\Plans();
        return $m->getAllPlanForWebsite();
    }


    public function signInByGoogle(){
        $url=route('O3.Users.Login.Google.Callback');
        return Socialite::driver('google')->redirectUrl($url)->redirect();

    }
    public function signInByGoogleCallBack(Request $r){
        $url=route('O3.Users.Login.Google.Callback');
        $user = Socialite::driver('google')->redirectUrl($url)->user();
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signInUserFromGoogle','data'=>$user]]);
    }

    public function signUpByGoogleFromBackendCallback($user){

        $data=Session::get($user);
        $base=env('MIX_APP_FRONTEND_URL');
        $url2=implode('/',[$base,'signup','google']);
        $data=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signUpUserFromGoogle','data'=> ['user'=>$data,'array'=>true] ]]);
        $userId=$data['userDetails']['apiToken'];
        $url2=implode('/',[$url2,$userId,$data['type'],$data['OTPUniqId']]);
        return \Redirect::away($url2);
    }

    public function signUpByGoogleFromWebsite(){
        $url=route('O3.Users.SignUp.Google.Callback');
        return Socialite::driver('google')->redirectUrl($url)->redirect();
    }

    public function signUpByGoogleFromWebsiteCallback(Request $r){
        $url=route('O3.Users.SignUp.Google.Callback');
        $base=env('MIX_APP_FRONTEND_URL');
        $url2=implode('/',[$base,'signup','google']);
        $user = Socialite::driver('google')->redirectUrl($url)->user();
        $m=new L\Users();
        $data=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'signUpUserFromGoogle','data'=> ['user'=>$user,'array'=>true] ]]);
        $userId=$data['userDetails']['apiToken'];
        $url2=implode('/',[$url2,$userId,$data['type'],$data['OTPUniqId']]);
        return \Redirect::away($url2);

    }

    public function getUserForWebsite($apiToken){
        $c=new L\Users();
        $d=  \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getUserByApiToken','data'=> $apiToken ]]);
        $data=['msData'=>$d];
        return response()->json($data);
    }

    public function AndroidApi_getUser($apiToken){
        $c=new L\Users();
        $d=$c->getUserByApiToken($apiToken);


        //return $c->getUserByApiToken($apiToken);

        //dd();

        $data=[
            'User'=>$d,
            'PlanData'=>$c->getUserPlan($d['UniqId'])
        ];
        return response()->json($data);
    }
}

