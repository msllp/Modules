<?php

namespace MS\Mod\B\Panel4EN;

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
                'sidebar'=> route('Env.Panel.data')
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

    public function addItemRequest(){
       // dd('ij');
        $data=[
            'productApiUrl'=>route('Env.Panel.Add.item.Request.get.Product'),
            'maxItemCount'=>10,
            'tax'=>[
                'onItem'=>[
                    [
                       'name'=> 'CGST',
                        'plus'=>'8'
                    ],
                    [
                       'name'=> 'SGST',
                        'plus'=>'8'
                    ]
                ],
                'onTotal'=>[],

            ],
            'msConfig'=>[
                'priceMatters'=>true,
                'productDescription'=>true
            ],
        ];
        return view('MOD::B.Panel4EN.V.addItemRequest')->with('msData',$data);
    }

    public function getProduct(Request $r){
        $d=$r->all();
        $page=(array_key_exists('page',$d))?$d['page']:1;
        $pageData=[];
        $perPage=5;
        $fakeN=100;



            if(array_key_exists('name',$d)){
                $str=$d['name'];
                for ($x = 0; $x <= $fakeN ; $x++){
                    $data[]=[
                        'name'=>'item '.$x." ( ".\MS\Core\Helper\Comman::random('4')." )",
                        'price'=>\MS\Core\Helper\Comman::random('3'),
                        'stock'=>'10',
                        'itemcode'=>8901725172817+$x,
                        'taxcode'=>\MS\Core\Helper\Comman::random('3'),
                        'tax'=>[
                            [
                                'name'=> 'CGST',
                                'plus'=>'10'
                            ],
                            [
                                'name'=> 'SGST',
                                'plus'=>'10'
                            ]
                        ],
                    ];
                }
                $cData=collect($data);

                //dd($data);
                //dd($);
                $data=$cData->filter(function($item) use ($str) {

                    //  dd((stripos($item['name'],$str) !== false || $item['itemcode']===$str));
                    return (stripos($item['name'],$str) !== false || $item['itemcode']==$str);
                });
                $pages=$data->count()/$perPage;
                $pagesType= gettype($pages);
                if($pagesType =='double'){
                    $pageData['maxPage']=round($pages)+1;
                }elseif ($pagesType=='integer'){
                    $pageData['maxPage']=$pages;
                }

                $data2=$data->forPage($page, $perPage);
                $data2=array_values($data2->toArray());

            }

            if(array_key_exists('msFor',$d)){
                $str=$d['msFor'];
                for ($x = 0; $x <= $fakeN ; $x++){
                    $userData[]=[
                        'name'=>'User name '.$x." ( ".\MS\Core\Helper\Comman::random('4')." )",
                        'gstno'=>\MS\Core\Helper\Comman::random('15'),
                        'address1'=>'For User '.$x.' addressline1',
                        'address2'=>'For User '.$x.' addressline2',
                        'address3'=>'For User '.$x.' addressline3',
                        'city'=>'User_City_'.$x,
                        'pincode'=>\MS\Core\Helper\Comman::random('5'),
                        'contactno'=>\MS\Core\Helper\Comman::random('10'),
                    ];

                }

                $cData=collect($userData);

                //dd($data);
                //dd($);
                $data=$cData->filter(function($item) use ($str) {

                    //  dd((stripos($item['name'],$str) !== false || $item['itemcode']===$str));
                    return (stripos($item['name'],$str) !== false || stripos($item['contactno'],$str) !== false);
                });


                $pages=$data->count()/$perPage;
                $pagesType= gettype($pages);
                if($pagesType =='double'){
                    $pageData['maxPage']=round($pages)+1;
                }elseif ($pagesType=='integer'){
                    $pageData['maxPage']=$pages;
                }

                $data2=$data->forPage($page, $perPage);
                $data2=array_values($data2->toArray());
            }



    //dd((array_key_exists('msFor',$d))?$data2:[]);

         $data=[
             'msItem'=>(array_key_exists('name',$d))?$data2:[],
             'msItemPageData'=>$pageData,
             'msFor'=>(array_key_exists('msFor',$d))?$data2:[]
         ];
           // dd($d);
       // dd();
     //   dd();

        return response()->json($data);
    }





}
