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
        //return $m->;
        $getCurrentUser=$m->getLiveUser();
        $data['UserDetails']=$m->viewUserProfile($getCurrentUser);
    //    dd($data);
        return view("MOD::B.User4O3.V.profilePage")->with('data',$data);
    }
}
