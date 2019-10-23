<?php

namespace MS\Mod\B\Users;

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

    public function MaintainaceDashboard(){


        return view("MS::core.layouts.MS.mpanel");
    }


    public function SideNavForMaintainaceDashboard(Request $r){

        $rdata=['accessToken'=>'UserMitul'];
        $data=[
            [
                'text'=>'Users',
                'type'=>'mainNav',
                'icon'=>'fi flaticon-user',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Root User',
                        'icon'=> 'fi flaticon-problem'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Root User',
                        'link'=> route('MOD.User.Master.AddForm'),
                        'icon'=>'fi flaticon-partner'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All Root Users',
                        'link'=> route('MOD.User.Master.View.All'),
                        'icon'=>'fi flaticon-users-group'
                    ],

                ],
            ],


            [
                'text'=>'Modules',
                'type'=>'mainNav',
                'icon'=>'fi flaticon-distributed',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Modules',
                        'icon'=> 'fi flaticon-execution'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Module',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ]
                    ,[
                        'type'=> 'link',
                        'text'=> 'View All Modules',
                        'link'=> route('MOD.Mod.Master.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Routes',
                        'icon'=> 'fi flaticon-execution'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Route',
                        'link'=> route('MOD.Mod.Master.Route.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Routes',
                        'link'=> route('MOD.Mod.Master.Route.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Events',
                        'icon'=> 'fi flaticon-commerce-and-shopping-1'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add Event',
                        'link'=> route('MOD.Mod.Master.Event.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Events',
                        'link'=> route('MOD.Mod.Master.Route.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],

                ],
            ],


        ];
        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }


    public function addUserFrom(){
        $m=F::getRootUserModel();
        return $m->displayForm('add_user');
    }

    public function  saveUser(Request $r){

        $m=F::getRootUserModel();
        $m->attachR($r);
        // $m->migrate();
        $d=$r->all();
        $valid=$m->checkRulesForData();

        $nextData=[

            "modCode"=>"Core",
            "modDView"=>"New Tab",
            "modUrl"=>route('MOD.User.Master.View.All'),
        ];
       // dd($m->CurrentError);

        if($valid){

            //F::makeUser($r,$m);

            return response()->json(['ms'=>[

                'status'=>200,
               // 'Rdata'=> $r->input(),
                'ProcessStatus'=>[
                    'User added to DB'=>$m->add()],
                'nextData'=>$nextData

            ]],200);
        }
        else{
            return response()->json([
                'errors' => $m->CurrentError
            ],418);
            return $m->CurrentError;
        }

    }

    public function  viewAllUser(){
        $m=F::getRootUserModel();
     //   $m->migrate();
        return $m->viewData('view_all');
    }

    public function viewAllUserPagination(Request $r){

        $m=F::getRootUserModel();
        return $m->ForPagination($r);
    }
}
