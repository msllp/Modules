<?php

namespace B\MAS;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Razorpay\Api;

class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=
        [
            'logo'=>"logo-a.png"

        ];


    public function genInvFroApp(){


        return view("BM.V.genInvoice");
    }

    public function paginationTest(Request $r){
       // dd($r->all());

        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_All_Feature');

        return $m->ForPagination($r);

    }

    public function postLinkTest(Request $r){


        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,"Master_All_Feature");
      //  $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,"Master_Mode");
        $m->attachRequest($r);
       // $m->migrate();
        $d=$r->all();

        dd($m->rowAdd($d));
        $valid=$m->checkRulesForData($r);
      //  dd($valid);
        //dd($m);
       // dd(response()->json(  $m->errors() ,301));
        //dd($valid);
        $data=[

            'data'=>
            [
                'notifyText'=>'Text',
                'redirectLink'=>route('MAS.Index'),
                'notifyIcon'=>'fa fa-home',


            ],
            'type'=>'nr'
        ];
        if($valid){
            return response()->json($data,200);
        }

        return response()->json(  $m->errors() ,422);
       // if(!array_key_exists('uniqId',$d))$d['uniqId']="1125";
//        if(array_key_exists('modIcon',$d))$d['modIcon']="fa-home";
//        if(array_key_exists('_token',$d)) unset($d['_token']) ;
//        if(array_key_exists('modHomeAction',$d)) unset($d['modHomeAction']) ;
//        if(array_key_exists('modDataAction',$d)) unset($d['modDataAction']) ;
//
//        //dd($d);
//        dd(  $m->rowAdd($d,['UniqId']));
//        $m->rowAdd($r->all());

        $validation=[
        //    'modName'=>'required',
         //   'modDesc'=>'required'
        ];
        $messages=[
            'modName.required'=>'Please enter :attribute'
        ];
        $attribute=[

            'modName' => 'Name of Module',
        ];

        $test=$r->make($validation,$messages,$attribute);
      dd($test);



           // $image=$r->file('modIcon');
   // dd( $r->all()['modIcon']);
