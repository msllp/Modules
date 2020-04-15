<?php

namespace MS\Mod\B\Panel4O3;

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
    use  DispatchesJobs, ValidatesRequests;
    protected $data=[];

    protected $ln='en';

    public function MaintainaceDashboardWithApiToken($apiToken,$ln=null,Request $r){

        $checkSession=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'checkUserLoginSession','data'=> $apiToken ]]);


        if($checkSession){
            if($ln==null)$ln=$this->ln;
            session('ln',$ln);
            \App::setlocale(session('ln'));
            $data=[
                'path'=> [
                    'sidebar'=> route('O3.Panel.data')
                ],
                'accessToken'=> \MS\Core\Helper\Comman::encode($apiToken),
                'msUser'=>  \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLiveUser','data'=> [] ]])

            ];

            return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
        }else{
            return redirect()->route('O3.Users.Login.Form');
        }



    }



    public function MaintainaceDashboard(Request $r,$ln=null){
        //dd($r);
        if($ln==null)$ln=$this->ln;
        $r->session()->put('ln', $ln);
        session('ln',$ln);

        $foundUser=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLogedInUser','data'=> [] ]]);
        //dd($foundUser);
        \App::setlocale(session('ln'));
        $data=[

            'path'=> [
                'sidebar'=> route('O3.Panel.data')
            ],

            'accessToken'=>(array_key_exists('apiToken',$foundUser))?\MS\Core\Helper\Comman::encode($foundUser['apiToken']) : \MS\Core\Helper\Comman::encode('UserMitul'),


        ];
        return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
    }


    public function SideNavForMaintainaceDashboard(Request $r){

      //  dd($r);
        $getLoggedUser=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLogedInUser','data'=> [] ]]);
        \App::setlocale(session('ln'));
        //dd($r->session()->all());
        $rdata=['accessToken'=>$getLoggedUser['apiToken']];

        $data=\MS\Mod\B\Panel4EN\L\Nav::getNavForEnv();

        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }





}
