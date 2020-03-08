<?php


namespace MS\Mod\B\User4O3;
//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use mysql_xdevapi\Exception;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{

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
      //  $m->migrate();
       // dd($m->signUpUser($r->all()));
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

