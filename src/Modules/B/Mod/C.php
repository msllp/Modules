<?php

namespace MS\Mod\B\Mod;

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
                'icon'=>'msicon-admin-user',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Master User Functions ',
                        'icon'=> 'fas fa-users-cog'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Master User',
                        'link'=> route('MOD.User.Master.AddForm'),
                        'icon'=>'fas fa-user-plus'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All Root Users',
                        'link'=> route('MOD.User.Master.View.All'),
                        'icon'=>'fas fa-users'
                    ],

                ],
            ],


            [
                'text'=>'Modules',
                'type'=>'mainNav',
                'icon'=>'msicon-modules',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Route Functions ',
                        'icon'=> 'msicon-route'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Route',
                        'link'=> route('MOD.User.Master.AddForm'),
                        'icon'=>'msicon-add'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All Routes',
                        'link'=> route('MOD.User.Master.View.All'),
                        'icon'=>'msicon-list'
                    ],

                ],
            ],


        ];
        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }


    public function addModuleFrom(){
        $m=F::getRootModuleModel();
        return $m->displayForm('add_user');
    }

    public function  saveMethodForMod(Request $r){

        $m=F::getRootModuleModel();
        $m->attachR($r);
        // $m->migrate();
        $d=$r->all();
        $valid=$m->checkRulesForData();

      //  $m->dataToProcess['ModuleAccess']='00';
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

    public function  viewAllMod(){
        $m=F::getRootModuleModel();
     //   $m->migrate();
        return $m->viewData('view_all');
    }

    public function viewAllModPagination(Request $r){

        $m=F::getRootModuleModel();
        return $m->ForPagination($r);
    }

    public function viewAllModRoutes(){
        $m=F::getRouteModel();
        return $m->viewData('view_all');
    }
    public function viewAllModRoutesPagination(Request $r){
        $m=F::getRouteModel();
        return $m->ForPagination($r);
    }

}
