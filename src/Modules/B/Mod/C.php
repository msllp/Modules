<?php

namespace MS\Mod\B\Mod;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\MSDB;
use mysql_xdevapi\Exception;
use Razorpay\Api;

class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=
        [
            'logo'=>"logo-a.png"

        ];




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
            "modUrl"=>route('MOD.Mod.Master.View.All'),
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


    public function addModuleRoutesFrom(){
        $m=F::getRouteModel();
        return $m->displayForm('add_routes');

    }

    public function saveMethodForModRoutes(Request $r){
        $m=F::getRouteModel();
        $m->attachR($r);
        // $m->migrate();
        $d=$r->all();
        $valid=$m->checkRulesForData();

        //  $m->dataToProcess['ModuleAccess']='00';
        $nextData=[

            "modCode"=>"Core",
            "modDView"=>"View All Routes",
            "modUrl"=>route('MOD.Mod.Master.Route.View.All'),
        ];
        // dd($m->CurrentError);

        if($valid){

            //F::makeUser($r,$m);

            $ModM=F::getRootModuleModel();
            $ModMData=$ModM->rowGet(['UniqId'=>$d['ModuleCode']]);
            $mod=reset($ModMData);

            $d['RouteUrl']=implode('/',[$mod['ModuleRoute'] , $d['RouteUrl'] ]);
            $d['RouteName']=implode('.',[ $mod['UniqId'],$d['RouteName'] ]);





            return response()->json(['ms'=>[

                'status'=>200,
                // 'Rdata'=> $r->input(),
                'ProcessStatus'=>[
                'User added to DB'=>$m->rowAdd($d)],
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


    public function viewAllModRoutes(){
        $m=F::getRouteModel();
        return $m->viewData('view_all');
    }
    public function viewAllModRoutesPagination(Request $r){
        $m=F::getRouteModel();
        return $m->ForPagination($r);
    }


    public function addModuleEventFrom(){
        $m=F::getEventModel();
        return $m->displayForm('add_event');
    }

    public function addModuleEventtoDB(Request $r){
        $m=F::getEventModel();
        //return $m->jsonOutError(['Oppes, Root user not updated in myrr system.']);
        $bd=$r->all();
        $d=$r->all();
        dd($d);
        if(!array_key_exists('UniqId',$d))$d['UniqId']=\MS\Core\Helper\comman::random(4);
        while(count($m->rowGet(['UniqId'=>$d['UniqId']])) > 0){
            $d['UniqId']=\MS\Core\Helper\comman::random(4);
        }

        if(array_key_exists('Routes',$d) && is_array($d['Routes'])){
               unset($d['Routes']);
            //$d['Routes']=[];
            ///  $d['Routes']=collect($d['Routes'])->toJson();
        }elseif (array_key_exists('Routes',$d) && gettype($d['Routes'])=='string' && $d['Routes']=='RouteName'){
            $bd['Routes']=[];
            unset($d['Routes']);
        }

        $t=[
            'User Roles to DB'=>$m->rowAdd($d,['UniqId','EventName']),
            'User Role Table Created'=>F::createModuleEventSub($d['UniqId'],$bd['Routes'])
        ];
dd($t);
        $nextDat=\MS\Core\Helper\Comman::makeNextData('Core','View All Events',route('MOD.Mod.Master.Event.View.All'));

        return $m->jsonOut($t,$nextDat);
        return response()->json(['ms'=>[

            'status'=>200,
             'Rdata'=> $bd['Routes'],
            'ProcessStatus'=>[
                'User Roles to DB'=>$m->rowAdd($d,['UniqId','EventName']),
                'User Role Table Created'=>F::createModuleEventSub($d['UniqId'],$bd['Routes'])
            ],
            'nextData'=>$nextData

        ]],200);
      //  return $m->rowAdd($d);

    }
    public function viewAllModEvents(){
        $m=F::getEventModel();
        return $m->viewData('view_all');
    }
    public function viewAllModEventsPagination(Request $r){
        $m=F::getEventModel();
        return $m->ForPagination($r);
    }

    public function deleteModEvent($id){

        $t=[
            'Mod Event delete'=> \MS\Mod\B\Mod\L\Mod::delete($id),

        ];
//dd($t);
        $nextDat=\MS\Core\Helper\Comman::makeNextData('Core','View All Events',route('MOD.Mod.Master.Event.View.All'));

        return \MS\Core\Helper\Comman::msJson($t,$nextDat);
    }

}
