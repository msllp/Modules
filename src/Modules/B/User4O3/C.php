<?php


namespace MS\Mod\B\User4O3;
//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use MS\Mod\B\User4O3\L\Users;
use mysql_xdevapi\Exception;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{

    public function test(){
        $u=new Users();
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

    public function signUpUserVerify($token,Request $r){
        $m=new L\Users();
        return \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'verifyUser','data'=>['input'=>$r->all(),'UniqId'=>$token]]]);
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

