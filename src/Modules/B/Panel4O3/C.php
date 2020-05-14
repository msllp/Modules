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

    public function __construct()
    {

        $this->middleware('onlyAjax')->only(['SideNavForMaintainaceDashboard']);
        $this->middleware('onlyUsers')->only(['SideNavForMaintainaceDashboard']);

    }

    public function MaintainaceDashboardWithApiToken($apiToken,$ln=null,Request $r){

     //   dd(\MS\Mod\B\User4O3\L\Users::checkUserLoggedIn());
        $checkSession=\MS\Mod\B\User4O3\F::checkUserLogin($apiToken);
       //     \MS\Mod\B\User4O3\L\Users::fromController([['method'=>'checkUserLoginSession','data'=> $apiToken ]]);


        if($checkSession){
            if($ln==null)$ln=$this->ln;
            session('ln',$ln);
            \App::setlocale(session('ln'));
          $foundUser=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLiveUser','data'=> [] ]]);
            $firsttab= [
                'tabCode'=>'01',
                'modCode'=>'MAS',
                'modDView'=>"Setup Company",
                'modUrl'=>"/o3/Company/setup/company",
                'data'=>'',
            ];


            if(array_key_exists('currentCompany',$foundUser) && $foundUser['currentCompany']!='0'){
                $firsttab= [
                    'tabCode'=>'01',
                    'modCode'=>'MAS',
                    'modDView'=>"Sales One View",
                    'modUrl'=>"/Core/Sales/dashboard",
                    'data'=>'',
                ];
            }
            $data=[
                'path'=> [
                    'sidebar'=> route('O3.Panel.data'),
                    'getAllCompany'=>route('O3.Company.All.For.User',['userId'=>\MS\Core\Helper\Comman::encodeLimit($foundUser['id'])]),
                    'changeCurrentCompany'=>route('O3.Users.Current.Company',['userId'=>\MS\Core\Helper\Comman::encodeLimit($foundUser['id'])])
                ],
                'accessToken'=> \MS\Core\Helper\Comman::encodeLimit($apiToken,120),
                'msUser'=> $foundUser ,
                  'msViewPanel'=>[
                'tab'=>[
                    $firsttab
                ]
            ]

            ];

            return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
        }else{

         return   \MS\Mod\B\User4O3\F::redirectToLoginPage();
            //return redirect()->route('O3.Users.Login.Form');
        }



    }



    public function MaintainaceDashboard(Request $r,$ln=null){


       // dd();

        $checkSession=\MS\Mod\B\User4O3\F::checkUserLogin();

       // dd(session()->all());
        if($ln==null)$ln=$this->ln;
        $r->session()->put('ln', $ln);
        session('ln',$ln);
        \App::setlocale(session('ln'));
        if(!$checkSession) return   \MS\Mod\B\User4O3\F::redirectToLoginPage();
        $foundUser=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLiveUser','data'=> [] ]]);
      //dd($foundUser);
        if(count($foundUser)>0){
            $firsttab= [
                'tabCode'=>'01',
                'modCode'=>'MAS',
                'modDView'=>"Setup Company",
                'modUrl'=>"/o3/Company/setup/company",
                'data'=>'',
            ];

            if(array_key_exists('currentCompany',$foundUser) && $foundUser['currentCompany']!='0'){
                $firsttab= [
                    'tabCode'=>'01',
                    'modCode'=>'MAS',
                    'modDView'=>"Sales One View",
                    'modUrl'=>"/Core/Sales/dashboard",
                    'data'=>'',
                ];
            }
            $data=[
                'path'=> [
                    'sidebar'=> route('O3.Panel.data'),
                    'getAllCompany'=>route('O3.Company.All.For.User',['userId'=>\MS\Core\Helper\Comman::encodeLimit($foundUser['id'])]),
                    'changeCurrentCompany'=>route('O3.Users.Current.Company',['userId'=>\MS\Core\Helper\Comman::encodeLimit($foundUser['id'])])
                    ],
                'accessToken'=>( array_key_exists('apiToken',$foundUser))?\MS\Core\Helper\Comman::encodeLimit($foundUser['apiToken']) : \MS\Core\Helper\Comman::encodeLimit('UserMitul'),
                'msUser'=>$foundUser,
                'msViewPanel'=>[
                    'tab'=>[
                        $firsttab
                    ]
                ]
            ];

            return view("MS::core.layouts.MS.mpanel")->with('msData',$data);
        }else{
            return redirect()->route('O3.Users.Login.Form');
        }

    }


    public function SideNavForMaintainaceDashboard(Request $r){

     //  dd($r->all());

       $getLoggedUser=\MS\Mod\B\User4O3\L\Users::fromController([['method'=>'getLogedInUser','data'=> [] ]]);
        \App::setlocale(session('ln'));
        //dd($r->session()->all());
        //dd($getLoggedUser['apiToken']);
        $rdata=['accessToken'=>$getLoggedUser['apiToken']];

        $data=\MS\Mod\B\Panel4O3\L\Nav::getNavForEnv();

        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }





}
