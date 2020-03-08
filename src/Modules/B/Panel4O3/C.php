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

    public function MaintainaceDashboard(Request $r,$ln=null){

        if($ln==null)$ln=$this->ln;
        $r->session()->put('ln', $ln);
        session('ln',$ln);
        \App::setlocale(session('ln'));
        $data=[

            'path'=> [
                'sidebar'=> route('O3.Panel.data')
            ],

            'accessToken'=> \MS\Core\Helper\Comman::encode('UserMitul')

        ];
        return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
    }


    public function SideNavForMaintainaceDashboard(Request $r){

        \App::setlocale(session('ln'));
        //dd($r->session()->all());
        $rdata=['accessToken'=>'UserMitul'];
        $data=\MS\Mod\B\Panel4EN\L\Nav::getNavForEnv();

       // dd($data);
        //dd(route('MOD.Mod.Master.Event.View.All'));
        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }





}