//$i=0;
//    foreach ($r->all()['modIcon'] as $file){
//
//        $filename=time().$i.".".$file->getClientOriginalExtension();
//        $file->storeAs('Files',$filename ,'MS-CORE'
//        );
//
//$i++;
//    }


        return response()->json(['ms'=>[

            'status'=>200,
            'Rdata'=> $r->input()

        ]],202);

    }
    public  function testMail(){
      //  phpinfo();
      //  dd(extension_loaded ( 'imap' ));

        try{
            $mbox = imap_open ("{".env('MAIL_HOST').":".env('MAIL_PORT')."/ssl/".env('MAIL_DRIVER')."}INBOX", env('MAIL_USERNAME'), env('MAIL_PASSWORD'));
        //    dd(imap_num_msg ($mbox));
//            dd(imap_header  ($mbox,2));
//            dd(imap_num_msg ($mbox));
            for ($i=1;$i < imap_num_msg ($mbox);$i++){
              //  dd((array)imap_header($mbox,$i));
                dd(imap_utf7_decode ('34fce873543751c8d99a07a88647c663'));
              var_dump("From ".imap_header  ($mbox,$i)->from[0]->mailbox."@".imap_header  ($mbox,$i)->from[0]->host."<br>");
            }
        }catch (Exception $exception){
            dd($exception);
        }

    }
    public function index(Request $r){

        //return view("MS::core.layouts.panel");
        $docker=new \MS\Core\Docker\Image();
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_All_Feature');
      //  $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Mod');
        // $m=new \MS\Core\Helper\MSDB('B\\DCM','Master_Port');
        //dd($m);
        $data=[
            'UniqId'=>'0021',
            'port'=>'40209',
            'portUsedByUserId'=>'002',
            'portAllocatedContainerId'=>'001_001',

        ];

        return $m->viewData('view_all');
      //  $m->migrate();
        //dd($m->rowEdit(['port'=>'40209'],$data))  ;
        return $m->displayForm('add_form');
      //  dd($docker->makeImage());


      //  return view("MS::core.layouts.panelWithLiveTab");
       // dd($this->testMail());
        //return $this->testMail();
        //dd(route("MS.Test"));
        //return redirect(route("MS.Test"));
       // dd(config('MS'));
        //dd(config(R\AddMSCoreModule));
      //  $m=new \MS\Core\Helper\MSDB("B\MAS","Master_Hub",[]);
        //$m=new \MS\Core\Helper\MSDB("B\MAS","Master_Mod",['fieldGroup']);
      //  $m=new \MS\Core\Helper\MSDB("B\MAS","Master_Mod_Status",[]);



      //  $m->migrate();
        //return $m->displayFrom(['group'=>['Add Module','Login Details','Add Module2'],'action'=>['add','back']]);



        return view("MS::core.layouts.panel");
        //dd(new M(__NAMESPACE__ ) );
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_User');
        $m->msData=$m->rowGet(['FirstName'=>"Mitul"]);
        dd($m->notify());
        dd($m->notify(new N()));
        dd(new N ());
//        //dd($r->all());
//        header("Access-Control-Allow-Origin: *");
//        $input=$r->all();
//
//        $url = "https://books.zoho.com/api/v3/meta/hsnsaccodes?search_text=".$input['hsn']; // http://localhost:8000/template/1/11
//        $html =  file_get_contents($url)  ;

        return view("BM.V.viewGST");


       // dd($html)  ;
     //   return $html;
      //  $html =  file_get_contents($url) .$style ;
        //dd($html);
        //return $html;
       //return view("BM.V.genInvoice");

        $pdf = \PDF::loadView('BM.V.genInvoice');
       // dd($pdf);
        return $pdf->download('invoice.pdf');
        $link=\MS\Core\Helper\MSPay::makePaymentLink(100,['customerEmail'=>'maxirooney@millionsllp.com',"customerNumber"=>"9662611234",'description'=>"Test From Class"]);
        return redirect($link['link']);
        $id="rzp_test_hWAPfGnN0KwMXK";
        $secret="f2CxU8JV3aWiTAjMY2X5y630";
        $razorPay=new Api\Api($id,$secret);

        $razorPayMaster=$razorPay->invoice->create(
            [
                'type' => 'link',
                'amount' =>6000,
                'description' => 'For MSLLP Test purpose Test',
                'customer' => [
                    'email' => 'mitul@millionsllp.com',
                    "contact"=> "9662611234",
                ],

            ]
        );



        dd(
         $razorPayMaster->notifyBy('sms')   );


        $r=$r->all();
//dd($r);
        if(array_key_exists('dataLink',$r) && $r['dataLink']){

            return response()->json([
                [
                    'name'=>'ProductName',
                    'msg'=>["erroe"]
                    

                ]


            ],422);

        }

        //dd(B::getTable());

        //return view("MS::core.layouts.login");
        //$m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'anuj_test');


       // $code=\MS\Core\Helper\Comman::encode("mitul");

     //   dd(\MS\Core\Helper\Comman::decode($code));

        return view("BM.V.genInvoice");


        $m=new \MS\Core\Helper\MSDB("B\BM","Master_Booking",[]);
        //$m->migrate();
        return $m->displayFrom();

        //return view("MS::core.layouts.login")->with('data',$this->data);

    }

    public function testFormLink(){

        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_All_Feature');
        return $m->displayForm('add_form');
    }

    public function testGetSideBarData(Request $r){

    $input=$r->all();
        $returnArray=[
            'msg'=>'Opps I am Computer not Human.'

        ];
        if(array_key_exists('accessToken',$input))$input['accessToken']=\MS\Core\Helper\Comman::decode($input['accessToken']);
        if(array_key_exists('accessToken',$input) && array_key_exists('type',$input) && array_key_exists('find',$input)){

            $returnArray['msg']='We finding Data';


            switch ($input['type']){
                case 'json':

                    switch ($input['find']){

                        case 'sidebar':
                            $returnArray['msg']='We Have Data';
                            $returnArray['items']=[
                                [
                                    'text'=>'Test',
                                    'type'=>'mainNav',
                                    'icon'=>'fa fa-home',
                                    'sub' =>[
                                         [
                                         'type'=> 'title',
                                         'text'=> 'Test Functions ',
                                         'icon'=> ' fab fa-docker '
                                         ],

                                        [
                                         'type'=> 'link',
                                         'text'=> 'New Tab Test',
                                         'link'=> route('Test.NewRab'),
                                         'icon'=>'fas fa-compact-disc'
                                        ]

                                        ,

                                        [
                                            'type'=> 'link',
                                            'text'=> 'Form Test',
                                            'link'=> route('Test.FormLink'),
                                            'icon'=>'fas fa-compact-disc'
                                        ]
                                    ],



                            ],
                                [
                                    'text'=>'Main Nav Name',
                                    'type'=>'mainNav',
                                    'icon'=>'fa fa-home',
                                    'sub' =>[
                                        [
                                            'type'=> 'title',
                                            'text'=> 'Docker Functions',
                                            'icon'=> ' fab fa-docker '
                                        ],

                                        [
                                            'type'=> 'link',
                                            'text'=> 'Make Image',
                                            'link'=>  route('Test.NewRab'),
                                            'icon'=>'fas fa-compact-disc'
                                        ]
                                    ],



                                ],
                                [
                                    'text'=>'Main Nav Name',
                                    'type'=>'mainNav',
                                    'icon'=>'fa fa-home',
                                    'sub' =>[
                                        [
                                            'type'=> 'title',
                                            'text'=> 'Docker Functions',
                                            'icon'=> ' fab fa-docker '
                                        ],

                                        [
                                            'type'=> 'link',
                                            'text'=> 'Make Image',
                                            'link'=> '/DCM/action/make/image',
                                            'icon'=>'fas fa-compact-disc'
                                        ]
                                    ],



                                ]


                            ];

                            return response()->json($returnArray,200);
                            break;


                    }

                    break;
            }

        }

        return response()->json($returnArray,418);
        dd($input);

    }

    public function storeDataLink(Request $r){

        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_All_Feature');
        $m->attachR($r);
        // $m->migrate();
        $d=$r->all();
        $valid=$m->checkRulesForData();

        if($valid){
            $m->checkRulesForData();

            return response()->json(['ms'=>[

                'status'=>200,
                'Rdata'=> $r->input(),
                'ProcessStatus'=>[$m->add()]

            ]],200);
        }
        else{
            return response()->json([
                     'errors' => $m->CurrentError
            ],418);
            return $m->CurrentError;
        }

        dd($valid);
    }


    public  function  testNewTab(Request $r){
        return view("MS::core.layouts.NewTab");
        return  "<msdockerdashboard></msdockerdashboard>";

    }



    public function productAddForm(Request $r){

        return $this->index($r);

        return view("MAS.V.productAdd")->with('data',$this->data);

    }

    public function prdocutAdd(){


        $m=new \MS\Core\Helper\MSDB("B\HM","Master_Product",[]);
        dd($m->model->migrate());
        dd($m->displayFrom()->reder());

    }

