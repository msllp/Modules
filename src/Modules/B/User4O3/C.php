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



    public function loginPage(){
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

    public function test(Request $r){


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