public function genarateInvoicePDF(Request $r){


//dd($_SERVER);

      // return view("BM.V.pdfInvoice");
    $pdf = \PDF::loadView('BM.V.pdfInvoice');
    return $pdf->setPaper('a4', 'landscape')->download('invoice.pdf');


}

public function findGst(Request $r){
    //header("Access-Control-Allow-Origin: *");
    $input=$r->all();

  //  dd($input);

   // dd();

    $url = "https://books.zoho.com/api/v3/meta/hsnsaccodes?search_text=".urlencode (\MS\Core\AI\Master::getLazyGiveAccurate($input['key'])); // http://localhost:8000/template/1/11
    $html =  file_get_contents($url)  ;
    $jdata=json_decode($html,true);
    return response()->json($jdata,200);

    return $html;
}

    public function findGstRate(Request $r){
        //header("Access-Control-Allow-Origin: *");
        $input=$r->all();

        $url = "https://www.paisabazaar.com/index.php"; // http://localhost:8000/template/1/11
        $html =  file_get_contents($url)  ;
        $url = "https://www.paisabazaar.com/wp-admin/admin-ajax.php?action=gst_ajax_action&text=".urlencode ($input['key']); // http://localhost:8000/template/1/11
        $html =  file_get_contents($url)  ;
        $jdata=json_decode($html,true);
        dd($jdata);
        return response()->json($jdata,200);

        return $html;
    }

    public function genarateInvoicePDFPost(Request $r){

//        $str='[{"name":"Demo","taxCode":"123\",\"unit\":\"10\",\"unitCost\":\"10\",\"unitName\":\"KG\",\"SGST\":10,\"CGST\":12,\"total\":122,\"value\":\"[{\\\"name\\\":\\\"Demo\\\",\\\"taxCode\\\":\\\"123\\\",\\\"unit\\\":\\\"10\\\",\\\"unitCost\\\":\\\"10\\\",\\\"unitName\\\":\\\"KG\\\",\\\"SGST\\\":10,\\\"CGST\\\":12,\\\"total\\\":122},{\\\"name\\\":\\\"Demo 1\\\",\\\"taxCode\\\":\\\"564\\\",\\\"unit\\\":\\\"10\\\",\\\"unitCost\\\":\\\"15253\\\",\\\"unitName\\\":\\\"KG\\\",\\\"SGST\\\":22880,\\\"CGST\\\":0,\\\"total\\\":175410},{\\\"name\\\":\\\"Demo 2\\\",\\\"taxCode\\\":\\\"65465343\\\",\\\"unit\\\":\\\"125\\\",\\\"unitCost\\\":\\\"10000\\\",\\\"unitName\\\":\\\"KG\\\",\\\"SGST\\\":62500,\\\"CGST\\\":231250,\\\"total\\\":1543750}]\",\"key\":\"msData\"}]';
//
//        dd(str_replace('\\',"",$str));

        $data=$r->input();
       // dd($data['msData']);
        //return response()->json($data['msData'],200);
        return view("BM.V.pdfInvoice")->with('msdata',$data);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view("BM.V.pdfInvoice")->with('msdata',$data)->render());
        return $pdf->stream();

        $pdf = \PDF::loadView('BM.V.pdfInvoice',['msdata'=>$data]);
       // dd($pdf);
        return $pdf->setPaper('a4', 'landscape')->download('invoice.pdf');
        //dd($r->input());
    }



}
